<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619122637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `license` (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, state VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, class VARCHAR(255) NOT NULL, effective_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `person` (id INT AUTO_INCREMENT NOT NULL, person_address_id INT DEFAULT NULL, person_license_id INT DEFAULT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, gender VARCHAR(1) NOT NULL, age INT NOT NULL, marital_status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_34DCD176C30CCC60 (person_address_id), UNIQUE INDEX UNIQ_34DCD17670B4F35E (person_license_id), INDEX IDX_34DCD176DE12AB56 (created_by), INDEX IDX_34DCD17616FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `person` ADD CONSTRAINT FK_34DCD176C30CCC60 FOREIGN KEY (person_address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE `person` ADD CONSTRAINT FK_34DCD17670B4F35E FOREIGN KEY (person_license_id) REFERENCES `license` (id)');
        $this->addSql('ALTER TABLE `person` ADD CONSTRAINT FK_34DCD176DE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `person` ADD CONSTRAINT FK_34DCD17616FE72E1 FOREIGN KEY (updated_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE policy ADD holder_id INT NOT NULL');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D0516DEEE62D0 FOREIGN KEY (holder_id) REFERENCES `person` (id)');
        $this->addSql('CREATE INDEX IDX_F07D0516DEEE62D0 ON policy (holder_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `policy` DROP FOREIGN KEY FK_F07D0516DEEE62D0');
        $this->addSql('ALTER TABLE `person` DROP FOREIGN KEY FK_34DCD176C30CCC60');
        $this->addSql('ALTER TABLE `person` DROP FOREIGN KEY FK_34DCD17670B4F35E');
        $this->addSql('ALTER TABLE `person` DROP FOREIGN KEY FK_34DCD176DE12AB56');
        $this->addSql('ALTER TABLE `person` DROP FOREIGN KEY FK_34DCD17616FE72E1');
        $this->addSql('DROP TABLE `license`');
        $this->addSql('DROP TABLE `person`');
        $this->addSql('DROP INDEX IDX_F07D0516DEEE62D0 ON `policy`');
        $this->addSql('ALTER TABLE `policy` DROP holder_id');
    }
}
