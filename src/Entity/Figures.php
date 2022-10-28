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
		const ROTATION_DESAXES = 4;
		const SLIDES = 5;
		const ONE_FOOT_TRICKS = 6;
		const OLD_SCHOOL = 7;

		const GROUP_LABELS = [
			self::GRABS => 'Grabs',
			self::ROTATIONS => 'Rotations',
			self::FLIPS => 'Flips',
			self::ROTATION_DESAXES => 'Rotation désaxée',
			self::SLIDES => 'Slides',
			self::ONE_FOOT_TRICKS => 'One foot Tricks',
			self::OLD_SCHOOL => 'Old school'
		];

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

		#[ORM\Column(type: Types::ARRAY)]
		private ?array $videos;

  #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $ajouteLe = null;

  #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $modifieLe = null;

  #[ORM\OneToMany(mappedBy: 'figureId', targetEntity: Commentaires::class)]
  private Collection $commentaires;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="figureId", cascade={"persist"})
	 */
  private Collection $photos;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $photoPresentation = null;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->photos = new ArrayCollection();
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

  public function getAjouteLe(): ?\DateTimeInterface
  {
      return $this->ajouteLe;
  }

  public function setAjouteLe(?\DateTimeInterface $ajouteLe): self
  {
      $this->ajouteLe = $ajouteLe;

      return $this;
  }

  public function getModifieLe(): ?\DateTimeInterface
  {
      return $this->modifieLe;
  }

  public function setModifieLe(?\DateTimeInterface $modifieLe): self
  {
      $this->modifieLe = $modifieLe;

      return $this;
  }

  /**
   * @return Collection<int, Commentaires>
   */
  public function getCommentaires(): Collection
  {
      return $this->commentaires;
  }

  public function addCommentaire(Commentaires $commentaire): self
  {
      if (!$this->commentaires->contains($commentaire)) {
          $this->commentaires[] = $commentaire;
          $commentaire->setFigureId($this);
      }

      return $this;
  }

  public function removeCommentaire(Commentaires $commentaire): self
  {
      if ($this->commentaires->removeElement($commentaire)) {
          // set the owning side to null (unless already changed)
          if ($commentaire->getFigureId() === $this) {
              $commentaire->setFigureId(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, Photos>
   */
  public function getPhotos(): Collection
  {
      return $this->photos;
  }

  public function addPhoto(?Photos $photo = null): self
  {
      if (!$this->photos->contains($photo)) {
          $this->photos[] = $photo;
          $photo->setFigureId($this);
      }

      return $this;
  }

  public function removePhoto(Photos $photo): self
  {
      if ($this->photos->removeElement($photo)) {
          // set the owning side to null (unless already changed)
          if ($photo->getFigureId() === $this) {
              $photo->setFigureId(null);
          }
      }

      return $this;
  }

  public function getPhotoPresentation(): ?string
  {
      return $this->photoPresentation;
  }

  public function setPhotoPresentation(?string $photoPresentation): self
  {
      $this->photoPresentation = $photoPresentation;

      return $this;
  }

}
