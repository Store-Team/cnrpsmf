<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251025045812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE autorisation_convoi_exceptionel (id SERIAL NOT NULL, matricule BIGINT NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_type VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, v_marque VARCHAR(255) NOT NULL, v_type VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, v_largeur NUMERIC(10, 0) NOT NULL, hauteur NUMERIC(10, 0) NOT NULL, r_securite VARCHAR(255) NOT NULL, heure_circulation VARCHAR(255) NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME(0) WITHOUT TIME ZONE NOT NULL, h_arrivee TIME(0) WITHOUT TIME ZONE NOT NULL, arrimage BOOLEAN NOT NULL, centrage BOOLEAN NOT NULL, signalisation BOOLEAN NOT NULL, charge_technique VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE autorisation_materiaux_construction (matricule BIGSERIAL NOT NULL, id INT NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_type VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, v_marque VARCHAR(255) NOT NULL, v_type VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, r_securite VARCHAR(255) NOT NULL, heure_circulation VARCHAR(255) NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME(0) WITHOUT TIME ZONE NOT NULL, h_arrivee TIME(0) WITHOUT TIME ZONE NOT NULL, arrimage BOOLEAN NOT NULL, centrage BOOLEAN NOT NULL, signalisation BOOLEAN NOT NULL, charge_technique VARCHAR(255) NOT NULL, PRIMARY KEY(matricule))');
        $this->addSql('CREATE TABLE inspection_convoi (matricule BIGSERIAL NOT NULL, id INT NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_type VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, v_marque VARCHAR(255) NOT NULL, v_type VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, longueur VARCHAR(255) NOT NULL, v_largeur NUMERIC(10, 0) NOT NULL, hauteur NUMERIC(10, 0) NOT NULL, arrimage BOOLEAN NOT NULL, centrage BOOLEAN NOT NULL, signalisation BOOLEAN NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME(0) WITHOUT TIME ZONE NOT NULL, h_arrivee TIME(0) WITHOUT TIME ZONE NOT NULL, raison_arret VARCHAR(500) NOT NULL, observations_generales VARCHAR(5000) NOT NULL, approuve BOOLEAN NOT NULL, inspecteur_nom VARCHAR(255) NOT NULL, equipe1 VARCHAR(255) NOT NULL, equipe1_contact VARCHAR(255) NOT NULL, equipe2 VARCHAR(255) NOT NULL, equipe2_contact VARCHAR(255) NOT NULL, equipe3 VARCHAR(255) NOT NULL, euipe3_contact VARCHAR(255) NOT NULL, PRIMARY KEY(matricule))');
        $this->addSql('CREATE TABLE quittance (matricule BIGSERIAL NOT NULL, id INT NOT NULL, type_quittance VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emmision DATE NOT NULL, assujettif VARCHAR(255) NOT NULL, numero_perception VARCHAR(255) NOT NULL, montant_chiffres VARCHAR(255) NOT NULL, montant NUMERIC(10, 3) NOT NULL, banque VARCHAR(255) NOT NULL, numero_compte VARCHAR(255) NOT NULL, mode_payement VARCHAR(255) NOT NULL, nature_impo VARCHAR(255) NOT NULL, receveur_drlu VARCHAR(255) NOT NULL, PRIMARY KEY(matricule))');
        $this->addSql('CREATE TABLE surveillance_chargement (matricule BIGSERIAL NOT NULL, id INT NOT NULL, numero_recu BIGINT NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, r_organisation VARCHAR(255) NOT NULL, r_nationalite VARCHAR(255) NOT NULL, r_addresse VARCHAR(255) NOT NULL, r_telephone VARCHAR(13) NOT NULL, v_matricule VARCHAR(255) NOT NULL, type_charge VARCHAR(255) NOT NULL, tonnage_kg VARCHAR(255) NOT NULL, signalisation BOOLEAN NOT NULL, couverture BOOLEAN NOT NULL, p_depart VARCHAR(255) NOT NULL, p_arrivee VARCHAR(255) NOT NULL, h_depart TIME(0) WITHOUT TIME ZONE NOT NULL, h_arrivee TIME(0) WITHOUT TIME ZONE NOT NULL, nom_inspecteur VARCHAR(255) NOT NULL, approuvee BOOLEAN NOT NULL, PRIMARY KEY(matricule))');
        $this->addSql('CREATE TABLE surveillance_taxi_moto (matricule BIGSERIAL NOT NULL, id INT NOT NULL, numero_recu VARCHAR(255) NOT NULL, lieu_emission VARCHAR(255) NOT NULL, date_emission DATE NOT NULL, nom_dem VARCHAR(255) NOT NULL, corporation VARCHAR(255) NOT NULL, telephone_dem VARCHAR(13) NOT NULL, m_matricule VARCHAR(255) NOT NULL, marque_moto VARCHAR(255) NOT NULL, inspecteur1 VARCHAR(255) NOT NULL, inspecteur2 VARCHAR(255) NOT NULL, inspecteur3 VARCHAR(255) NOT NULL, PRIMARY KEY(matricule))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE autorisation_convoi_exceptionel');
        $this->addSql('DROP TABLE autorisation_materiaux_construction');
        $this->addSql('DROP TABLE inspection_convoi');
        $this->addSql('DROP TABLE quittance');
        $this->addSql('DROP TABLE surveillance_chargement');
        $this->addSql('DROP TABLE surveillance_taxi_moto');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
