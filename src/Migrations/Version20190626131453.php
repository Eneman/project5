<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626131453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stb ADD trame_id INT NOT NULL');
        $this->addSql('ALTER TABLE stb ADD CONSTRAINT FK_4119B39D13DF511 FOREIGN KEY (trame_id) REFERENCES trame (id)');
        $this->addSql('CREATE INDEX IDX_4119B39D13DF511 ON stb (trame_id)');
        $this->addSql('ALTER TABLE trame ADD gnevent_id INT NOT NULL');
        $this->addSql('ALTER TABLE trame ADD CONSTRAINT FK_AFD8F82F50C51AAB FOREIGN KEY (gnevent_id) REFERENCES gnevent (id)');
        $this->addSql('CREATE INDEX IDX_AFD8F82F50C51AAB ON trame (gnevent_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stb DROP FOREIGN KEY FK_4119B39D13DF511');
        $this->addSql('DROP INDEX IDX_4119B39D13DF511 ON stb');
        $this->addSql('ALTER TABLE stb DROP trame_id');
        $this->addSql('ALTER TABLE trame DROP FOREIGN KEY FK_AFD8F82F50C51AAB');
        $this->addSql('DROP INDEX IDX_AFD8F82F50C51AAB ON trame');
        $this->addSql('ALTER TABLE trame DROP gnevent_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
