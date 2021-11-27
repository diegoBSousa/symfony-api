<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends AbstractApiController
{
    public function index(Request $req): Response
    {

        $currentPage = $req->query->get('page', 1);
        $pageSize = $req->query->get('limit', 4);
        $offset = ($currentPage - 1) * $pageSize;

        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findBy([], ['id' => 'ASC'], $pageSize, $offset);

        return $this->response($posts);
    }

    public function create(Request $req)
    {
        $form = $this->buildForm(PostType::class);

        $form->handleRequest($req);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->response($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Post $post */
        $post = $form->getData();

        $this->getDoctrine()->getManager()->persist($post);
        $this->getDoctrine()->getManager()->flush();

        return $this->response($post);
    }

    public function delete(Request $req): Response
    {
        $postId = $req->get('postId');

        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy([
            'id' => $postId
        ]);

        if (!$post) {
            throw new NotFoundHttpException('Post not found');
        }

        $this->getDoctrine()->getManager()->remove($post);
        $this->getDoctrine()->getManager()->flush();

        return $this->response(null);
    }

    public function update(Request $req): Response
    {
        $postId = $req->get('postId');

        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy([
            'id' => $postId
        ]);

        if (!$post) {
            throw new NotFoundHttpException('Post not found');
        }

        $form = $this->buildForm(
            PostType::class,
            $post,
            [
                'method' => $req->getMethod()
            ]
        );

        $form->handleRequest($req);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->response($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Post $post */
        $post = $form->getData();

        $this->getDoctrine()->getManager()->persist($post);
        $this->getDoctrine()->getManager()->flush();

        return $this->response($post);
    }
}
