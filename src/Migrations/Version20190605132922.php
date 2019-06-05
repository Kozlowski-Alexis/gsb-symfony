<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190605132922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiche_frais DROP FOREIGN KEY FK_5FC0A6A77F72333D');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, login VARCHAR(20) NOT NULL, mdp VARCHAR(255) NOT NULL, adresse VARCHAR(30) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(30) NOT NULL, date_embauche DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE visiteur');
        $this->addSql('DROP INDEX IDX_5FC0A6A77F72333D ON fiche_frais');
        $this->addSql('ALTER TABLE fiche_frais CHANGE visiteur_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_frais ADD CONSTRAINT FK_5FC0A6A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5FC0A6A7A76ED395 ON fiche_frais (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiche_frais DROP FOREIGN KEY FK_5FC0A6A7A76ED395');
        $this->addSql('CREATE TABLE visiteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, login VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci, mdp VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, adresse VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, cp VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, ville VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, date_embauche DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_5FC0A6A7A76ED395 ON fiche_frais');
        $this->addSql('ALTER TABLE fiche_frais CHANGE user_id visiteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE fiche_frais ADD CONSTRAINT FK_5FC0A6A77F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur (id)');
        $this->addSql('CREATE INDEX IDX_5FC0A6A77F72333D ON fiche_frais (visiteur_id)');
    }
}
