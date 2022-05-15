<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route(path="/", name="app_homepage", methods={"GET"})
     */
    public function homepage(): Response
    {
        return new Response("OMG!");
    }
}