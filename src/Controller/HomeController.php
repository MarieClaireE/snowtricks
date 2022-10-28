<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Entity\Photos;
use App\Repository\FiguresRepository;
use App\Repository\PhotosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class HomeController extends AbstractController {

    /**
     *  @var Environment
     */
    private $twig;

		/**
		 * @var EntityManagerInterface
		 */
		private $em;

		/**
	  * @param Environment $twig
	  * @param EntityManagerInterface $em
	  */
    public function __construct(Environment $twig, EntityManagerInterface $em)
    {
        $this->twig = $twig;
				$this->em =$em;
    }

    /**
     * Page d'accueil
     * @Route("/home", name="accueil")
     */
    public function index(Request $request): Response
    {
	    /**
	     * @var FiguresRepository $repository
	     */
			$repository = $this->em->getRepository(Figures::class);
			$tricks = $repository->findAll();


			/** @var PhotosRepository $photoRepository */
	    $photoRepository = $this->em->getRepository(Photos::class);
			$photos = $photoRepository->findAll();

			$images = [];

			foreach($tricks as $trick) {
				if(!empty($photos)){
					foreach($photos as $photo) {
						if($trick->getId() === $photo->getFigureId()->getId()) {
							$images[$trick->getId()][$photo->getId()] = $photo->getName();
						}
					}

				}
			}


      $route = __DIR__;
      $isConnect = $this->getUser();

      return new Response($this->twig->render('home/home.html.twig',
      [
          'isConnect' => $isConnect,
          'route' => $route,
	        'tricks' =>$tricks,
	        'photos' => $images
      ]));
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
