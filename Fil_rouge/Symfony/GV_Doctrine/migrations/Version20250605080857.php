<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605080857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_369ECA32F347EFB ON fournisseur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur DROP produit_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD fournisseur_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_29A5EC27670C757F ON produit (fournisseur_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur ADD produit_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_369ECA32F347EFB ON fournisseur (produit_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_29A5EC27670C757F ON produit
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP fournisseur_id
        SQL);
    }
}
