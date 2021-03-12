<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312163451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `game` ADD COLUMN next_player_id varchar(36) NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `game` DROP COLUMN next_player_id');
    }
}
