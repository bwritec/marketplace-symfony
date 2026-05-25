<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260525000022 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Cria tabela addresses';
        }

        public function up(Schema $schema): void
        {
            $this->addSql('
                CREATE TABLE addresses (
                    id INT AUTO_INCREMENT NOT NULL,
                    user_id INT NOT NULL,
                    address VARCHAR(255) DEFAULT NULL,
                    neighborhood VARCHAR(255) DEFAULT NULL,
                    city VARCHAR(255) DEFAULT NULL,
                    state VARCHAR(255) DEFAULT NULL,
                    cep VARCHAR(9) DEFAULT NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4
                COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB
            ');
        }

        public function down(Schema $schema): void
        {
            $this->addSql('DROP TABLE addresses');
        }
    }
