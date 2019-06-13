<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190613150014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligne_frais_forfait CHANGE frais_forfait_id frais_forfait_id INT DEFAULT NULL, CHANGE fiche_frais_id fiche_frais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE cp cp VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE ligne_frais_hors_forfait CHANGE fiche_frais_id fiche_frais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_frais CHANGE date_motif date_motif DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiche_frais CHANGE date_motif date_motif DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE ligne_frais_forfait CHANGE frais_forfait_id frais_forfait_id INT NOT NULL, CHANGE fiche_frais_id fiche_frais_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_frais_hors_forfait CHANGE fiche_frais_id fiche_frais_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE cp cp VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
