<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210827120407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D19D86650F');
        $this->addSql('DROP INDEX idx_723705d19d86650f ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON transaction (user)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D19D86650F FOREIGN KEY (user) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('DROP INDEX idx_723705d1a76ed395 ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D19D86650F ON transaction (user)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user) REFERENCES user (id)');
    }
}
