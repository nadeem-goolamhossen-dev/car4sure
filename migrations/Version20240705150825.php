<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705150825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zip INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE "coverage" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by INTEGER DEFAULT NULL, updated_by INTEGER DEFAULT NULL, type VARCHAR(255) NOT NULL, cover_limit INTEGER NOT NULL, deductible INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_5556F36BDE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5556F36B16FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5556F36BDE12AB56 ON "coverage" (created_by)');
        $this->addSql('CREATE INDEX IDX_5556F36B16FE72E1 ON "coverage" (updated_by)');
        $this->addSql('CREATE TABLE "license" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number INTEGER NOT NULL, state VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, class VARCHAR(255) NOT NULL, effective_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE "person" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, person_address_id INTEGER DEFAULT NULL, person_license_id INTEGER DEFAULT NULL, created_by INTEGER DEFAULT NULL, updated_by INTEGER DEFAULT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, gender VARCHAR(1) NOT NULL, age INTEGER NOT NULL, marital_status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_34DCD176C30CCC60 FOREIGN KEY (person_address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_34DCD17670B4F35E FOREIGN KEY (person_license_id) REFERENCES "license" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_34DCD176DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_34DCD17616FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD176C30CCC60 ON "person" (person_address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD17670B4F35E ON "person" (person_license_id)');
        $this->addSql('CREATE INDEX IDX_34DCD176DE12AB56 ON "person" (created_by)');
        $this->addSql('CREATE INDEX IDX_34DCD17616FE72E1 ON "person" (updated_by)');
        $this->addSql('CREATE TABLE "policy" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, holder_id INTEGER DEFAULT NULL, created_by INTEGER DEFAULT NULL, updated_by INTEGER DEFAULT NULL, policy_no INTEGER NOT NULL, status BOOLEAN NOT NULL, type VARCHAR(255) NOT NULL, effective_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_F07D0516DEEE62D0 FOREIGN KEY (holder_id) REFERENCES "person" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F07D0516DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F07D051616FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F07D0516DEEE62D0 ON "policy" (holder_id)');
        $this->addSql('CREATE INDEX IDX_F07D0516DE12AB56 ON "policy" (created_by)');
        $this->addSql('CREATE INDEX IDX_F07D051616FE72E1 ON "policy" (updated_by)');
        $this->addSql('CREATE TABLE policy_drivers (policy_id INTEGER NOT NULL, person_id INTEGER NOT NULL, PRIMARY KEY(policy_id, person_id), CONSTRAINT FK_873C7B332D29E3C6 FOREIGN KEY (policy_id) REFERENCES "policy" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_873C7B33217BBB47 FOREIGN KEY (person_id) REFERENCES "person" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_873C7B332D29E3C6 ON policy_drivers (policy_id)');
        $this->addSql('CREATE INDEX IDX_873C7B33217BBB47 ON policy_drivers (person_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by INTEGER DEFAULT NULL, updated_by INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, CONSTRAINT FK_8D93D649DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D64916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8D93D649DE12AB56 ON "user" (created_by)');
        $this->addSql('CREATE INDEX IDX_8D93D64916FE72E1 ON "user" (updated_by)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE "vehicle" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, garaging_address_id INTEGER DEFAULT NULL, policy_id INTEGER DEFAULT NULL, created_by INTEGER DEFAULT NULL, updated_by INTEGER DEFAULT NULL, year INTEGER NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, vin BIGINT NOT NULL, vehicle_usage VARCHAR(255) NOT NULL, primary_use VARCHAR(255) NOT NULL, annual_milleage INTEGER NOT NULL, ownership VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_1B80E4867A926313 FOREIGN KEY (garaging_address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1B80E4862D29E3C6 FOREIGN KEY (policy_id) REFERENCES "policy" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1B80E486DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1B80E48616FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E4867A926313 ON "vehicle" (garaging_address_id)');
        $this->addSql('CREATE INDEX IDX_1B80E4862D29E3C6 ON "vehicle" (policy_id)');
        $this->addSql('CREATE INDEX IDX_1B80E486DE12AB56 ON "vehicle" (created_by)');
        $this->addSql('CREATE INDEX IDX_1B80E48616FE72E1 ON "vehicle" (updated_by)');
        $this->addSql('CREATE TABLE vehicle_coverage (vehicle_id INTEGER NOT NULL, coverage_id INTEGER NOT NULL, PRIMARY KEY(vehicle_id, coverage_id), CONSTRAINT FK_8844FCFF545317D1 FOREIGN KEY (vehicle_id) REFERENCES "vehicle" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8844FCFF9F5AA71B FOREIGN KEY (coverage_id) REFERENCES "coverage" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8844FCFF545317D1 ON vehicle_coverage (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_8844FCFF9F5AA71B ON vehicle_coverage (coverage_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE "coverage"');
        $this->addSql('DROP TABLE "license"');
        $this->addSql('DROP TABLE "person"');
        $this->addSql('DROP TABLE "policy"');
        $this->addSql('DROP TABLE policy_drivers');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE "vehicle"');
        $this->addSql('DROP TABLE vehicle_coverage');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
