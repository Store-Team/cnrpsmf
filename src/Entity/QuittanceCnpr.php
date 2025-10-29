<?php

namespace App\Entity;

use App\Repository\QuittanceCnprRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuittanceCnprRepository::class)]
class QuittanceCnpr
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $assujetti = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroDeTaxation = null;

    #[ORM\Column]
    private ?float $modeEncaisseEnChiffres = null;

    #[ORM\Column(length: 255)]
    private ?string $ModeEncaisseEnLettres = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banqueBeneficiaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroDeCompte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modeDePaiement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureDeLimpositionPayee = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssujetti(): ?string
    {
        return $this->assujetti;
    }

    public function setAssujetti(string $assujetti): static
    {
        $this->assujetti = $assujetti;

        return $this;
    }

    public function getNumeroDeTaxation(): ?string
    {
        return $this->numeroDeTaxation;
    }

    public function setNumeroDeTaxation(?string $numeroDeTaxation): static
    {
        $this->numeroDeTaxation = $numeroDeTaxation;

        return $this;
    }

    public function getModeEncaisseEnChiffres(): ?float
    {
        return $this->modeEncaisseEnChiffres;
    }

    public function setModeEncaisseEnChiffres(float $modeEncaisseEnChiffres): static
    {
        $this->modeEncaisseEnChiffres = $modeEncaisseEnChiffres;

        return $this;
    }

    public function getModeEncaisseEnLettres(): ?string
    {
        return $this->ModeEncaisseEnLettres;
    }

    public function setModeEncaisseEnLettres(string $ModeEncaisseEnLettres): static
    {
        $this->ModeEncaisseEnLettres = $ModeEncaisseEnLettres;

        return $this;
    }

    public function getBanqueBeneficiaire(): ?string
    {
        return $this->banqueBeneficiaire;
    }

    public function setBanqueBeneficiaire(?string $banqueBeneficiaire): static
    {
        $this->banqueBeneficiaire = $banqueBeneficiaire;

        return $this;
    }

    public function getNumeroDeCompte(): ?string
    {
        return $this->numeroDeCompte;
    }

    public function setNumeroDeCompte(?string $numeroDeCompte): static
    {
        $this->numeroDeCompte = $numeroDeCompte;

        return $this;
    }

    public function getModeDePaiement(): ?string
    {
        return $this->modeDePaiement;
    }

    public function setModeDePaiement(?string $modeDePaiement): static
    {
        $this->modeDePaiement = $modeDePaiement;

        return $this;
    }

    public function getNatureDeLimpositionPayee(): ?string
    {
        return $this->natureDeLimpositionPayee;
    }

    public function setNatureDeLimpositionPayee(?string $natureDeLimpositionPayee): static
    {
        $this->natureDeLimpositionPayee = $natureDeLimpositionPayee;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
