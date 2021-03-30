<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330081435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adds user table';
    }

    public function up(Schema $schema) : void
    {
        $tableGame = $schema->createTable('user');
        $tableGame->addColumn('uuid', 'string', ['length' => 36, 'notnull' => true]);
        $tableGame->addColumn('nickname', 'string', ['notnull' => true]);
        $tableGame->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('user');
    }
}
