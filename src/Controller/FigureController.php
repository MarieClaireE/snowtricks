<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Entity\Images;
use App\Entity\Videos;
use App\Form\TricksFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FigureController extends AbstractController
{
    /**
     *  @var Environment
     */
    private $twig;

	/***
	 * @var EntityManagerInterface
	 */
		private $em;

    public function __construct(Environment $twig, EntityManagerInterface $em)
    {
        $this->twig = $twig;
				$this->em = $em;
    }

    /**
     * @Route("/tricks/new", name="create_trick")
     */
    public function createTrick(Request $request): Response
    {
        $isConnect = $this->getUser();

				$form = $this->createForm(TricksFormType::class);
				$form->handleRequest($request);

				if($form->isSubmitted() && $form->isValid()) {
					$trick = new Figures();
					$name = $form->get('name')->getData();
					$trick->setName($form->get('name')->getData());

					$trick->setDescription($form->get('description')->getData());
					$trick->setSlug('figure_'.$name);
					$trick->setGroupe(1);

					$images = [];
					$fichiers = [];

					$images1 = $form->get('images')->getData();
					$images2 = $form->get('images2')->getData();
					$images3 = $form->get('images3')->getData();

					$images = [
						$images1,
						$images2,
						$images3
					];


					foreach($images as $image) {
						if($image !== null) {
							$fichier =
								md5(uniqid()).'.'.$image->guessExtension();
							$image->move(
								$this->getParameter('images_directory'), $fichier
							);


							$fichiers [] = $fichier;

							$trick->setImages($fichiers);
							// dd($image);
							foreach($image as $img) {
								$fichier =
									md5(uniqid()).'.'.$img->guessExtension();
								$img->move(
									$this->getParameter('images_directory'), $fichier
								);


								$fichiers [] = $fichier;

								$trick->setImages($fichiers);
							}

						}
					}

					$videos = [];
					$files = [];

					$videos1 = $form->get('videos')->getData();
					$videos2 = $form->get('videos2')->getData();
					$videos3 = $form->get('videos3')->getData();

					$videos = [
						$videos1,
						$videos2,
						$videos3
					];

					foreach($videos as $video) {
						if($video !== null) {
							$file =
								md5(uniqId()).'.'.$video->guessExtension();
							$video->move(
								$this->getParameter('images_directory'), $file
							);

							$files[] = $file;
							$trick->setVideos($files);

							foreach($video as $vid) {
								$file =
									md5(uniqId()).'.'.$vid->guessExtension();
								$vid->move(
									$this->getParameter('images_directory'), $file
								);

								$files[] = $file;
								$trick->setVideos($files);
							}
						}
					}

					$this->em->persist($trick);
					$this->em->flush();
					$this->addFlash('success', 'Figure crée avec succès !');

				}

        return new Response($this->twig->render('tricks/new_tricks.html.twig', [
            'isConnect' => $isConnect,
	          'formTricks' => $form->createView()
        ]));
    }

    /**
     * @Route("/tricks/update/{trick}", name="update_trick")
     */
    public function updateTrick(Request $request, Figures $trick): Response
    {
        return new Response($this->twig->render('tricks/update_tricks.html.twig'));
    }

		/**
		 * @Route("/tricks/suppression/image", name="tricks_delete")
		 */
		public function deleteImage(Request $request, Images $image)
		{
			$data = json_decode($request->getContent(), true);

			if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token']))
			{
				$nom = $image->getName();
				unlink(
					$this->getParameter('images_directory').'/'.$nom
				);
				$this->em->remove($image);
				$this->em->flush();

				return new JsonResponse(['success' => 1]);

			} else {
				return new JsonResponse(['error' => 'Token Invalide'], 400);
			};
		}

}