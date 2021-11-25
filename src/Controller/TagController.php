<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends AbstractApiController
{
    public function index(): Response
    {
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();
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
}
