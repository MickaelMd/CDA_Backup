<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605075029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, nom VARCHAR(80) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, commercial_id INT DEFAULT NULL, date_commande DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', mode_paiement VARCHAR(50) NOT NULL, statu VARCHAR(50) NOT NULL, tva NUMERIC(5, 2) NOT NULL, reduction NUMERIC(5, 2) DEFAULT NULL, total NUMERIC(15, 2) NOT NULL, total_ht NUMERIC(15, 2) NOT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE detail_commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_id INT NOT NULL, quantite INT NOT NULL, prix NUMERIC(15, 2) NOT NULL, INDEX IDX_98344FA6F347EFB (produit_id), INDEX IDX_98344FA682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, nom VARCHAR(80) NOT NULL, email VARCHAR(320) NOT NULL, telephone VARCHAR(30) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_369ECA327854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', etat VARCHAR(50) NOT NULL, INDEX IDX_A60C9F1F82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, sous_categorie_id INT NOT NULL, stock INT NOT NULL, active TINYINT(1) NOT NULL, libelle_court VARCHAR(80) NOT NULL, libelle_long LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, prix_ht NUMERIC(15, 2) NOT NULL, prix_fournisseur NUMERIC(15, 2) NOT NULL, INDEX IDX_29A5EC27365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, active TINYINT(1) NOT NULL, nom VARCHAR(80) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_52743D7BBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, nom VARCHAR(80) NOT NULL, prenom VARCHAR(80) NOT NULL, telephone VARCHAR(30) DEFAULT NULL, coefficient NUMERIC(5, 2) DEFAULT NULL, adresse_livraison VARCHAR(255) DEFAULT NULL, adresse_facturation VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D7854071C FOREIGN KEY (commercial_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA327854071C FOREIGN KEY (commercial_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D7854071C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA6F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA682EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA327854071C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F82EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27365BF48
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE detail_commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE fournisseur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE livraison
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sous_categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
