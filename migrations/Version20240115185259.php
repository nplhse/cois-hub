<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115185259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospital (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, state_id INT NOT NULL, dispatch_area_id INT NOT NULL, supply_area_id INT DEFAULT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, beds INT NOT NULL, location VARCHAR(255) NOT NULL, tier VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', address_street VARCHAR(255) NOT NULL, address_postal_code VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(255) NOT NULL, address_country VARCHAR(255) NOT NULL, INDEX IDX_4282C85B7E3C61F9 (owner_id), INDEX IDX_4282C85B5D83CC1 (state_id), INDEX IDX_4282C85B957FD192 (dispatch_area_id), INDEX IDX_4282C85B1B81C31 (supply_area_id), INDEX IDX_4282C85BB03A8386 (created_by_id), INDEX IDX_4282C85B896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital_user (hospital_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C727C0863DBB69 (hospital_id), INDEX IDX_C727C08A76ED395 (user_id), PRIMARY KEY(hospital_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B957FD192 FOREIGN KEY (dispatch_area_id) REFERENCES dispatch_area (id)');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B1B81C31 FOREIGN KEY (supply_area_id) REFERENCES supply_area (id)');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hospital_user ADD CONSTRAINT FK_C727C0863DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospital_user ADD CONSTRAINT FK_C727C08A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospital DROP FOREIGN KEY FK_4282C85B7E3C61F9');
        $this->addSql('ALTER TABLE hospital DROP FOREIGN KEY FK_4282C85B5D83CC1');
        $this->addSql('ALTER TABLE hospital DROP FOREIGN KEY FK_4282C85B957FD192');
        $this->addSql('ALTER TABLE hospital DROP FOREIGN KEY FK_4282C85B1B81C31');
        $this->addSql('ALTER TABLE hospital DROP FOREIGN KEY FK_4282C85BB03A8386');
        $this->addSql('ALTER TABLE hospital DROP FOREIGN KEY FK_4282C85B896DBBDE');
        $this->addSql('ALTER TABLE hospital_user DROP FOREIGN KEY FK_C727C0863DBB69');
        $this->addSql('ALTER TABLE hospital_user DROP FOREIGN KEY FK_C727C08A76ED395');
        $this->addSql('DROP TABLE hospital');
        $this->addSql('DROP TABLE hospital_user');
    }
}
