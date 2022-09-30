<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figures", inversedBy="photos")
     */
    private ?Figures $figureId = null;

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

    public function getFigureId(): ?Figures
    {
        return $this->figureId;
    }

    public function setFigureId(?Figures $figureId): self
    {
        $this->figureId = $figureId;

        return $this;
    }
}
