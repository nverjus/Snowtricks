<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trick;
use App\Form\TrickType;

class BackController extends Controller
{
    public function editTrick($id, Request $request)
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->find($id);

        $trickForm = $this->createForm(TrickType::class, $trick);

        return $this->render('back/editTrick.html.twig', array(
          'trick' => $trick,
          'trickForm' => $trickForm->createView(),
        ));
    }
}
