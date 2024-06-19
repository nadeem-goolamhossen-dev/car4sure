<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619142834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person ADD policy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1762D29E3C6 FOREIGN KEY (policy_id) REFERENCES `policy` (id)');
        $this->addSql('CREATE INDEX IDX_34DCD1762D29E3C6 ON person (policy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `person` DROP FOREIGN KEY FK_34DCD1762D29E3C6');
        $this->addSql('DROP INDEX IDX_34DCD1762D29E3C6 ON `person`');
        $this->addSql('ALTER TABLE `person` DROP policy_id');
    }
}
