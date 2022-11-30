<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130202348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, release_date DATE DEFAULT NULL, INDEX IDX_39986E4312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_artist (album_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_D322AB301137ABCF (album_id), INDEX IDX_D322AB30B7970CF8 (artist_id), PRIMARY KEY(album_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, real_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, summary LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title (id INT AUTO_INCREMENT NOT NULL, album_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2B36786B1137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title_artist (title_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_CFF883AEA9F87BD (title_id), INDEX IDX_CFF883AEB7970CF8 (artist_id), PRIMARY KEY(title_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB301137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB30B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE title ADD CONSTRAINT FK_2B36786B1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE title_artist ADD CONSTRAINT FK_CFF883AEA9F87BD FOREIGN KEY (title_id) REFERENCES title (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE title_artist ADD CONSTRAINT FK_CFF883AEB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB301137ABCF');
        $this->addSql('ALTER TABLE title DROP FOREIGN KEY FK_2B36786B1137ABCF');
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB30B7970CF8');
        $this->addSql('ALTER TABLE title_artist DROP FOREIGN KEY FK_CFF883AEB7970CF8');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4312469DE2');
        $this->addSql('ALTER TABLE title_artist DROP FOREIGN KEY FK_CFF883AEA9F87BD');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_artist');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE title');
        $this->addSql('DROP TABLE title_artist');
    }
}
