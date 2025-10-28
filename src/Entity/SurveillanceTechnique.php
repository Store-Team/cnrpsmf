<?php

namespace App\Entity;

use App\Repository\SurveillanceTechniqueRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SurveillanceTechniqueRepository::class)]
class SurveillanceTechnique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $nationnalite = null;

    #[ORM\Column(length: 255)]
    private ?string $organisation = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $typeDeCharge = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $tonnage = null;

    #[ORM\Column(length: 255)]
    private ?string $couverture = null;

    #[ORM\Column(length: 255)]
    private ?string $signalisation = null;

    #[ORM\Column(length: 255)]
    private ?string $inspecteurRoutier = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuEmission = null;

    #[ORM\Column(length: 255)]
    private ?string $pointDeDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $pointArrive = null;

    #[ORM\Column(length: 255)]
    private ?string $heureDeDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $heureArrivee = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt;

    public function __construct(){
        $this->createdAt = new DateTimeImmutable();
    }

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

    public function getNationnalite(): ?string
    {
        return $this->nationnalite;
    }

    public function setNationnalite(string $nationnalite): static
    {
        $this->nationnalite = $nationnalite;

        return $this;
    }

    public function getOrganisation(): ?string
    {
        return $this->organisation;
    }

    public function setOrganisation(string $organisation): static
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTypeDeCharge(): ?string
    {
        return $this->typeDeCharge;
    }

    public function setTypeDeCharge(string $typeDeCharge): static
    {
        $this->typeDeCharge = $typeDeCharge;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getTonnage(): ?string
    {
        return $this->tonnage;
    }

    public function setTonnage(string $tonnage): static
    {
        $this->tonnage = $tonnage;

        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(string $couverture): static
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getSignalisation(): ?string
    {
        return $this->signalisation;
    }

    public function setSignalisation(string $signalisation): static
    {
        $this->signalisation = $signalisation;

        return $this;
    }

    public function getInspecteurRoutier(): ?string
    {
        return $this->inspecteurRoutier;
    }

    public function setInspecteurRoutier(string $inspecteurRoutier): static
    {
        $this->inspecteurRoutier = $inspecteurRoutier;

        return $this;
    }

    public function getLieuEmission(): ?string
    {
        return $this->lieuEmission;
    }

    public function setLieuEmission(string $lieuEmission): static
    {
        $this->lieuEmission = $lieuEmission;

        return $this;
    }

    public function getPointArrive(): ?string
    {
        return $this->pointArrive;
    }

    public function setPointArrive(?string $pointArrive): void
    {
        $this->pointArrive = $pointArrive;
    }

    public function getPointDeDepart(): ?string
    {
        return $this->pointDeDepart;
    }

    public function setPointDeDepart(?string $pointDeDepart): void
    {
        $this->pointDeDepart = $pointDeDepart;
    }

    public function getHeureDeDepart(): ?string
    {
        return $this->heureDeDepart;
    }

    public function setHeureDeDepart(?string $heureDeDepart): void
    {
        $this->heureDeDepart = $heureDeDepart;
    }

    public function getHeureArrivee(): ?string
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(?string $heureArrivee): void
    {
        $this->heureArrivee = $heureArrivee;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
