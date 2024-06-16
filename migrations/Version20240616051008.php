<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616051008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE policy (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, policy_no INT NOT NULL, status TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, effective_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F07D0516DE12AB56 (created_by), INDEX IDX_F07D051616FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D0516DE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE policy ADD CONSTRAINT FK_F07D051616FE72E1 FOREIGN KEY (updated_by) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D0516DE12AB56');
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D051616FE72E1');
        $this->addSql('DROP TABLE policy');
    }
}
