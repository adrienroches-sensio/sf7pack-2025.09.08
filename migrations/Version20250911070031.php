<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250911070031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Volunteering & User relation.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteering AS SELECT id, conference_id, start_at, end_at FROM volunteering');
        $this->addSql('DROP TABLE volunteering');
        $this->addSql('CREATE TABLE volunteering (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, conference_id INTEGER NOT NULL, for_user_id INTEGER NOT NULL, start_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , end_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , CONSTRAINT FK_7854E8EE604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7854E8EE9B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO volunteering (id, conference_id, start_at, end_at) SELECT id, conference_id, start_at, end_at FROM __temp__volunteering');
        $this->addSql('DROP TABLE __temp__volunteering');
        $this->addSql('CREATE INDEX IDX_7854E8EE604B8382 ON volunteering (conference_id)');
        $this->addSql('CREATE INDEX IDX_7854E8EE9B5BB4B8 ON volunteering (for_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteering AS SELECT id, conference_id, start_at, end_at FROM volunteering');
        $this->addSql('DROP TABLE volunteering');
        $this->addSql('CREATE TABLE volunteering (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, conference_id INTEGER NOT NULL, start_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , end_at DATETIME NOT NULL --(DC2Type:datetimetz_immutable)
        , CONSTRAINT FK_7854E8EE604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO volunteering (id, conference_id, start_at, end_at) SELECT id, conference_id, start_at, end_at FROM __temp__volunteering');
        $this->addSql('DROP TABLE __temp__volunteering');
        $this->addSql('CREATE INDEX IDX_7854E8EE604B8382 ON volunteering (conference_id)');
    }
}
