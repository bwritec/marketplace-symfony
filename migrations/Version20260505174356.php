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
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, slogan VARCHAR(30) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, parent INT DEFAULT NULL, INDEX IDX_3AF346683D8E604F (parent), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE links (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, open_in_new_window TINYINT DEFAULT 0 NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346683D8E604F FOREIGN KEY (parent) REFERENCES categories (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_thumbnails DROP user_id, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_thumbnails ADD CONSTRAINT FK_C1C3804B4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_C1C3804B4584665A ON product_thumbnails (product_id)');
        $this->addSql('ALTER TABLE products DROP user_id, DROP conditions, DROP amount, DROP demonstration, DROP paused, DROP created_at, CHANGE name name VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346683D8E604F');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE links');
        $this->addSql('ALTER TABLE product_thumbnails DROP FOREIGN KEY FK_C1C3804B4584665A');
        $this->addSql('DROP INDEX IDX_C1C3804B4584665A ON product_thumbnails');
        $this->addSql('ALTER TABLE product_thumbnails ADD user_id INT NOT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD user_id INT UNSIGNED NOT NULL, ADD conditions VARCHAR(20) DEFAULT NULL, ADD amount INT UNSIGNED DEFAULT NULL, ADD demonstration TINYINT DEFAULT 0 NOT NULL, ADD paused TINYINT DEFAULT 0 NOT NULL, ADD created_at DATETIME DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
