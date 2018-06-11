<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\User;

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
            $tricksData[] = $trick->ajaxData();
        }
        $data['nbPages'] = $this->getDoctrine()->getRepository(Trick::class)->findNbPages($this->getParameter('tricks_per_page'));
        $data['tricks'] = $tricksData;

        $JSONdata =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($JSONdata);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function trick(Trick $trick, Request $request)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAPage($trick->getId(), 0, $this->getParameter('comments_per_page'));

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
              'comment-notice',
              'Your comment has been saved'
            );
            return $this->redirect($this->generateUrl('trick', array('id' => $trick->getId())).'#comment-form');
        }

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
            $commentsData[] = $comment->ajaxData();
        }
        $data['nbPages'] = $this->getDoctrine()->getRepository(Comment::class)->findNbPages($id, $this->getParameter('comments_per_page'));
        $data['comments'] = $commentsData;

        $JSONdata =  $this->get('serializer')->serialize($data, 'json');

        $response = new Response($JSONdata);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
