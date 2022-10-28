<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\Figures;
use App\Entity\Photos;
use App\Entity\Videos;
use App\Form\CommentaireType;
use App\Form\TricksFormType;
use App\Repository\FiguresRepository;
use App\Repository\ImagesRepository;
use App\Repository\PhotosRepository;
use App\Repository\VideosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\NodeVisitor\TranslationDefaultDomainNodeVisitor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
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

	/**
	 * @var FiguresRepository
	 */
	private $repository;

    public function __construct(Environment $twig, EntityManagerInterface $em, FiguresRepository $repository)
    {
        $this->twig = $twig;
				$this->em = $em;
				$this->repository = $repository;
    }


	/**
	 * @Route("figure/edit/{id}", name="edit_figure")
	 */
	public function edit(Request $request, ?int $id = null): Response
	{
		$isConnect = $this->getUser();

		$figure = $this->repository->findOneBy(["id" => $id]);

		/**
		 * @var PhotosRepository $photoRepository
		 */
		$photoRepository = $this->em->getRepository(Photos::class);
		$photos = $photoRepository->findBy(['figureId' => $id]);

		/**
		 * @var VideosRepository $videoRepository
		 */
		$videoRepository =$this->em->getRepository(Videos::class);
		$videos = $videoRepository->findBy(['figure' => $id]);

		if($figure === null) {
			$figure = new Figures();
		}
		if($photos === null) {
			$photos = new Photos();
		}

		// dd($figure->getPhotos());

		$form = $this->createForm(TricksFormType::class, $figure);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$figure->setName($form->get('name')->getData());
			$figure->setDescription($form->get('description')->getData());
			$name = $form->get('name')->getData();
			$name = str_replace(' ', '_', $name);
			$figure->setSlug('figure_'.$name);

			$figure->setGroupe($form->get('groupe')->getData());
			$figure->setAjouteLe(new \DateTime());

			$imagePresentation = $form->get('photoPresentation')->getData();
			if(null !== $imagePresentation) {
				$file = md5(uniqid()).'.'.$imagePresentation->guessExtension();
				$imagePresentation->move(
					$this->getParameter('images_directory'), $file
				);
				$figure->setPhotoPresentation($file);
			}

			$images = $form->get('photos')->getData();

			foreach ($images as $img) {
					$fichier =
						md5(uniqid()).'.'.$img->guessExtension();
					$img->move(
						$this->getParameter('images_directory'), $fichier
					);
					$photo = new Photos();
					$photo->setName($fichier);
					$photo->setFigureId($figure);
					$this->em->persist($photo);
			}

			$videos[] = $form->get('videos')->getData();
			foreach($videos as $video) {
				if($video !== null) {
					foreach($video as $vid) {
						$file =
							md5(uniqId()).'.'.$vid->guessExtension();
						$vid->move(
							$this->getParameter('images_directory'), $file
						);
						$v = new Videos();
						$v->setName($file);
						$v->setFigure($figure);
						$this->em->persist($v);
					}
				}
			}

			if($figure->getId() !== null) {
				$figure->setModifieLe(new \DateTime());
			}
			$this->em->persist($figure);
			$this->em->flush();

			$this->addFlash('success', 'Figure enregistrée!');

			return $this->redirectToRoute('accueil');

		}

		return new Response($this->twig->render('tricks/new_tricks.html.twig', [
			'isConnect' => $isConnect,
			'formTricks' => $form->createView(),
			'figure'=>$figure,
			'photos' => $photos,
			'videos' => $videos
		]));
	}


		/** * @Route("/suppression/photo/{id}", name="delete_image") */
		public function deleteImage(?int $id, Request $request)
		{
			/** @var ImagesRepository $imageRepository */
			$imageRepository = $this->em->getRepository(Photos::class);
			$image = $imageRepository->findOneBy(['id' => $id]);
			$this->em->remove($image);
			$this->em->flush();
				 // On répond en json
				return $this->redirect($this->generateUrl('edit_figure', [
					'id' => $image->getFigureId()->getId()
				]));
		}

	/**
	 * @Route("/suppression/video/{id}", name="delete_video")
	 */
	public function deleteVideo(int $id, Request $request) {

		/** @var VideosRepository $videoRepository */
		$videoRepository = $this->em->getRepository(Videos::class);
		$video = $videoRepository->findOneBy(['id' =>  $id]);
		$this->em->remove($video);
		$this->em->flush();


		//on répond en json
		return $this->redirect($this->generateUrl('edit_figure', [
			'id' => $video->getFigure()->getId()
		]));
	}

		/**
		 * @Route("/figure/{trickId}/{trickslug}", name="trick")
		 */
		public function presentationFigure(
			Request $request,
			?int $trickId = null,
			?string $trickslug = null
		)
		{
			$groupes = [];

			$isConnect = $this->getUser();

			$trick = $this->repository->findOneBy([
				'id' => $trickId,
				'slug' => $trickslug
			]);

			/**
			 * @var PhotosRepository $photoRepository
			 */
			$photoRepository = $this->em->getRepository(Photos::class);
			$photos = $photoRepository->findBy(['figureId' => $trick]);

			/**
			 * @var VideosRepository $videoRepository
			 */
			$videoRepository =$this->em->getRepository(Videos::class);
			$videos = $videoRepository->findBy(['figure' => $trick]);

			$groupes[$trick->getId()] = Figures::GROUP_LABELS[$trick->getGroupe()];


			// form comments
			// on crée le commentaire vierge
			$comment = new Commentaires();
			// on génère le formulaire
			$form = $this->createForm(CommentaireType::class, $comment);
			$form->handleRequest($request);

			//traitement du formulaire
			if($form->isSubmitted() && $form->isValid()){
				$comment->setAjouteLe(new \DateTime());
				$comment->setFigureId($trick);
				$comment->setUserId($this->getUser());

				// on récupère le contenu du champ parentId
				$parentId = $form->get('parentId')->getData();
				//on va chercher le commentaire corrrespondant
				if(isset($parentId)) {
					$parent = $this->em->getRepository(Commentaires::class)
						->find($parentId);
					//on définit le parent
					$comment->setParent($parent);
				}

				$this->em->persist($comment);
				$this->em->flush();

				$this->addFlash('message', 'Votre commentaire
				a bien été envoyé!');

				return $this->redirect($this->generateUrl('trick', [
					'trickId' => $trick->getId(),
					'trickslug' => $trick->getSlug()
				]));
			}



			return new Response($this->twig->render('tricks/presentationTricks.html.twig', [
				'isConnect' =>$isConnect,
				'trick' => $trick,
				'groupes' => $groupes,
				'photos' => $photos,
				'videos' => $videos,
				'form' => $form->createView()
			]));
		}

		/**
		 * @Route("supprimer/figure/{id}/", name="figure_remove")
		 */
		public function remove(Request $request, int $id ){

			$figure = $this->repository->findOneBy(["id" => $id]);

			/**
			 * @var PhotosRepository $photoRepository
			 */
			$photoRepository = $this->em->getRepository(Photos::class);
			$photos = $photoRepository->findBy(['figureId' => $figure->getId()]);

			foreach($photos as $photo){
				$this->em->remove($photo);
			}

			if(!$figure){
				throw $this->createNotFoundException('Cette figure n\'existe pas');
			}

			$this->em->remove($figure);
			$this->em->flush();
			$this->addFlash('success', 'Figure effacé avec succès');

			return $this->redirect($this->generateUrl('accueil'));
		}

}