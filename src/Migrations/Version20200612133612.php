<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612133612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD birth_date DATE NOT NULL');
        $this->addSql('ALTER TABLE tree ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE tree ADD CONSTRAINT FK_B73E5EDCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B73E5EDCA76ED395 ON tree (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tree DROP FOREIGN KEY FK_B73E5EDCA76ED395');
        $this->addSql('DROP INDEX IDX_B73E5EDCA76ED395 ON tree');
        $this->addSql('ALTER TABLE tree DROP user_id');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP birth_date');
    }
}
