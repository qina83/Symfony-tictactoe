<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312153900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'added col and row to tile table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `tile` ADD COLUMN row integer');
        $this->addSql('ALTER TABLE `tile` ADD COLUMN col integer');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `tile` DROP COLUMN row');
        $this->addSql('ALTER TABLE `tile` DROP COLUMN col');
    }
}
