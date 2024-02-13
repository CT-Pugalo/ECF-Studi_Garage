<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[Vich\Uploadable]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Vich\UploadableField(mapping: 'product_images', fileNameProperty: 'nomImage')]
    private ?File $image = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $annee_circulation = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomImage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function setImage(?File $image = null): void
    {
        $this->image = $image;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImageName(?string $image): void
    {
        $this->image = $image;
    }

    public function getImageName(): ?string
    {
        return $this->image;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAnneeCirculation(): ?\DateTimeInterface
    {
        return $this->annee_circulation;
    }

    public function setAnneeCirculation(\DateTimeInterface $annee_circulation): static
    {
        $this->annee_circulation = $annee_circulation;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getNomImage(): ?string
    {
        return $this->nomImage;
    }

    public function setNomImage(?string $nomImage): static
    {
        $this->nomImage = $nomImage;

        return $this;
    }
}
