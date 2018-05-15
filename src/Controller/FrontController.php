<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Trick;

class FrontController extends Controller
{
    public function index()
    {
        return $this->render('front/index.html.twig', array('tricks' => $this->getDoctrine()->getRepository(Trick::class)->findAPage(1, $this->getParameter('tricks_per_page'))));
    }
}
