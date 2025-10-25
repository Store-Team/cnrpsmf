<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251025122339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autorisation_convoi_exceptionel ALTER matricule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ALTER matricule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE inspection_convoi ALTER matricule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE quittance ALTER matricule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE surveillance_chargement ALTER matricule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ALTER matricule TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE autorisation_materiaux_construction ALTER matricule TYPE BIGINT');
        $this->addSql('ALTER TABLE quittance ALTER matricule TYPE BIGINT');
        $this->addSql('ALTER TABLE inspection_convoi ALTER matricule TYPE BIGINT');
        $this->addSql('ALTER TABLE surveillance_taxi_moto ALTER matricule TYPE BIGINT');
        $this->addSql('ALTER TABLE surveillance_chargement ALTER matricule TYPE BIGINT');
        $this->addSql('ALTER TABLE autorisation_convoi_exceptionel ALTER matricule TYPE BIGINT');
    }
}
