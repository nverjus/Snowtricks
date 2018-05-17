<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;
use App\Entity\Trick;
use App\Entity\TrickPhoto;
use App\Form\TrickType;
use App\Form\TrickPhotoType;

class BackController extends Controller
{
    public function editTrick($id, Request $request, ImageUploader $imageUploader)
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->find($id);
        $manager = $this->getDoctrine()->getManager();


        $trickForm = $this->createForm(TrickType::class, $trick);
        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick = $trickForm->getData();
            $trick->setUpdateDate(new \DateTime());

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
              'trick-notice',
              'Your trick has been saved'
            );
            return $this->redirect($this->generateUrl('trick', array('id' => $id)).'#content');
        }

        $photo = new TrickPhoto();
        $photoForm = $this->createForm(TrickPhotoType::class, $photo);
        $photoForm->handleRequest($request);

        if ($photoForm->isSubmitted() && $photoForm->isValid()) {
            $fileName = $imageUploader->upload($photo->getAdress(), $this->getParameter('tricks_photos_directory'));
            $photo->setAdress($fileName);
            $photo->setTrick($trick);

            $manager->persist($photo);
            $manager->flush();

            $this->addFlash('trick-notice', 'Photo added');
            return $this->redirect($this->generateUrl('trick', array('id' => $id)).'#content');
        }


        return $this->render('back/editTrick.html.twig', array(
          'trick' => $trick,
          'trickForm' => $trickForm->createView(),
          'photoForm' => $photoForm->createView()
        ));
    }
}
