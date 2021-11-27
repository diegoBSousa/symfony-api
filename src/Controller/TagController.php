<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends AbstractApiController
{
    public function index(Request $req): Response
    {
        $currentPage = $req->query->get('page', 1);
        $pageSize = $req->query->get('limit', 4);
        $offset = ($currentPage - 1) * $pageSize;

        $tags = $this->getDoctrine()->getRepository(Tag::class)
            ->findBy([], ['id' => 'ASC'], $pageSize, $offset);

        return $this->response($tags);
    }

    public function create(Request $res): Response
    {
        $form = $this->buildForm(TagType::class);

        $form->handleRequest($res);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->response($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Tag $tag */
        $tag = $form->getData();

        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();

        return $this->response($tag);
    }

    public function delete(Request $req): Response
    {
        $tagId = $req->get('tagId');

        $tag = $this->getDoctrine()->getRepository(Tag::class)->findOneBy([
            'id' => $tagId
        ]);

        if (!$tag) {
            throw new NotFoundHttpException('Tag not found');
        }

        $this->getDoctrine()->getManager()->remove($tag);
        $this->getDoctrine()->getManager()->flush();

        return $this->response(null);
    }

    public function update(Request $req): Response
    {
        $tagId = $req->get('tagId');

        $tag = $this->getDoctrine()->getRepository(Tag::class)->findOneBy([
            'id' => $tagId
        ]);

        if (!$tag) {
            throw new NotFoundHttpException('Tag not found');
        }

        $form = $this->buildForm(
            TagType::class,
            $tag,
            [
                'method' => $req->getMethod()
            ]
        );

        $form->handleRequest($req);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->response($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Tag $tag */
        $tag = $form->getData();

        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();

        return $this->response($tag);
    }
}
