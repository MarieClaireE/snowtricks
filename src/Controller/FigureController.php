<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FigureController extends AbstractController
{
    /**
     *  @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/create/trick", name="create_trick")
     */
    public function createTricks(): Response
    {
        return new Response($this->twig->render('tricks/new_tricks.html.twig'));
    }

}