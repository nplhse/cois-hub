<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109081853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dispatch_area (id INT AUTO_INCREMENT NOT NULL, state_id INT NOT NULL, supply_area_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_94247A155D83CC1 (state_id), INDEX IDX_94247A151B81C31 (supply_area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supply_area (id INT AUTO_INCREMENT NOT NULL, state_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6C7C59715D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dispatch_area ADD CONSTRAINT FK_94247A155D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE dispatch_area ADD CONSTRAINT FK_94247A151B81C31 FOREIGN KEY (supply_area_id) REFERENCES supply_area (id)');
        $this->addSql('ALTER TABLE supply_area ADD CONSTRAINT FK_6C7C59715D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dispatch_area DROP FOREIGN KEY FK_94247A155D83CC1');
        $this->addSql('ALTER TABLE dispatch_area DROP FOREIGN KEY FK_94247A151B81C31');
        $this->addSql('ALTER TABLE supply_area DROP FOREIGN KEY FK_6C7C59715D83CC1');
        $this->addSql('DROP TABLE dispatch_area');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE supply_area');
    }
}
