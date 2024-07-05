<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619154045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE policy DROP FOREIGN KEY FK_F07D0516DEEE62D0');
        $this->addSql('DROP INDEX UNIQ_F07D0516DEEE62D0 ON policy');
        $this->addSql('ALTER TABLE policy DROP holder_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `policy` ADD holder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `policy` ADD CONSTRAINT FK_F07D0516DEEE62D0 FOREIGN KEY (holder_id) REFERENCES person (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F07D0516DEEE62D0 ON `policy` (holder_id)');
    }
}
