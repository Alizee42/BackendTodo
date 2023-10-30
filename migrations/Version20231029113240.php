<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029113240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_9387207512469DE2');
        $this->addSql('DROP INDEX IDX_9387207512469DE2 ON tache');
        $this->addSql('ALTER TABLE tache DROP category_id');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075BF396750 FOREIGN KEY (id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE utilisateur ADD role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075BF396750');
        $this->addSql('ALTER TABLE tache ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207512469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_9387207512469DE2 ON tache (category_id)');
        $this->addSql('ALTER TABLE utilisateur DROP role');
    }
}
