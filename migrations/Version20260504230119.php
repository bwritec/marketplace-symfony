<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504230119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create products table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE products (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT UNSIGNED NOT NULL,
                name VARCHAR(255) DEFAULT NULL,
                conditions VARCHAR(20) DEFAULT NULL,
                description LONGTEXT DEFAULT NULL,
                amount INT UNSIGNED DEFAULT NULL,
                demonstration TINYINT(1) DEFAULT 0 NOT NULL,
                paused TINYINT(1) DEFAULT 0 NOT NULL,
                price NUMERIC(10,2) DEFAULT 0.00 NOT NULL,
                created_at DATETIME DEFAULT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE products");
    }
}
