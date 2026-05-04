<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504230414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product_thumbnails table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE product_thumbnails (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                name VARCHAR(255) DEFAULT NULL,
                PRIMARY KEY(id)
            )
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE product_thumbnails");
    }
}
