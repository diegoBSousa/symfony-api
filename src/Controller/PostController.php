<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractApiController
{
    public function index(Request $req): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->json($posts);
    }

    public function create(Request $req)
    {
        $form = $this->buildForm(PostType::class);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // throw exception
            echo 'Error';
            exit;
        }

        /** @var Post $post */
        $post = $form->getData();

        $this->getDoctrine()->getManager()->persist($customer);
        $this->getDoctrine()->getManager()->flush();

        return $this->json([]);
    }
}
