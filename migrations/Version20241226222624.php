<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241226222624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, exam_id INT NOT NULL, value INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_595AAE34CB944F1A (student_id), INDEX IDX_595AAE34CDF80196 (exam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_7HH4F44S7424ED67 FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_2595AAE01964CDF8 FOREIGN KEY (exam_id) REFERENCES exam (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_7HH4F44S7424ED67');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_2595AAE01964CDF8');
        $this->addSql('DROP TABLE grade');
    }
}
