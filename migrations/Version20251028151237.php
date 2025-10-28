<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251028151237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autaurisation_convoi_exceptionnel (id INT AUTO_INCREMENT NOT NULL, requerant VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, type_de_personne VARCHAR(255) NOT NULL, coordonnee VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, type_de_vihicule VARCHAR(255) NOT NULL, type_de_charge VARCHAR(255) NOT NULL, tonnage VARCHAR(255) NOT NULL, condition_de_securite VARCHAR(255) NOT NULL, heure_de_circulation VARCHAR(255) NOT NULL, point_de_depart VARCHAR(255) NOT NULL, point_arrive VARCHAR(255) NOT NULL, heure_de_depart VARCHAR(255) NOT NULL, heure_arrivee VARCHAR(255) NOT NULL, lieu_demission VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', categorie VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, largueur VARCHAR(255) NOT NULL, hauteur VARCHAR(255) NOT NULL, arrimage VARCHAR(255) NOT NULL, signalisation VARCHAR(255) NOT NULL, centrage VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation_circulation_construction (id INT AUTO_INCREMENT NOT NULL, requerant VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, type_de_personne VARCHAR(255) NOT NULL, coordonnee VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, type_de_vihicule VARCHAR(255) NOT NULL, type_de_charge VARCHAR(255) NOT NULL, tonnage VARCHAR(255) NOT NULL, condition_de_securite VARCHAR(255) NOT NULL, heure_de_circulation VARCHAR(255) NOT NULL, point_de_depart VARCHAR(255) NOT NULL, point_arrive VARCHAR(255) NOT NULL, heure_de_depart VARCHAR(255) NOT NULL, heure_arrivee VARCHAR(255) NOT NULL, lieu_demission VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillance_technique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nationnalite VARCHAR(255) NOT NULL, organisation VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, type_de_charge VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) NOT NULL, tonnage VARCHAR(255) NOT NULL, couverture VARCHAR(255) NOT NULL, signalisation VARCHAR(255) NOT NULL, inspecteur_routier VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, point_de_depart VARCHAR(255) NOT NULL, point_arrive VARCHAR(255) NOT NULL, heure_de_depart VARCHAR(255) NOT NULL, heure_arrivee VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE autaurisation_convoi_exceptionnel');
        $this->addSql('DROP TABLE autorisation_circulation_construction');
        $this->addSql('DROP TABLE surveillance_technique');
    }
}
