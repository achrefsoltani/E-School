<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118184050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP created, DROP updated');
        $this->addSql('ALTER TABLE classe DROP created, DROP updated');
        $this->addSql('ALTER TABLE matiere DROP created, DROP updated');
        $this->addSql('ALTER TABLE note DROP created, DROP updated');
        $this->addSql('ALTER TABLE salle DROP created, DROP updated');
        $this->addSql('ALTER TABLE seance DROP created, DROP updated');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD created DATETIME NOT NULL, ADD updated DATETIME DEFAULT NULL');
    }
}
