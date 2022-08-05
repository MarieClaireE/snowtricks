<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class HomeController extends AbstractController {

    /**
     *  @var Environment
     */
    private $twig; 

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Page d'accueil
     * @Route("/home", name="accueil")
     */
    public function index(): Response
    {
        return new Response($this->twig->render('home/home.html.twig'));
    }

    /**
     * Page de tricks
     * @Route("/tricks", name="list_tricks")
     */
    public function listTricks(): Response
    {
        return new Response($this->twig->render('home/list_tricks.html.twig'));
    }
}
