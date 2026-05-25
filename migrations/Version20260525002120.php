<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260525002120 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Cria tabela phones';
        }

        public function up(Schema $schema): void
        {
            $this->addSql('
                CREATE TABLE phones (
                    id INT AUTO_INCREMENT NOT NULL,
                    user_id INT NOT NULL,
                    phone VARCHAR(12) DEFAULT NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4
                COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB
            ');
        }

        public function down(Schema $schema): void
        {
            $this->addSql('DROP TABLE phones');
        }
    }
