<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207144727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE import (id INT AUTO_INCREMENT NOT NULL, hospital_id INT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, caption VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', file_path VARCHAR(255) NOT NULL, file_type VARCHAR(255) NOT NULL, file_extension VARCHAR(255) NOT NULL, file_size INT NOT NULL, run_time INT NOT NULL, run_count INT NOT NULL, row_count INT NOT NULL, skipped_rows INT NOT NULL, last_error VARCHAR(255) DEFAULT NULL, INDEX IDX_9D4ECE1D63DBB69 (hospital_id), INDEX IDX_9D4ECE1DB03A8386 (created_by_id), INDEX IDX_9D4ECE1D896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE import ADD CONSTRAINT FK_9D4ECE1D63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id)');
        $this->addSql('ALTER TABLE import ADD CONSTRAINT FK_9D4ECE1DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE import ADD CONSTRAINT FK_9D4ECE1D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE import DROP FOREIGN KEY FK_9D4ECE1D63DBB69');
        $this->addSql('ALTER TABLE import DROP FOREIGN KEY FK_9D4ECE1DB03A8386');
        $this->addSql('ALTER TABLE import DROP FOREIGN KEY FK_9D4ECE1D896DBBDE');
        $this->addSql('DROP TABLE import');
    }
}
