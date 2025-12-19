<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251219001048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE session_id session_id INT DEFAULT NULL, CHANGE seat_id seat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(255) NOT NULL, ADD roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE session_id session_id INT NOT NULL, CHANGE seat_id seat_id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP password, DROP roles');
    }
}
