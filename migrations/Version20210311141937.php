<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311141937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Table creation';
    }

    public function up(Schema $schema) : void
    {
        $tableGame = $schema->createTable('game');
        $tableGame->addColumn('uuid', 'string', ['length' => 36, 'notnull' => true]);
        $tableGame->setPrimaryKey(['uuid']);

        $tableBoard = $schema->createTable('board');
        $tableBoard->addColumn('uuid', 'string', ['length' => 36, 'notnull' => true]);
        $tableBoard->addColumn('game_id', 'string', ['length' => 36, 'notnull' => true]);
        $tableBoard->addForeignKeyConstraint($tableGame, ['game_id'], ['uuid'], array("onUpdate" => "CASCADE"));
        $tableBoard->setPrimaryKey(['uuid']);

        $tableTile = $schema->createTable('tile');
        $tableTile->addColumn('uuid', 'string', ['length' => 36, 'notnull' => true]);
        $tableTile->addColumn('mark', 'integer', ['notnull' => false]);
        $tableTile->addColumn('game_id', 'string', ['length' => 36, 'notnull' => true]);
        $tableTile->addForeignKeyConstraint($tableGame, ['game_id'], ['uuid'], array("onUpdate" => "CASCADE"));
        $tableTile->setPrimaryKey(['uuid']);

        $tablePlayer = $schema->createTable('player');
        $tablePlayer->addColumn('uuid', 'string', ['length' => 36, 'notnull' => true]);
        $tablePlayer->addColumn('nickname', 'string', ['notnull' => true]);
        $tablePlayer->addColumn('mark', 'integer', ['notnull' => true]);
        $tablePlayer->addColumn('game_id', 'string', ['length' => 36, 'notnull' => true]);
        $tablePlayer->addForeignKeyConstraint($tableGame, ['game_id'], ['uuid'], array("onUpdate" => "CASCADE"));
        $tablePlayer->setPrimaryKey(['uuid']);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('player');
        $schema->dropTable('game');
        $schema->dropTable('tile');
        $schema->dropTable('board');
    }
}
