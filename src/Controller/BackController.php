<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\ImageUploader;
use App\Entity\Trick;
use App\Entity\TrickPhoto;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\TrickPhotoType;

class BackController extends Controller
{
    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function editTrick(Trick $trick, Request $request, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();
        $trickPhotos = $trick->resetTrickPhotos();
        $videos = $trick->resetVideos();

        $trickForm = $this->createForm(TrickType::class, $trick);
        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick->processTrick($this->getParameter('tricks_photos_directory'), $imageUploader, $trickPhotos, $videos);

            $manager->flush();

            $this->addFlash(
              'trick-notice',
              'The trick has been saved'
            );
            return $this->redirect($this->generateUrl('trick', array('id' => $trick->getId())).'#content');
        }
        $trick->setTrickPhotos($trickPhotos);
        $trick->setVideos($videos);

        $frontPhoto = new TrickPhoto();
        $frontPhotoForm = $this->createForm(TrickPhotoType::class, $frontPhoto);
        $frontPhotoForm->handleRequest($request);

        if ($frontPhotoForm->isSubmitted() && $frontPhotoForm->isValid()) {
            $frontPhoto->add($this->getParameter('tricks_photos_directory'), $imageUploader);
            $frontPhoto->setTrick($trick);
            $trick->setFrontPhoto($frontPhoto);

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash('trick-notice', 'Front Photo added');
            return $this->redirect($this->generateUrl('trick', array('id' => $trick->getId())).'#content');
        }

        return $this->render('back/editTrick.html.twig', array(
          'trick' => $trick,
          'trickForm' => $trickForm->createView(),
          'frontPhotoForm' => $frontPhotoForm->createView(),
        ));
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function addTrick(Request $request, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->processTrick($this->getParameter('tricks_photos_directory'), $imageUploader);
            $trick->setFrontPhoto($trick->getTrickPhotos()[0]);

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
              'notice',
              'The trick has been saved'
            );
            return $this->redirect($this->generateUrl('index').'#content');
        }

        return $this->render('back/addTrick.html.twig', array(
          'form' => $form->createView(),
        ));
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function deleteVideo(Video $video)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($video);
        $manager->flush();

        $this->addFlash(
          'notice',
          'The video has been deleted'
        );

        return $this->redirect($this->generateUrl('edit_trick', array('id' => $video->getTrick()->getId())).'#content');
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function deleteTrickPhoto(TrickPhoto $photo, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();
        $photo->delete($imageUploader, $this->getParameter('tricks_photos_directory'));
        $manager->remove($photo);
        $manager->flush();

        $this->addFlash(
          'notice',
          'The photo has been deleted'
        );

        return $this->redirect($this->generateUrl('edit_trick', array('id' => $photo->getTrick()->getId())).'#content');
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function deleteTrick(Trick $trick, ImageUploader $uploader)
    {
        $trick->setFrontPhoto(null);

        foreach ($trick->getTrickPhotos() as $photo) {
            $trick->removeTrickPhoto($photo);
            $uploader->remove($photo->getAdress(), $this->getParameter('tricks_photos_directory'));
            $this->getDoctrine()->getManager()->remove($photo);
        }
        foreach ($trick->getVideos() as $video) {
            $trick->removeVideo($video);
            $this->getDoctrine()->getManager()->remove($video);
        }
        foreach ($trick->getComments() as $comment) {
            $trick->removeComment($comment);
            $this->getDoctrine()->getManager()->remove($comment);
        }
        $this->getDoctrine()->getManager()->flush();

        $this->getDoctrine()->getManager()->remove($trick);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
        'notice',
        'The trick has been deleted'
      );

        return $this->redirect($this->generateUrl('index').'#content');
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
     */
    public function deleteFrontPhoto(Trick $trick, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();

        $photo = $trick->getFrontPhoto();
        $photo->delete($imageUploader, $this->getParameter('tricks_photos_directory'));
        $manager->remove($photo);
        $manager->flush();

        $this->addFlash(
          'notice',
          'The photo has been deleted'
        );

        return $this->redirect($this->generateUrl('edit_trick', array('id' => $photo->getTrick()->getId())).'#content');
    }
}
