<?php

namespace App\Entity;

use App\Repository\PhotoPresentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoPresentationRepository::class)]
class PhotoPresentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
