<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;
use App\Entity\Trick;
use App\Entity\TrickPhoto;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\TrickPhotoType;

class BackController extends Controller
{
    public function editTrick(Trick $trick, Request $request, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();
        $trickPhotos = $trick->getTrickPhotos();
        $trick->resetTrickPhotos();
        $videos = $trick->getVideos();
        $trick->resetVideos();

        $trickForm = $this->createForm(TrickType::class, $trick);
        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick = $trickForm->getData();
            $trick->setUpdateDate(new \DateTime());
            // Photos management
            foreach ($trick->getTrickPhotos() as $photo) {
                if ($photo->getAdress() !== null) {
                    $filename = $imageUploader->upload($photo->getAdress(), $this->getParameter('tricks_photos_directory'));
                    $photo->setAdress($filename);
                    $photo->setTrick($trick);
                } elseif ($photo->getAdress() === null) {
                    $trick->removeTrickPhoto($photo);
                }
            }
            foreach ($trickPhotos as $photo) {
                $trick->addTrickPhoto($photo);
            }
            // Videos management
            foreach ($trick->getVideos() as $video) {
                if ($video->getIframe() !== null) {
                    $video->setTrick($trick);
                } elseif ($video->getIframe() === null) {
                    $trick->removeVideo($video);
                }
            }
            foreach ($videos as $video) {
                $trick->addVideo($video);
            }

            $manager->persist($trick);
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
            $fileName = $imageUploader->upload($frontPhoto->getAdress(), $this->getParameter('tricks_photos_directory'));
            $frontPhoto->setAdress($fileName);
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

    public function addTrick(Request $request, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $form->getData();
            $trick->setUpdateDate(new \DateTime());
            // Photos management
            foreach ($trick->getTrickPhotos() as $photo) {
                if ($photo->getAdress() !== null) {
                    $filename = $imageUploader->upload($photo->getAdress(), $this->getParameter('tricks_photos_directory'));
                    $photo->setAdress($filename);
                    $photo->setTrick($trick);
                } elseif ($photo->getAdress() === null) {
                    $trick->removeTrickPhoto($photo);
                }
                $trick->setFrontPhoto($trick->getTrickPhotos()[0]);
            }
            // Videos management
            foreach ($trick->getVideos() as $video) {
                if ($video->getIframe() !== null) {
                    $video->setTrick($trick);
                } elseif ($video->getIframe() === null) {
                    $trick->removeVideo($video);
                }
            }

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

    public function deleteTrickPhoto(TrickPhoto $photo, ImageUploader $imageUploader)
    {
        $manager = $this->getDoctrine()->getManager();
        if ($photo->getTrick()->getFrontPhoto() == $photo) {
            $photo->getTrick()->setFrontPhoto(null);
        }
        $imageUploader->remove($photo->getAdress(), $this->getParameter('tricks_photos_directory'));
        $manager->remove($photo);
        $manager->flush();

        $this->addFlash(
          'notice',
          'The photo has been deleted'
        );

        return $this->redirect($this->generateUrl('edit_trick', array('id' => $photo->getTrick()->getId())).'#content');
    }

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

    public function deleteFrontPhoto(Trick $trick, ImageUploader $imageUploader)
    {
        $photo = $trick->getFrontPhoto();
        $trick->setFrontPhoto(null);
        $imageUploader->remove($photo->getAdress(), $this->getParameter('tricks_photos_directory'));
        $manager->remove($photo);
        $manager->flush();

        $this->addFlash(
          'notice',
          'The photo has been deleted'
        );

        return $this->redirect($this->generateUrl('edit_trick', array('id' => $photo->getTrick()->getId())).'#content');
    }
}
