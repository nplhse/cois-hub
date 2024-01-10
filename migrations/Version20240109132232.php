<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109132232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dispatch_area ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE supply_area_id supply_area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE state ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE supply_area DROP FOREIGN KEY FK_6C7C59715D83CC1');
        $this->addSql('DROP INDEX IDX_6C7C59715D83CC1 ON supply_area');
        $this->addSql('ALTER TABLE supply_area ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP state_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE state DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE dispatch_area DROP created_at, DROP updated_at, CHANGE supply_area_id supply_area_id INT NOT NULL');
        $this->addSql('ALTER TABLE supply_area ADD state_id INT NOT NULL, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE supply_area ADD CONSTRAINT FK_6C7C59715D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6C7C59715D83CC1 ON supply_area (state_id)');
    }
}
