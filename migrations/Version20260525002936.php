<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260525002936 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Cria tabela newsletters';
        }

        public function up(Schema $schema): void
        {
            $this->addSql('
                CREATE TABLE newsletters (
                    id INT AUTO_INCREMENT NOT NULL,
                    email VARCHAR(75) NOT NULL,
                    UNIQUE INDEX UNIQ_NEWSLETTER_EMAIL (email),
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4
                COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB
            ');
        }

        public function down(Schema $schema): void
        {
            $this->addSql('DROP TABLE newsletters');
        }
    }
