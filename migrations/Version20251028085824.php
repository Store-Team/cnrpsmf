<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251028085824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autorisation_convoi_exceptionel (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_type VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, v_marque VARCHAR(255) NOT NULL, v_type VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, v_largeur NUMERIC(10, 0) NOT NULL, hauteur NUMERIC(10, 0) NOT NULL, r_securite VARCHAR(255) NOT NULL, heure_circulation VARCHAR(255) NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME NOT NULL, h_arrivee TIME NOT NULL, arrimage TINYINT(1) NOT NULL, centrage TINYINT(1) NOT NULL, signalisation TINYINT(1) NOT NULL, charge_technique VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8994B5BC12B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation_materiaux_construction (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_type VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, v_marque VARCHAR(255) NOT NULL, v_type VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, r_securite VARCHAR(255) NOT NULL, heure_circulation VARCHAR(255) NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME NOT NULL, h_arrivee TIME NOT NULL, arrimage TINYINT(1) NOT NULL, centrage TINYINT(1) NOT NULL, signalisation TINYINT(1) NOT NULL, charge_technique VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CEF9B50A12B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspection_convoi (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_type VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, v_marque VARCHAR(255) NOT NULL, v_type VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, v_largeur NUMERIC(10, 0) NOT NULL, hauteur NUMERIC(10, 0) NOT NULL, arrimage TINYINT(1) NOT NULL, centrage TINYINT(1) NOT NULL, signalisation TINYINT(1) NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME NOT NULL, h_arrivee TIME NOT NULL, raison_arret VARCHAR(500) NOT NULL, observations_generales VARCHAR(5000) NOT NULL, approuve TINYINT(1) NOT NULL, inspecteur_nom VARCHAR(255) NOT NULL, equipe1 VARCHAR(255) NOT NULL, equipe1_contact VARCHAR(255) NOT NULL, equipe2 VARCHAR(255) NOT NULL, equipe2_contact VARCHAR(255) NOT NULL, equipe3 VARCHAR(255) NOT NULL, euipe3_contact VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4B82412012B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quittance (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, type_quittance VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emmision DATE NOT NULL, assujettif VARCHAR(255) NOT NULL, numero_perception VARCHAR(255) NOT NULL, montant_chiffres VARCHAR(255) NOT NULL, montant NUMERIC(10, 3) NOT NULL, banque VARCHAR(255) NOT NULL, numero_compte VARCHAR(255) NOT NULL, mode_payement VARCHAR(255) NOT NULL, nature_impo VARCHAR(255) NOT NULL, receveur_drlu VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D57587DD12B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillance_chargement (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, numero_recu BIGINT NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_organisation VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, signalisation TINYINT(1) NOT NULL, couverture TINYINT(1) NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME NOT NULL, h_arrivee TIME NOT NULL, nom_inspecteur VARCHAR(255) NOT NULL, approuvee TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_96BAB68012B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillance_taxi_moto (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, numero_recu VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, nom_dem VARCHAR(255) NOT NULL, corporation VARCHAR(255) NOT NULL, telephone_dem VARCHAR(13) NOT NULL, m_matricule VARCHAR(255) NOT NULL, marque_moto VARCHAR(255) NOT NULL, inspecteur1 VARCHAR(255) NOT NULL, inspecteur2 VARCHAR(255) NOT NULL, inspecteur3 VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_83727D8E12B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE autorisation_convoi_exceptionel');
        $this->addSql('DROP TABLE autorisation_materiaux_construction');
        $this->addSql('DROP TABLE inspection_convoi');
        $this->addSql('DROP TABLE quittance');
        $this->addSql('DROP TABLE surveillance_chargement');
        $this->addSql('DROP TABLE surveillance_taxi_moto');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
