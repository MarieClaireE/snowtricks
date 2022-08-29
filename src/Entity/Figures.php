<?php

namespace App\Entity;

use App\Repository\FiguresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FiguresRepository::class)]
class Figures
{
		const GRABS = 1;
		const ROTATIONS = 2;
		const FLIPS = 3;
		const ROTAION_DESAXES = 4;
		const SLIDES = 5;
		const ONE_FOOT_TRICKS = 6;
		const OLD_SCHOOL = 7;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $groupe = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $slug = null;

		///**
		// * @ORM\OneToMany(targetEntity="Images::class", mappedBy="figure", cascade={"persist"})
		//*/
    // private Collection $images;

		#[ORM\Column(type: Types::ARRAY)]
		private ?array $images;

		#[ORM\Column(type: Types::ARRAY)]
		private ?array $videos;
    /*
		/**
		 * @ORM\OneToMany(targetEntity="Videos::class", mappedBy="figure", cascade={"persist"})
		 */
		/*
    private Collection $videos;
		*/

    public function __construct()
    {
        //$this->images = new ArrayCollection();
        //$this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGroupe(): ?int
    {
        return $this->groupe;
    }

    public function setGroupe(int $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

		/**
		 * @return array|null
		 */
		public function getImages(): ?array
		{
			return $this->images;
		}

		/**
		 * @param array|null $images
		 */
		public function setImages(?array $images): void
		{
			$this->images = $images;
		}


		/**
		 * @return array|null
		 */
		public function getVideos(): ?array
		{
			return $this->videos;
		}

		/**
	 * @param array|null $videos
	 */
		public function setVideos(?array $videos): void
		{
			$this->videos = $videos;
		}

}
