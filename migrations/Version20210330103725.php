<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330103725 extends AbstractMigration
{
    public function getDescription() : string
    {
       return "add userId in player";
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE player ADD COLUMN user_id varchar(36)');
        $this->addSql('ALTER TABLE player ADD FOREIGN KEY (`user_id`) REFERENCES user(`uuid`);');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `player` DROP COLUMN user_id');
    }
}
