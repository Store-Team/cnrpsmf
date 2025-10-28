<?php

namespace App\Entity;

use App\Repository\SurveillanceChargementRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SurveillanceChargementRepository::class)]
class SurveillanceChargement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api_surveillance_chargement')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    #[Groups('api_surveillance_chargement')]
    private ?string $matricule = null;

    #[ORM\Column(type: Types::BIGINT)]
    #[Groups('api_surveillance_chargement')]
    private ?string $numero_recu = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $lieu_emission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('api_surveillance_chargement')]
    private ?DateTime $date_emission = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $r_organisation = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $r_nationalite = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $r_addresse = null;

    #[ORM\Column(length: 13)]
    #[Groups('api_surveillance_chargement')]
    private ?string $r_telephone = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $v_matricule = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $type_charge = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $tonnage_kg = null;

    #[ORM\Column]
    #[Groups('api_surveillance_chargement')]
    private ?bool $signalisation = null;

    #[ORM\Column]
    #[Groups('api_surveillance_chargement')]
    private ?bool $couverture = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $p_depart = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $p_arrivee = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups('api_surveillance_chargement')]
    private ?DateTime $h_depart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups('api_surveillance_chargement')]
    private ?DateTime $h_arrivee = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_surveillance_chargement')]
    private ?string $nom_inspecteur = null;

    #[ORM\Column]
    #[Groups('api_surveillance_chargement')]
    private ?bool $approuvee = null;

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

    public function getNomInspecteur(): ?string
    {
        return $this->nom_inspecteur;
    }

    public function setNomInspecteur(string $nom_inspecteur): static
    {
        $this->nom_inspecteur = $nom_inspecteur;

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

    public function getDateEmission(): ?DateTime
    {
        return $this->date_emission;
    }

    public function setDateEmission(DateTime $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }


    public function getROrganisation(): ?string
    {
        return $this->r_organisation;
    }

    public function setROrganisation(string $r_organisation): static
    {
        $this->r_organisation = $r_organisation;

        return $this;
    }

    public function getRNationalite(): ?string
    {
        return $this->r_nationalite;
    }

    public function setRNationalite(string $r_nationalite): static
    {
        $this->r_nationalite = $r_nationalite;

        return $this;
    }

    public function getRAddresse(): ?string
    {
        return $this->r_addresse;
    }

    public function setRAddresse(string $r_addresse): static
    {
        $this->r_addresse = $r_addresse;

        return $this;
    }

    public function getRTelephone(): ?string
    {
        return $this->r_telephone;
    }

    public function setRTelephone(string $r_telephone): static
    {
        $this->r_telephone = $r_telephone;

        return $this;
    }

    public function getVMatricule(): ?string
    {
        return $this->v_matricule;
    }

    public function setVMatricule(string $v_matricule): static
    {
        $this->v_matricule = $v_matricule;

        return $this;
    }

    public function getTypeCharge(): ?string
    {
        return $this->type_charge;
    }

    public function setTypeCharge(string $type_charge): static
    {
        $this->type_charge = $type_charge;

        return $this;
    }

    public function getTonnageKg(): ?string
    {
        return $this->tonnage_kg;
    }

    public function setTonnageKg(string $tonnage_kg): static
    {
        $this->tonnage_kg = $tonnage_kg;

        return $this;
    }

    public function getPDepart(): ?string
    {
        return $this->p_depart;
    }

    public function setPDepart(string $p_depart): static
    {
        $this->p_depart = $p_depart;

        return $this;
    }

    public function getPArrivee(): ?string
    {
        return $this->p_arrivee;
    }

    public function setPArrivee(string $p_arrivee): static
    {
        $this->p_arrivee = $p_arrivee;

        return $this;
    }

    public function getHDepart(): ?DateTime
    {
        return $this->h_depart;
    }

    public function setHDepart(DateTime $h_depart): static
    {
        $this->h_depart = $h_depart;

        return $this;
    }

    public function getHArrivee(): ?DateTime
    {
        return $this->h_arrivee;
    }

    public function setHArrivee(DateTime $h_arrivee): static
    {
        $this->h_arrivee = $h_arrivee;

        return $this;
    }

    public function isSignalisation(): ?bool
    {
        return $this->signalisation;
    }

    public function setCouverture(bool $couverture): static
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function iscouverture(): ?bool
    {
        return $this->couverture;
    }

    public function setSignalisation(bool $signalisation): static
    {
        $this->signalisation = $signalisation;

        return $this;
    }

    public function isApprouvee(): ?bool
    {
        return $this->approuvee;
    }

    public function setApprouvee(bool $approuvee): static
    {
        $this->approuvee = $approuvee;

        return $this;
    }
}
