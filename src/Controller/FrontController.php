<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Trick;

class FrontController extends Controller
{
    public function index()
    {
        return $this->render('front/index.html.twig', array('tricks' => $this->getDoctrine()->getRepository(Trick::class)->findAPage(0, $this->getParameter('tricks_per_page'))));
    }

    public function ajaxTricks($page)
    {
        $offset = $page * $this->getParameter('tricks_per_page');
        $tricks = $this->getDoctrine()->getRepository(Trick::class)->findAPage($offset, $this->getParameter('tricks_per_page'));

        $tricksData = [];
        $data = [];

        foreach ($tricks as $trick) {
            $trickData = array(
              "id" => $trick->getId(),
              "name" => $trick->getName(),
              "photo" => "no-photo.png",
            );
            if ($trick->getFrontPhoto() !== null) {
                $trickData['photo'] = $trick->getFrontPhoto()->getAdress();
            }
            $tricksData[] = $trickData;
        }
        $data['nbPages'] = $this->getDoctrine()->getRepository(Trick::class)->fingNbPages($this->getParameter('tricks_per_page'));
        $data['tricks'] = $tricksData;

        $JSONdata =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($JSONdata);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
