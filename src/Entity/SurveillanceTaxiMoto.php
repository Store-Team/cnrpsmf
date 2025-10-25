<?php

namespace App\Entity;

use App\Repository\SurveillanceTaxiMotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SurveillanceTaxiMotoRepository::class)]
class SurveillanceTaxiMoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_surveillance_taxi_moto'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT, unique: true)]
    #[Groups(['api_surveillance_taxi_moto'])]
    private ?string $matricule = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $numero_recu = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $lieu_emission = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_emission = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $nom_dem = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $corporation = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 13)]
    private ?string $telephone_dem = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $m_matricule = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $marque_moto = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $inspecteur1 = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $inspecteur2 = null;

    #[Groups(['api_surveillance_taxi_moto'])]
    #[ORM\Column(length: 255)]
    private ?string $inspecteur3 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNumeroRecu(): ?string
    {
        return $this->numero_recu;
    }

    public function setNumeroRecu(string $numero_recu): static
    {
        $this->numero_recu = $numero_recu;

        return $this;
    }

    public function getLieuEmission(): ?string
    {
        return $this->lieu_emission;
    }

    public function setLieuEmission(string $lieu_emission): static
    {
        $this->lieu_emission = $lieu_emission;

        return $this;
    }

    public function getDateEmission(): ?\DateTime
    {
        return $this->date_emission;
    }

    public function setDateEmission(\DateTime $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }

    public function getNomDem(): ?string
    {
        return $this->nom_dem;
    }

    public function setNomDem(string $nom_dem): static
    {
        $this->nom_dem = $nom_dem;

        return $this;
    }

    public function getCorporation(): ?string
    {
        return $this->corporation;
    }

    public function setCorporation(string $corporation): static
    {
        $this->corporation = $corporation;

        return $this;
    }

    public function getTelephoneDem(): ?string
    {
        return $this->telephone_dem;
    }

    public function setTelephoneDem(string $telephone_dem): static
    {
        $this->telephone_dem = $telephone_dem;

        return $this;
    }

    public function getMMatricule(): ?string
    {
        return $this->m_matricule;
    }

    public function setMMatricule(string $m_matricule): static
    {
        $this->m_matricule = $m_matricule;

        return $this;
    }

    public function getMarqueMoto(): ?string
    {
        return $this->marque_moto;
    }

    public function setMarqueMoto(string $marque_moto): static
    {
        $this->marque_moto = $marque_moto;

        return $this;
    }

    public function getInspecteur1(): ?string
    {
        return $this->inspecteur1;
    }

    public function setInspecteur1(string $inspecteur1): static
    {
        $this->inspecteur1 = $inspecteur1;

        return $this;
    }

    public function getInspecteur2(): ?string
    {
        return $this->inspecteur2;
    }

    public function setInspecteur2(string $inspecteur2): static
    {
        $this->inspecteur2 = $inspecteur2;

        return $this;
    }

    public function getInspecteur3(): ?string
    {
        return $this->inspecteur3;
    }

    public function setInspecteur3(string $inspecteur3): static
    {
        $this->inspecteur3 = $inspecteur3;

        return $this;
    }
}
