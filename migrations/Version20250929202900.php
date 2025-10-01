<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929202900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create links table for URL shortener';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE links (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            original_url TEXT NOT NULL,
            short_code TEXT NOT NULL UNIQUE,
            expires_at DATETIME,
            clicks INTEGER NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE links');
    }
}
