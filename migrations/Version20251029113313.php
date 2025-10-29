<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251029113313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inspection_convoi_exce_technique (id INT AUTO_INCREMENT NOT NULL, requerant VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, type_de_personne VARCHAR(255) NOT NULL, coordonnee VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, type_de_vihicule VARCHAR(255) NOT NULL, type_de_charge VARCHAR(255) NOT NULL, point_de_depart VARCHAR(255) NOT NULL, point_arrive VARCHAR(255) NOT NULL, heure_de_depart VARCHAR(255) NOT NULL, heure_arrivee VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', categorie VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, largueur VARCHAR(255) NOT NULL, hauteur VARCHAR(255) NOT NULL, arrimage VARCHAR(255) NOT NULL, signalisation VARCHAR(255) NOT NULL, centrage VARCHAR(255) NOT NULL, observations LONGTEXT DEFAULT NULL, equipe LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', contact VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quittance_cnpr (id INT AUTO_INCREMENT NOT NULL, assujetti VARCHAR(255) NOT NULL, numero_de_taxation VARCHAR(255) DEFAULT NULL, mode_encaisse_en_chiffres DOUBLE PRECISION NOT NULL, mode_encaisse_en_lettres VARCHAR(255) NOT NULL, banque_beneficiaire VARCHAR(255) DEFAULT NULL, numero_de_compte VARCHAR(255) DEFAULT NULL, mode_de_paiement VARCHAR(255) DEFAULT NULL, nature_de_limposition_payee VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillance_embarquement_moto (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, corporation VARCHAR(255) NOT NULL, tel VARCHAR(255) DEFAULT NULL, immatriculation VARCHAR(255) DEFAULT NULL, marque VARCHAR(255) NOT NULL, inspecteurs_routiers LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE autaurisation_convoi_exceptionnel DROP lieu_demission');
        $this->addSql('ALTER TABLE autorisation_circulation_construction DROP lieu_demission');
        $this->addSql('ALTER TABLE surveillance_technique DROP lieu_emission');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inspection_convoi_exce_technique');
        $this->addSql('DROP TABLE quittance_cnpr');
        $this->addSql('DROP TABLE surveillance_embarquement_moto');
        $this->addSql('ALTER TABLE autaurisation_convoi_exceptionnel ADD lieu_demission VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE autorisation_circulation_construction ADD lieu_demission VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE surveillance_technique ADD lieu_emission VARCHAR(255) NOT NULL');
    }
}
