<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022130700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (ref VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, PRIMARY KEY(ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (nsc VARCHAR(255) NOT NULL, classroom_id INT NOT NULL, email VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, date_of_birth DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, moyenne DOUBLE PRECISION NOT NULL, INDEX IDX_B723AF336278D5A8 (classroom_id), PRIMARY KEY(nsc)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students_clubs (student_id VARCHAR(255) NOT NULL, club_id VARCHAR(255) NOT NULL, INDEX IDX_A9AE56D7CB944F1A (student_id), INDEX IDX_A9AE56D761190A32 (club_id), PRIMARY KEY(student_id, club_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE students_clubs ADD CONSTRAINT FK_A9AE56D7CB944F1A FOREIGN KEY (student_id) REFERENCES student (nsc)');
        $this->addSql('ALTER TABLE students_clubs ADD CONSTRAINT FK_A9AE56D761190A32 FOREIGN KEY (club_id) REFERENCES club (ref)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF336278D5A8');
        $this->addSql('ALTER TABLE students_clubs DROP FOREIGN KEY FK_A9AE56D761190A32');
        $this->addSql('ALTER TABLE students_clubs DROP FOREIGN KEY FK_A9AE56D7CB944F1A');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE students_clubs');
    }
}
