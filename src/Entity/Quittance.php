<?php

namespace App\Entity;

use App\Repository\QuittanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: QuittanceRepository::class)]
class Quittance
{
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api_quittance')]
    private ?int $id = null;

    #[ORM\Id]
    #[ORM\Column(type: Types::BIGINT)]
    #[Groups('api_quittance')]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $type_quittance = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $lieu_emission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('api_quittance')]
    private ?\DateTime $date_emmision = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $assujettif = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $numero_perception = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $montant_chiffres = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 3)]
    #[Groups('api_quittance')]
    private ?string $montant = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $banque = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $numero_compte = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $mode_payement = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $nature_impo = null;

    #[ORM\Column(length: 255)]
    #[Groups('api_quittance')]
    private ?string $receveur_drlu = null;

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

    public function getTypeQuittance(): ?string
    {
        return $this->type_quittance;
    }

    public function setTypeQuittance(string $type_quittance): static
    {
        $this->type_quittance = $type_quittance;

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

    public function getDateEmmision(): ?\DateTime
    {
        return $this->date_emmision;
    }

    public function setDateEmmision(\DateTime $date_emmision): static
    {
        $this->date_emmision = $date_emmision;

        return $this;
    }

    public function getAssujettif(): ?string
    {
        return $this->assujettif;
    }

    public function setAssujettif(string $assujettif): static
    {
        $this->assujettif = $assujettif;

        return $this;
    }

    public function getNumeroPerception(): ?string
    {
        return $this->numero_perception;
    }

    public function setNumeroPerception(string $numero_perception): static
    {
        $this->numero_perception = $numero_perception;

        return $this;
    }

    public function getMontantChiffres(): ?string
    {
        return $this->montant_chiffres;
    }

    public function setMontantChiffres(string $montant_chiffres): static
    {
        $this->montant_chiffres = $montant_chiffres;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(string $banque): static
    {
        $this->banque = $banque;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(string $numero_compte): static
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }

    public function getModePayement(): ?string
    {
        return $this->mode_payement;
    }

    public function setModePayement(string $mode_payement): static
    {
        $this->mode_payement = $mode_payement;

        return $this;
    }

    public function getNatureImpo(): ?string
    {
        return $this->nature_impo;
    }

    public function setNatureImpo(string $nature_impo): static
    {
        $this->nature_impo = $nature_impo;

        return $this;
    }

    public function getReceveurDrlu(): ?string
    {
        return $this->receveur_drlu;
    }

    public function setReceveurDrlu(string $receveur_drlu): static
    {
        $this->receveur_drlu = $receveur_drlu;

        return $this;
    }
}
