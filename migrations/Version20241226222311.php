<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226222311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, instructor_id INT NOT NULL, name VARCHAR(100) NOT NULL, schedule VARCHAR(255) DEFAULT NULL, INDEX IDX_F87474F341807E1D (instructor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam_student (exam_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_425FFD94CDF80196 (exam_id), INDEX IDX_425FFD94CB944F1A (student_id), PRIMARY KEY(exam_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_H3847DKS83834JF3 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('ALTER TABLE exam_student ADD CONSTRAINT FK_H48DJ84K9D34F847 FOREIGN KEY (exam_id) REFERENCES exam (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exam_student ADD CONSTRAINT FK_Y83JH334FD32S234 FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_H3847DKS83834JF3');
        $this->addSql('ALTER TABLE exam_student DROP FOREIGN KEY FK_H48DJ84K9D34F847');
        $this->addSql('ALTER TABLE exam_student DROP FOREIGN KEY FK_Y83JH334FD32S234');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE exam_student');
    }
}
