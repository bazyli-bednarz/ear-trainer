<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240812181154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE845591CC992');
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE8457796F504');
        $this->addSql('DROP TABLE node');
        $this->addSql('ALTER TABLE tasks ADD third_note VARCHAR(3) DEFAULT NULL, ADD fourth_note VARCHAR(3) DEFAULT NULL, ADD is_first_harmonic TINYINT(1) DEFAULT NULL, ADD is_second_harmonic TINYINT(1) DEFAULT NULL, ADD two_intervals_type_enum VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE node (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, previous_node_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_857FE8457796F504 (previous_node_id), INDEX IDX_857FE845591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE845591CC992 FOREIGN KEY (course_id) REFERENCES courses (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE8457796F504 FOREIGN KEY (previous_node_id) REFERENCES node (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tasks DROP third_note, DROP fourth_note, DROP is_first_harmonic, DROP is_second_harmonic, DROP two_intervals_type_enum');
    }
}
