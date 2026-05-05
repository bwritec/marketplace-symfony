<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505174356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create links table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE links (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) DEFAULT NULL,
                url VARCHAR(255) DEFAULT NULL,
                open_in_new_window TINYINT(1) DEFAULT 0 NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE links');
    }
}
