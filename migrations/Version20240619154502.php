<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619154502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE policy_person (policy_id INT NOT NULL, person_id INT NOT NULL, INDEX IDX_1E083C6B2D29E3C6 (policy_id), INDEX IDX_1E083C6B217BBB47 (person_id), PRIMARY KEY(policy_id, person_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE policy_person ADD CONSTRAINT FK_1E083C6B2D29E3C6 FOREIGN KEY (policy_id) REFERENCES `policy` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE policy_person ADD CONSTRAINT FK_1E083C6B217BBB47 FOREIGN KEY (person_id) REFERENCES `person` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy_person DROP FOREIGN KEY FK_1E083C6B2D29E3C6');
        $this->addSql('ALTER TABLE policy_person DROP FOREIGN KEY FK_1E083C6B217BBB47');
        $this->addSql('DROP TABLE policy_person');
    }
}
