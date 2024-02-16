<?php

namespace App\Entity;

use App\Repository\GarageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GarageRepository::class)]
class Garage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_mail = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $ouverture_semaine = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $ouverture_samedi = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $ouverture_dimanche = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $fermeture_semaine = null;

    #[ORM\Column(length: 255)]
    private ?\DateTimeInterface $fermeture_samedi = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $fermeture_dimanche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactTel(): ?string
    {
        return $this->contact_tel;
    }

    public function setContactTel(string $contact_tel): static
    {
        $this->contact_tel = $contact_tel;

        return $this;
    }

    public function getContactMail(): ?string
    {
        return $this->contact_mail;
    }

    public function setContactMail(string $contact_mail): static
    {
        $this->contact_mail = $contact_mail;

        return $this;
    }

    public function getOuvertureSemaine(): ?\DateTimeInterface
    {
        return $this->ouverture_semaine;
    }

    public function setOuvertureSemaine(\DateTimeInterface $ouverture_semaine): static
    {
        $this->ouverture_semaine = $ouverture_semaine;

        return $this;
    }

    public function getOuvertureSamedi(): ?\DateTimeInterface
    {
        return $this->ouverture_samedi;
    }

    public function setOuvertureSamedi(\DateTimeInterface $ouverture_samedi): static
    {
        $this->ouverture_samedi = $ouverture_samedi;

        return $this;
    }

    public function getOuvertureDimanche(): ?\DateTimeInterface
    {
        return $this->ouverture_dimanche;
    }

    public function setOuvertureDimanche(\DateTimeInterface $ouverture_dimanche): static
    {
        $this->ouverture_dimanche = $ouverture_dimanche;

        return $this;
    }

    public function getFermetureSemaine(): ?\DateTimeInterface
    {
        return $this->fermeture_semaine;
    }

    public function setFermetureSemaine(\DateTimeInterface $fermeture_semaine): static
    {
        $this->fermeture_semaine = $fermeture_semaine;

        return $this;
    }

    public function getFermetureSamedi(): ?\DateTimeInterface
    {
        return $this->fermeture_samedi;
    }

    public function setFermetureSamedi(\DateTimeInterface $fermeture_samedi): static
    {
        $this->fermeture_samedi = $fermeture_samedi;

        return $this;
    }

    public function getFermetureDimanche(): ?\DateTimeInterface
    {
        return $this->fermeture_dimanche;
    }

    public function setFermetureDimanche(\DateTimeInterface $fermeture_dimanche): static
    {
        $this->fermeture_dimanche = $fermeture_dimanche;

        return $this;
    }
}
