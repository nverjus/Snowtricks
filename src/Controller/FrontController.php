<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\CommentType;

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
        $data['nbPages'] = $this->getDoctrine()->getRepository(Trick::class)->findNbPages($this->getParameter('tricks_per_page'));
        $data['tricks'] = $tricksData;

        $JSONdata =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($JSONdata);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function trick($id)
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->find($id);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAPage($id, 0, $this->getParameter('comments_per_page'));

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        return $this->render('front/trick.html.twig', array(
          'trick' => $trick,
          'comments' => $comments,
          'form' => $form->createView(),
        ));
    }

    public function ajaxComments($id, $page)
    {
        $offset = $page * $this->getParameter('comments_per_page');
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAPage($id, $offset, $this->getParameter('comments_per_page'));

        $commentsData = [];
        $data = [];

        foreach ($comments as $comment) {
            $commentData = array(
              'publicationDate' => $comment->getCreationDate()->format('d-m-Y'),
              'content' => $comment->getContent(),
              'user' => array(
                'name' => $comment->getUser()->getUsername(),
                'photo' => 'default.png',
              ),
            );
            if ($comment->getUser()->getUserPhoto() !== null) {
                $commentData['user']['photo'] = $comment->getUser()->getUserPhoto()->getAdress();
            }
            $commentsData[] = $commentData;
        }
        $data['nbPages'] = $this->getDoctrine()->getRepository(Comment::class)->findNbPages($id, $this->getParameter('comments_per_page'));
        $data['comments'] = $commentsData;

        $JSONdata =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($JSONdata);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
