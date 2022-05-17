<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route(path="/", name="app_article_homepage", methods={"GET"})
     */
    public function homepage(Request $request): Response
    {
        //dd($request);
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route(path="/news/{slug}", name="app_article_show")
     */
    public function show(string $slug): Response
    {
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
            'slug' => $slug
        ]);
    }

    /**
     * @Route(path="/news/{slug}/heart", name="app_article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Request $request, LoggerInterface $logger): Response
    {
        // TODO - actually heart/unheart the article!
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts' => random_int(1, 100)]);
    }
}