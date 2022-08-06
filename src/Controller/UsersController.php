<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class UsersController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Response
     * @Route("signIn/", name="signIn")
     */
    public function signIn(): Response {

        return new Response($this->twig->render('users/signIn.html.twig'));
    }
}