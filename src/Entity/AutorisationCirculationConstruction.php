<?php

namespace App\Entity;

use App\Repository\AutorisationCirculationConstructionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutorisationCirculationConstructionRepository::class)]
class AutorisationCirculationConstruction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $requerant = null;

    #[ORM\Column(length: 255)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255)]
    private ?string $typeDePersonne = null;

    #[ORM\Column(length: 255)]
    private ?string $coordonnee = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $typeDeVihicule = null;

    #[ORM\Column(length: 255)]
    private ?string $typeDeCharge = null;

    #[ORM\Column(length: 255)]
    private ?string $tonnage = null;

    #[ORM\Column(length: 255)]
    private ?string $conditionDeSecurite = null;

    #[ORM\Column(length: 255)]
    private ?string $heureDeCirculation = null;

    #[ORM\Column(length: 255)]
    private ?string $pointDeDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $pointArrive = null;

    #[ORM\Column(length: 255)]
    private ?string $heureDeDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $heureArrivee = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuDEmission = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt;

    public function __construct(){
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequerant(): ?string
    {
        return $this->requerant;
    }

    public function setRequerant(string $requerant): static
    {
        $this->requerant = $requerant;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getTypeDePersonne(): ?string
    {
        return $this->typeDePersonne;
    }

    public function setTypeDePersonne(string $typeDePersonne): static
    {
        $this->typeDePersonne = $typeDePersonne;

        return $this;
    }

    public function getCoordonnee(): ?string
    {
        return $this->coordonnee;
    }

    public function setCoordonnee(string $coordonnee): static
    {
        $this->coordonnee = $coordonnee;

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

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getTypeDeVihicule(): ?string
    {
        return $this->typeDeVihicule;
    }

    public function setTypeDeVihicule(string $typeDeVihicule): static
    {
        $this->typeDeVihicule = $typeDeVihicule;

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

    public function getTonnage(): ?string
    {
        return $this->tonnage;
    }

    public function setTonnage(string $tonnage): static
    {
        $this->tonnage = $tonnage;

        return $this;
    }

    public function getConditionDeSecurite(): ?string
    {
        return $this->conditionDeSecurite;
    }

    public function setConditionDeSecurite(string $conditionDeSecurite): static
    {
        $this->conditionDeSecurite = $conditionDeSecurite;

        return $this;
    }

    public function getHeureDeCirculation(): ?string
    {
        return $this->heureDeCirculation;
    }

    public function setHeureDeCirculation(string $heureDeCirculation): static
    {
        $this->heureDeCirculation = $heureDeCirculation;

        return $this;
    }

    public function getPointDeDepart(): ?string
    {
        return $this->pointDeDepart;
    }

    public function setPointDeDepart(string $pointDeDepart): static
    {
        $this->pointDeDepart = $pointDeDepart;

        return $this;
    }

    public function getPointArrive(): ?string
    {
        return $this->pointArrive;
    }

    public function setPointArrive(string $pointArrive): static
    {
        $this->pointArrive = $pointArrive;

        return $this;
    }

    public function getHeureDeDepart(): ?string
    {
        return $this->heureDeDepart;
    }

    public function setHeureDeDepart(string $heureDeDepart): static
    {
        $this->heureDeDepart = $heureDeDepart;

        return $this;
    }

    public function getHeureArrivee(): ?string
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(string $heureArrivee): static
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    public function getLieuDEmission(): ?string
    {
        return $this->lieuDEmission;
    }

    public function setLieuDEmission(string $lieuDEmission): static
    {
        $this->lieuDEmission = $lieuDEmission;

        return $this;
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
