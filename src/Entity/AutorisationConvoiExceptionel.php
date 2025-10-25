<?php

namespace App\Entity;

use App\Repository\AutorisationConvoiExceptionelRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutorisationConvoiExceptionelRepository::class)]
class AutorisationConvoiExceptionel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu_emission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_emission = null;

    #[ORM\Column(length: 255)]
    private ?string $r_type = null;

    #[ORM\Column(length: 255)]
    private ?string $r_nationalite = null;

    #[ORM\Column(length: 255)]
    private ?string $r_addresse = null;

    #[ORM\Column(length: 13)]
    private ?string $r_telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $v_matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $v_marque = null;

    #[ORM\Column(length: 255)]
    private ?string $v_type = null;

    #[ORM\Column(length: 255)]
    private ?string $type_charge = null;

    #[ORM\Column(length: 255)]
    private ?string $tonnage_kg = null;

    #[ORM\Column(length: 255)]
    private ?string $longueur = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $v_largeur = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $hauteur = null;

    #[ORM\Column(length: 255)]
    private ?string $r_securite = null;

    #[ORM\Column(length: 255)]
    private ?string $heure_circulation = null;

    #[ORM\Column(length: 255)]
    private ?string $p_depart = null;

    #[ORM\Column(length: 255)]
    private ?string $p_arrivee = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $h_depart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $h_arrivee = null;

    #[ORM\Column]
    private ?bool $arrimage = null;

    #[ORM\Column]
    private ?bool $centrage = null;

    #[ORM\Column]
    private ?bool $signalisation = null;

    #[ORM\Column(length: 255)]
    private ?string $charge_technique = null;

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

    public function getRType(): ?string
    {
        return $this->r_type;
    }

    public function setRType(string $r_type): static
    {
        $this->r_type = $r_type;

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

    public function getVMarque(): ?string
    {
        return $this->v_marque;
    }

    public function setVMarque(string $v_marque): static
    {
        $this->v_marque = $v_marque;

        return $this;
    }

    public function getVType(): ?string
    {
        return $this->v_type;
    }

    public function setVType(string $v_type): static
    {
        $this->v_type = $v_type;

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

    public function getLongueur(): ?string
    {
        return $this->longueur;
    }

    public function setLongueur(string $longueur): static
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getVLargeur(): ?string
    {
        return $this->v_largeur;
    }

    public function setVLargeur(string $v_largeur): static
    {
        $this->v_largeur = $v_largeur;

        return $this;
    }

    public function getHauteur(): ?string
    {
        return $this->hauteur;
    }

    public function setHauteur(string $hauteur): static
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getRSecurite(): ?string
    {
        return $this->r_securite;
    }

    public function setRSecurite(string $r_securite): static
    {
        $this->r_securite = $r_securite;

        return $this;
    }

    public function getHeureCirculation(): ?string
    {
        return $this->heure_circulation;
    }

    public function setHeureCirculation(string $heure_circulation): static
    {
        $this->heure_circulation = $heure_circulation;

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

    public function getHDepart(): ?\DateTime
    {
        return $this->h_depart;
    }

    public function setHDepart(\DateTime $h_depart): static
    {
        $this->h_depart = $h_depart;

        return $this;
    }

    public function getHArrivee(): ?\DateTime
    {
        return $this->h_arrivee;
    }

    public function setHArrivee(\DateTime $h_arrivee): static
    {
        $this->h_arrivee = $h_arrivee;

        return $this;
    }

    public function isArrimage(): ?bool
    {
        return $this->arrimage;
    }

    public function setArrimage(bool $arrimage): static
    {
        $this->arrimage = $arrimage;

        return $this;
    }

    public function isCentrage(): ?bool
    {
        return $this->centrage;
    }

    public function setCentrage(bool $centrage): static
    {
        $this->centrage = $centrage;

        return $this;
    }

    public function isSignalisation(): ?bool
    {
        return $this->signalisation;
    }

    public function setSignalisation(bool $signalisation): static
    {
        $this->signalisation = $signalisation;

        return $this;
    }

    public function getChargeTechnique(): ?string
    {
        return $this->charge_technique;
    }

    public function setChargeTechnique(string $charge_technique): static
    {
        $this->charge_technique = $charge_technique;

        return $this;
    }
}
