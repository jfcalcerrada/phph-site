<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Move youtube IDs directly into Talks table instead of having an unnecessary separate entity
 */
class Version20161005104033 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('ALTER TABLE talk ADD youTubeId VARCHAR(512) DEFAULT NULL');

        $this->addSql('UPDATE talk SET youTubeId = video.youtubeId FROM video WHERE video.talk_id = talk.id')

        // @todo migrate data
        $this->addSql('DROP TABLE video');
    }

    /**
     * {@inheritdoc}
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE TABLE video (id UUID NOT NULL, talk_id UUID NOT NULL, youtubeid VARCHAR(512) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7cc7da2c6f0601d5 ON video (talk_id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT fk_7cc7da2c6f0601d5 FOREIGN KEY (talk_id) REFERENCES talk (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE talk DROP youtubeId');
    }
}
