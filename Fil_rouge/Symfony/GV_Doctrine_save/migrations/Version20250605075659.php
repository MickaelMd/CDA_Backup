<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605075659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur ADD produit_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_369ECA32F347EFB ON fournisseur (produit_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_369ECA32F347EFB ON fournisseur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fournisseur DROP produit_id
        SQL);
    }
}
