<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617144735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `coverage` (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, type VARCHAR(255) NOT NULL, cover_limit INT NOT NULL, deductible INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5556F36BDE12AB56 (created_by), INDEX IDX_5556F36B16FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `policy` (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, policy_no INT NOT NULL, status TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, effective_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F07D0516DE12AB56 (created_by), INDEX IDX_F07D051616FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `vehicle` (id INT AUTO_INCREMENT NOT NULL, policy_id INT DEFAULT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, year INT NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, vin BIGINT NOT NULL, vehicle_usage VARCHAR(255) NOT NULL, primary_use VARCHAR(255) NOT NULL, annual_milleage INT NOT NULL, ownership VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1B80E4862D29E3C6 (policy_id), INDEX IDX_1B80E486DE12AB56 (created_by), INDEX IDX_1B80E48616FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_coverage (vehicle_id INT NOT NULL, coverage_id INT NOT NULL, INDEX IDX_8844FCFF545317D1 (vehicle_id), INDEX IDX_8844FCFF9F5AA71B (coverage_id), PRIMARY KEY(vehicle_id, coverage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `coverage` ADD CONSTRAINT FK_5556F36BDE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `coverage` ADD CONSTRAINT FK_5556F36B16FE72E1 FOREIGN KEY (updated_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `policy` ADD CONSTRAINT FK_F07D0516DE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `policy` ADD CONSTRAINT FK_F07D051616FE72E1 FOREIGN KEY (updated_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `vehicle` ADD CONSTRAINT FK_1B80E4862D29E3C6 FOREIGN KEY (policy_id) REFERENCES `policy` (id)');
        $this->addSql('ALTER TABLE `vehicle` ADD CONSTRAINT FK_1B80E486DE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `vehicle` ADD CONSTRAINT FK_1B80E48616FE72E1 FOREIGN KEY (updated_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vehicle_coverage ADD CONSTRAINT FK_8844FCFF545317D1 FOREIGN KEY (vehicle_id) REFERENCES `vehicle` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_coverage ADD CONSTRAINT FK_8844FCFF9F5AA71B FOREIGN KEY (coverage_id) REFERENCES `coverage` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `coverage` DROP FOREIGN KEY FK_5556F36BDE12AB56');
        $this->addSql('ALTER TABLE `coverage` DROP FOREIGN KEY FK_5556F36B16FE72E1');
        $this->addSql('ALTER TABLE `policy` DROP FOREIGN KEY FK_F07D0516DE12AB56');
        $this->addSql('ALTER TABLE `policy` DROP FOREIGN KEY FK_F07D051616FE72E1');
        $this->addSql('ALTER TABLE `vehicle` DROP FOREIGN KEY FK_1B80E4862D29E3C6');
        $this->addSql('ALTER TABLE `vehicle` DROP FOREIGN KEY FK_1B80E486DE12AB56');
        $this->addSql('ALTER TABLE `vehicle` DROP FOREIGN KEY FK_1B80E48616FE72E1');
        $this->addSql('ALTER TABLE vehicle_coverage DROP FOREIGN KEY FK_8844FCFF545317D1');
        $this->addSql('ALTER TABLE vehicle_coverage DROP FOREIGN KEY FK_8844FCFF9F5AA71B');
        $this->addSql('DROP TABLE `coverage`');
        $this->addSql('DROP TABLE `policy`');
        $this->addSql('DROP TABLE `vehicle`');
        $this->addSql('DROP TABLE vehicle_coverage');
    }
}
