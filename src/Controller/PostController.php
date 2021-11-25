<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractApiController
{
    #[Route('/post', name: 'post')]
    public function index(Request $req): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->json($posts);
    }
}
