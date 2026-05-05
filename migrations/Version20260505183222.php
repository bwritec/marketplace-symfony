<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505183222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create categories table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE categories (
                id INT AUTO_INCREMENT NOT NULL,
                parent INT DEFAULT NULL,
                name VARCHAR(30) DEFAULT NULL,
                slogan VARCHAR(30) DEFAULT NULL,
                description LONGTEXT DEFAULT NULL,
                created_at DATETIME DEFAULT NULL,
                INDEX IDX_CATEGORY_PARENT (parent),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE categories
            ADD CONSTRAINT FK_CATEGORY_PARENT
            FOREIGN KEY (parent) REFERENCES categories (id)
            ON DELETE SET NULL
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE categories');
    }
}
