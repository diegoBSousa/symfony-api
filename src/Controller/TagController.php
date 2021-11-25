<?php

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;

class TagController extends AbstractApiController
{
    public function index(): Response
    {
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        return $this->response($tags);
    }
}
