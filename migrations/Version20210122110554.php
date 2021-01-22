<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122110554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, seance_id INT DEFAULT NULL, justifie TINYINT(1) DEFAULT NULL, INDEX IDX_765AE0C9A21BD112 (personne_id), INDEX IDX_765AE0C9E3797A94 (seance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, nb_eleve INT NOT NULL, capacite INT NOT NULL, niveau INT NOT NULL, eleves LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', enseignants LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', list_matieres LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', list_seances LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_personne (classe_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_350001418F5EA509 (classe_id), INDEX IDX_35000141A21BD112 (personne_id), PRIMARY KEY(classe_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacte (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, objet VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, distinataire VARCHAR(255) NOT NULL, reponse VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, INDEX IDX_C794A022A21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, contenu VARCHAR(255) DEFAULT NULL, INDEX IDX_FDCA8C9CF46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, objet VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, reponse VARCHAR(255) DEFAULT NULL, INDEX IDX_2694D7A5A21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere_classe (matiere_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_AF649A8BF46CD258 (matiere_id), INDEX IDX_AF649A8B8F5EA509 (classe_id), PRIMARY KEY(matiere_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, devoir VARCHAR(20) NOT NULL, valeur DOUBLE PRECISION NOT NULL, INDEX IDX_CFBDFA14A6CC7B2 (eleve_id), INDEX IDX_CFBDFA148F5EA509 (classe_id), INDEX IDX_CFBDFA14F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, sexe VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(20) NOT NULL, cin INT NOT NULL, email VARCHAR(30) DEFAULT NULL, num_tel INT DEFAULT NULL, adresse VARCHAR(50) DEFAULT NULL, role VARCHAR(20) NOT NULL, niveau INT DEFAULT NULL, list_matieres LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_FCEC9EFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_matiere (personne_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_4E9BB3B7A21BD112 (personne_id), INDEX IDX_4E9BB3B7F46CD258 (matiere_id), PRIMARY KEY(personne_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, capacite INT NOT NULL, caracteristique VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, classe_id INT NOT NULL, salle_id INT DEFAULT NULL, enseignant_id INT DEFAULT NULL, profs_id INT DEFAULT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, INDEX IDX_DF7DFD0E8F5EA509 (classe_id), INDEX IDX_DF7DFD0EDC304035 (salle_id), INDEX IDX_DF7DFD0EE455FCC0 (enseignant_id), INDEX IDX_DF7DFD0EBDDFA3C9 (profs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE classe_personne ADD CONSTRAINT FK_350001418F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe_personne ADD CONSTRAINT FK_35000141A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contacte ADD CONSTRAINT FK_C794A022A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE matiere_classe ADD CONSTRAINT FK_AF649A8BF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matiere_classe ADD CONSTRAINT FK_AF649A8B8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA148F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE personne_matiere ADD CONSTRAINT FK_4E9BB3B7A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_matiere ADD CONSTRAINT FK_4E9BB3B7F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EBDDFA3C9 FOREIGN KEY (profs_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe_personne DROP FOREIGN KEY FK_350001418F5EA509');
        $this->addSql('ALTER TABLE matiere_classe DROP FOREIGN KEY FK_AF649A8B8F5EA509');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA148F5EA509');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E8F5EA509');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CF46CD258');
        $this->addSql('ALTER TABLE matiere_classe DROP FOREIGN KEY FK_AF649A8BF46CD258');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F46CD258');
        $this->addSql('ALTER TABLE personne_matiere DROP FOREIGN KEY FK_4E9BB3B7F46CD258');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9A21BD112');
        $this->addSql('ALTER TABLE classe_personne DROP FOREIGN KEY FK_35000141A21BD112');
        $this->addSql('ALTER TABLE contacte DROP FOREIGN KEY FK_C794A022A21BD112');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A21BD112');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A6CC7B2');
        $this->addSql('ALTER TABLE personne_matiere DROP FOREIGN KEY FK_4E9BB3B7A21BD112');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EE455FCC0');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EBDDFA3C9');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EDC304035');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9E3797A94');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE classe_personne');
        $this->addSql('DROP TABLE contacte');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_classe');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_matiere');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE user');
    }
}
