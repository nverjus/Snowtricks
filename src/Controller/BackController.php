<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trick;
use App\Entity\TrickPhoto;
use App\Form\TrickType;
use App\Form\TrickPhotoType;

class BackController extends Controller
{
    public function editTrick($id, Request $request)
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->find($id);


        $trickForm = $this->createForm(TrickType::class, $trick);
        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();

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

        return $this->render('back/editTrick.html.twig', array(
          'trick' => $trick,
          'trickForm' => $trickForm->createView(),
          'photoForm' => $photoForm->createView()
        ));
    }
}
