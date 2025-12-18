<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251218205100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, price INT NOT NULL, status VARCHAR(255) NOT NULL, session_id INT NOT NULL, seat_id INT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_97A0ADA3613FECDF (session_id), INDEX IDX_97A0ADA3C1DAFE35 (seat_id), INDEX IDX_97A0ADA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C1DAFE35 FOREIGN KEY (seat_id) REFERENCES seat (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3613FECDF');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C1DAFE35');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A76ED395');
        $this->addSql('DROP TABLE ticket');
    }
}
