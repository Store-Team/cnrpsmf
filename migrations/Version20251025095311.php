<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251025095311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE autorisation_materiaux_construction_matricule_seq CASCADE');
        $this->addSql('DROP SEQUENCE inspection_convoi_matricule_seq CASCADE');
        $this->addSql('DROP SEQUENCE quittance_matricule_seq CASCADE');
        $this->addSql('DROP SEQUENCE surveillance_chargement_matricule_seq CASCADE');
        $this->addSql('DROP SEQUENCE surveillance_taxi_moto_matricule_seq CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8994B5BC12B2DC9C ON autorisation_convoi_exceptionel (matricule)');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction DROP CONSTRAINT autorisation_materiaux_construction_pkey');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ALTER matricule DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE autorisation_materiaux_construction_id_seq');
        $this->addSql('SELECT setval(\'autorisation_materiaux_construction_id_seq\', (SELECT MAX(id) FROM autorisation_materiaux_construction))');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ALTER id SET DEFAULT nextval(\'autorisation_materiaux_construction_id_seq\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CEF9B50A12B2DC9C ON autorisation_materiaux_construction (matricule)');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE inspection_convoi DROP CONSTRAINT inspection_convoi_pkey');
        $this->addSql('ALTER TABLE inspection_convoi ALTER matricule DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE inspection_convoi_id_seq');
        $this->addSql('SELECT setval(\'inspection_convoi_id_seq\', (SELECT MAX(id) FROM inspection_convoi))');
        $this->addSql('ALTER TABLE inspection_convoi ALTER id SET DEFAULT nextval(\'inspection_convoi_id_seq\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B82412012B2DC9C ON inspection_convoi (matricule)');
        $this->addSql('ALTER TABLE inspection_convoi ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE quittance DROP CONSTRAINT quittance_pkey');
        $this->addSql('ALTER TABLE quittance ALTER matricule DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE quittance_id_seq');
        $this->addSql('SELECT setval(\'quittance_id_seq\', (SELECT MAX(id) FROM quittance))');
        $this->addSql('ALTER TABLE quittance ALTER id SET DEFAULT nextval(\'quittance_id_seq\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D57587DD12B2DC9C ON quittance (matricule)');
        $this->addSql('ALTER TABLE quittance ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE surveillance_chargement DROP CONSTRAINT surveillance_chargement_pkey');
        $this->addSql('ALTER TABLE surveillance_chargement ALTER matricule DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE surveillance_chargement_id_seq');
        $this->addSql('SELECT setval(\'surveillance_chargement_id_seq\', (SELECT MAX(id) FROM surveillance_chargement))');
        $this->addSql('ALTER TABLE surveillance_chargement ALTER id SET DEFAULT nextval(\'surveillance_chargement_id_seq\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96BAB68012B2DC9C ON surveillance_chargement (matricule)');
        $this->addSql('ALTER TABLE surveillance_chargement ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE surveillance_taxi_moto DROP CONSTRAINT surveillance_taxi_moto_pkey');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ALTER matricule DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE surveillance_taxi_moto_id_seq');
        $this->addSql('SELECT setval(\'surveillance_taxi_moto_id_seq\', (SELECT MAX(id) FROM surveillance_taxi_moto))');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ALTER id SET DEFAULT nextval(\'surveillance_taxi_moto_id_seq\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_83727D8E12B2DC9C ON surveillance_taxi_moto (matricule)');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE autorisation_materiaux_construction_matricule_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE inspection_convoi_matricule_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quittance_matricule_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE surveillance_chargement_matricule_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE surveillance_taxi_moto_matricule_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX UNIQ_CEF9B50A12B2DC9C');
        $this->addSql('DROP INDEX autorisation_materiaux_construction_pkey');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE autorisation_materiaux_construction_matricule_seq');
        $this->addSql('SELECT setval(\'autorisation_materiaux_construction_matricule_seq\', (SELECT MAX(matricule) FROM autorisation_materiaux_construction))');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ALTER matricule SET DEFAULT nextval(\'autorisation_materiaux_construction_matricule_seq\')');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ADD PRIMARY KEY (matricule)');
        $this->addSql('DROP INDEX UNIQ_D57587DD12B2DC9C');
        $this->addSql('DROP INDEX quittance_pkey');
        $this->addSql('ALTER TABLE quittance ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE quittance_matricule_seq');
        $this->addSql('SELECT setval(\'quittance_matricule_seq\', (SELECT MAX(matricule) FROM quittance))');
        $this->addSql('ALTER TABLE quittance ALTER matricule SET DEFAULT nextval(\'quittance_matricule_seq\')');
        $this->addSql('ALTER TABLE quittance ADD PRIMARY KEY (matricule)');
        $this->addSql('DROP INDEX UNIQ_4B82412012B2DC9C');
        $this->addSql('DROP INDEX inspection_convoi_pkey');
        $this->addSql('ALTER TABLE inspection_convoi ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE inspection_convoi_matricule_seq');
        $this->addSql('SELECT setval(\'inspection_convoi_matricule_seq\', (SELECT MAX(matricule) FROM inspection_convoi))');
        $this->addSql('ALTER TABLE inspection_convoi ALTER matricule SET DEFAULT nextval(\'inspection_convoi_matricule_seq\')');
        $this->addSql('ALTER TABLE inspection_convoi ADD PRIMARY KEY (matricule)');
        $this->addSql('DROP INDEX UNIQ_83727D8E12B2DC9C');
        $this->addSql('DROP INDEX surveillance_taxi_moto_pkey');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE surveillance_taxi_moto_matricule_seq');
        $this->addSql('SELECT setval(\'surveillance_taxi_moto_matricule_seq\', (SELECT MAX(matricule) FROM surveillance_taxi_moto))');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ALTER matricule SET DEFAULT nextval(\'surveillance_taxi_moto_matricule_seq\')');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ADD PRIMARY KEY (matricule)');
        $this->addSql('DROP INDEX UNIQ_96BAB68012B2DC9C');
        $this->addSql('DROP INDEX surveillance_chargement_pkey');
        $this->addSql('ALTER TABLE surveillance_chargement ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE surveillance_chargement_matricule_seq');
        $this->addSql('SELECT setval(\'surveillance_chargement_matricule_seq\', (SELECT MAX(matricule) FROM surveillance_chargement))');
        $this->addSql('ALTER TABLE surveillance_chargement ALTER matricule SET DEFAULT nextval(\'surveillance_chargement_matricule_seq\')');
        $this->addSql('ALTER TABLE surveillance_chargement ADD PRIMARY KEY (matricule)');
        $this->addSql('DROP INDEX UNIQ_8994B5BC12B2DC9C');
    }
}
