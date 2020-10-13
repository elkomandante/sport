<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201010173626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, league_id INT DEFAULT NULL, name VARCHAR(127) NOT NULL, other_names VARCHAR(127) DEFAULT NULL, formed_year INT DEFAULT NULL, stadium VARCHAR(127) DEFAULT NULL, description LONGTEXT DEFAULT NULL, stadium_description LONGTEXT DEFAULT NULL, stadium_location VARCHAR(127) DEFAULT NULL, stadium_capacity INT DEFAULT NULL, website VARCHAR(127) DEFAULT NULL, facebook VARCHAR(127) DEFAULT NULL, twitter VARCHAR(127) DEFAULT NULL, instagram VARCHAR(127) DEFAULT NULL, youtube VARCHAR(127) DEFAULT NULL, INDEX IDX_C4E0A61F58AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE team');
    }
}
