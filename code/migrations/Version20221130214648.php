<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130214648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE title DROP FOREIGN KEY FK_2B36786B1137ABCF');
        $this->addSql('ALTER TABLE title ADD CONSTRAINT FK_2B36786B1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE title DROP FOREIGN KEY FK_2B36786B1137ABCF');
        $this->addSql('ALTER TABLE title ADD CONSTRAINT FK_2B36786B1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }
}
