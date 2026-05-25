<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260525003918 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Cria tabela product_photos';
        }

        public function up(Schema $schema): void
        {
            $this->addSql('
                CREATE TABLE product_photos (
                    id INT AUTO_INCREMENT NOT NULL,
                    user_id INT NOT NULL,
                    product_id INT NOT NULL,
                    name VARCHAR(255) DEFAULT NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4
                COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB
            ');
        }

        public function down(Schema $schema): void
        {
            $this->addSql('DROP TABLE product_photos');
        }
    }
