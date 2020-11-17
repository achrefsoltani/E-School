<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117190641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, seance_id INT NOT NULL, justifie TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_765AE0C9A21BD112 (personne_id), INDEX IDX_765AE0C9E3797A94 (seance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, nb_eleve INT NOT NULL, capacite INT NOT NULL, niveau INT NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_personne (classe_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_350001418F5EA509 (classe_id), INDEX IDX_35000141A21BD112 (personne_id), PRIMARY KEY(classe_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_classe (matiere_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_AF649A8BF46CD258 (matiere_id), INDEX IDX_AF649A8B8F5EA509 (classe_id), PRIMARY KEY(matiere_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, devoir VARCHAR(20) NOT NULL, valeur DOUBLE PRECISION NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_CFBDFA14A6CC7B2 (eleve_id), INDEX IDX_CFBDFA148F5EA509 (classe_id), INDEX IDX_CFBDFA14F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, sexe VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(20) NOT NULL, cin INT NOT NULL, email VARCHAR(30) DEFAULT NULL, num_tel INT DEFAULT NULL, adresse VARCHAR(50) DEFAULT NULL, role VARCHAR(20) NOT NULL, login VARCHAR(30) DEFAULT NULL, mdp VARCHAR(30) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, capacite INT NOT NULL, caracteristique VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, classe_id INT NOT NULL, salle_id INT DEFAULT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_DF7DFD0E8F5EA509 (classe_id), INDEX IDX_DF7DFD0EDC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE classe_personne ADD CONSTRAINT FK_350001418F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_personne ADD CONSTRAINT FK_35000141A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_classe ADD CONSTRAINT FK_AF649A8BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_classe ADD CONSTRAINT FK_AF649A8B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA148F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe_personne DROP FOREIGN KEY FK_350001418F5EA509');
        $this->addSql('ALTER TABLE matiere_classe DROP FOREIGN KEY FK_AF649A8B8F5EA509');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA148F5EA509');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E8F5EA509');
        $this->addSql('ALTER TABLE matiere_classe DROP FOREIGN KEY FK_AF649A8BF46CD258');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F46CD258');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9A21BD112');
        $this->addSql('ALTER TABLE classe_personne DROP FOREIGN KEY FK_35000141A21BD112');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A6CC7B2');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EDC304035');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9E3797A94');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE classe_personne');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_classe');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE seance');
    }
}
