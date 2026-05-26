<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260526030710 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Cria tabela product_correios';
        }

        public function up(Schema $schema): void
        {
            $this->addSql('
                CREATE TABLE product_correios (
                    id INT AUTO_INCREMENT NOT NULL,
                    user_id INT NOT NULL,
                    product_id INT NOT NULL,
                    weight VARCHAR(255) DEFAULT NULL,
                    length VARCHAR(255) DEFAULT NULL,
                    height VARCHAR(255) DEFAULT NULL,
                    width VARCHAR(255) DEFAULT NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4
                COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB
            ');
        }

        public function down(Schema $schema): void
        {
            $this->addSql('DROP TABLE product_correios');
        }
    }
