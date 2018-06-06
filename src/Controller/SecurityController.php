<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\ImageUploader;
use App\Entity\User;
use App\Form\UserType;
use App\Form\EditUserType;
use App\Form\ForgotPasswordType;

class SecurityController extends Controller
{
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));
    }


    public function register(Request $request, ImageUploader $uploader, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getUserPhoto()->getAdress() !== null) {
                $filename = $uploader->upload($user->getUserPhoto()->getAdress(), $this->getParameter('users_photos_directory'));
                $user->getUserPhoto()->setAdress($filename);
            } elseif ($user->getUserPhoto()->getAdress() === null) {
                $user->setUserPhoto(null);
            }
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $manager->persist($user);
            $manager->flush();

            $message = (new \Swift_Message('Snowtricks, account activation'))
                ->setFrom('nverjus@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('emails/activation.html.twig', array('user' => $user)), 'text/html');

            $mailer->send($message);

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
     */
    public function editUser(Request $request, ImageUploader $uploader, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $user->getUserPhoto() !== null ? $photo = $user->getUserPhoto() : $photo = null;
        $user->setUserPhoto(null);
        $oldPassword = $user->getPassword();


        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getUserPhoto() !== null) {
                $filename = $uploader->upload($user->getUserPhoto()->getAdress(), $this->getParameter('users_photos_directory'));
                $user->getUserPhoto()->setAdress($filename);
            } elseif ($user->getUserPhoto() === null) {
                $user->setUserPhoto($photo);
            }
            $user->getPassword() === null ? $user->setPassword($oldPassword) : $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
            'notice',
            'Your account has been edited'
          );
            return $this->redirect($this->generateUrl('index').'#content');
        }

        return $this->render('security/editUser.html.twig', array('form' => $form->createView()));
    }

    public function activateAccount(User $user)
    {
        if ($user->isEnabled()) {
            throw $this->createNotFoundException('This account is already enabled');
        }

        $user->setIsActive(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->render('security/activateAccount.html.twig');
    }

    public function forgotPassword(Request $request)
    {
        $data = [];

        $form = $this->createForm(ForgotPasswordType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $data['username']]);

            if ($user !== null) {
                $this->addFlash(
              'notice',
              'An email has been sent to your adress'
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
}
