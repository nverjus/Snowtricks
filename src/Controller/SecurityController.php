<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\ImageUploader;
use App\Service\Mailer;
use App\Entity\User;
use App\Form\UserType;
use App\Form\EditUserType;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;

class SecurityController extends Controller
{
    /**
     * @Route("/login",
     *        name="login"
     * )
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();


        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));
    }

    /**
     * @Route("/register",
     *        name="register"
     * )
     */
    public function register(Request $request, ImageUploader $uploader, Mailer $mailer)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $user->getUserPhoto()->getAdress()) {
                $filename = $uploader->upload($user->getUserPhoto()->getAdress(), $this->getParameter('users_photos_directory'));
                $user->getUserPhoto()->setAdress($filename);
            } elseif (null === $user->getUserPhoto()->getAdress()) {
                $user->setUserPhoto(null);
            }
            $mailer->sendAccountActivationEmail($user, $this->renderView('emails/activation.html.twig', array('user' => $user)));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
            'notice',
            'Your account has been created, an activation link has been sent to '.$user->getEmail()
          );
            return $this->redirect($this->generateUrl('index').'#content');
        }

        return $this->render('security/register.html.twig', array('form' => $form->createView()));
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/user/edit",
     *        name="edit_user"
     * )
     */
    public function editUser(Request $request, ImageUploader $uploader)
    {
        $user = $this->getUser();
        $user->getUserPhoto() !== null ? $photo = $user->getUserPhoto() : $photo = null;
        $user->setUserPhoto(null);
        $user->setOldPassword($user->getPassword());


        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $user->getUserPhoto()) {
                $filename = $uploader->upload($user->getUserPhoto()->getAdress(), $this->getParameter('users_photos_directory'));
                $user->getUserPhoto()->setAdress($filename);
            } elseif (null === $user->getUserPhoto()) {
                $user->setUserPhoto($photo);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
            'notice',
            'Your account has been edited'
          );
            return $this->redirect($this->generateUrl('index').'#content');
        }

        return $this->render('security/editUser.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/activate/{token}",
     *        name="activate_account"
     * )
     */
    public function activateAccount(User $user)
    {
        if ($user->getIsActive()) {
            throw $this->createNotFoundException('This account is already enabled');
        }

        $user->setIsActive(true);
        $user->resetToken();
        $this->getDoctrine()->getManager()->flush();
        return $this->render('security/activateAccount.html.twig');
    }

    /**
     * @Route("/forgot-password",
     *        name="forgot_password"
     * )
     */
    public function forgotPassword(Request $request, Mailer $mailer)
    {
        $data = [];

        $form = $this->createForm(ForgotPasswordType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $data['username']]);

            if (null !== $user) {
                $mailer->sendResetPasswordEmal($user, $this->renderView('emails/forgotPassword.html.twig', array('user' => $user)));
                $this->addFlash(
              'notice',
              'An email has been sent to your email adress'
            );
                return $this->redirect($this->generateUrl('index').'#content');
            }
            $this->addFlash(
            'notice',
            'This username does not exists'
          );
        }

        return $this->render('security/forgotPassword.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/reset/{token}",
     *        name="reset_password"
     * )
     */
    public function resetPassword(User $user, Request $request)
    {
        $data = [];

        $form = $this->createForm(ResetPasswordType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data['email'] === $user->getEmail()) {
                $user->setOldPassword($user->getPassword());
                $user->setPassword($data['password']);
                $user->resetToken();
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash(
          'notice',
          'Your password has been updated'
        );
                return $this->redirect($this->generateUrl('index').'#content');
            }
            $this->addFlash(
          'notice',
          'Invalid email adress'
        );
        }

        return $this->render('security/resetPassword.html.twig', array('form' => $form->createView()));
    }
}
