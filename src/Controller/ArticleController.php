<?php

namespace App\Controller;

use App\Helper\LoggerTrait;
use App\Service\Markdown\MarkdownHelper;
use HelloWorld\SayHello;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    use LoggerTrait;

    /**
     * @Route(path="/", name="app_article_homepage", methods={"GET"})
     */
    public function homepage(Request $request, SayHello $hello): Response
    {
        //dd($request);
        return $this->render('article/homepage.html.twig', [
            'hello-world-packagist' => $hello::world()
        ]);
    }

    /**
     * @Route(path="/news/{slug}", name="app_article_show")
     */
    public function show(string $slug, MarkdownHelper $markdownHelper): Response
    {
        $articleContent = <<<EOF
        Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
        lorem proident [beef ribs](https://baconipsum.com/)  aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
        labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
        turkey shank eu pork belly meatball non cupim.
        Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
        laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
        capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
        picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
        occaecat lorem meatball prosciutto quis strip steak.
        Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
        mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
        strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
        cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
        fugiat.
        EOF;

        $articleContent = $markdownHelper->parse($articleContent);

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'articleContent' => $articleContent,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route(path="/news/{slug}/heart", name="app_article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(): Response
    {
        // TODO - actually heart/unheart the article!

        $this->logInfo('Article is being hearted!');
        return new JsonResponse(['hearts' => random_int(1, 100)]);
    }
}