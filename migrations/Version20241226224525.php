<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226224525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, relationship VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FD501D6AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, exam_id INT NOT NULL, bunch_id INT NOT NULL, day VARCHAR(20) NOT NULL, time TIME NOT NULL, INDEX IDX_5A3811FBCDF80196 (exam_id), INDEX IDX_5A3811FBFE54D947 (bunch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_FD501D6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBCDF80196 FOREIGN KEY (exam_id) REFERENCES exam (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBFE54D947 FOREIGN KEY (bunch_id) REFERENCES student_bunch (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_FD501D6AA76ED395');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBCDF80196');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBFE54D947');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE lecture');
        $this->addSql('DROP TABLE schedule');
    }
}
