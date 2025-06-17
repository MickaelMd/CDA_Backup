<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605094246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD commercial_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B37854071C FOREIGN KEY (commercial_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1D1C63B37854071C ON utilisateur (commercial_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B37854071C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_1D1C63B37854071C ON utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur DROP commercial_id
        SQL);
    }
}
