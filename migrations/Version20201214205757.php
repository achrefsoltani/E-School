<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214205757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EE455FCC0');
        $this->addSql('DROP INDEX IDX_DF7DFD0EE455FCC0 ON seance');
        $this->addSql('ALTER TABLE seance DROP enseignant_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance ADD enseignant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EE455FCC0 ON seance (enseignant_id)');
    }
}
