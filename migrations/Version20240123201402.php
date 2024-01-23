<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123201402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', amount DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, is_cash TINYINT(1) DEFAULT NULL, is_gain TINYINT(1) DEFAULT NULL, INDEX IDX_2D3A8DA612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_expense (tag_id INT NOT NULL, expense_id INT NOT NULL, INDEX IDX_1F0BA00CBAD26311 (tag_id), INDEX IDX_1F0BA00CF395DB7B (expense_id), PRIMARY KEY(tag_id, expense_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE tag_expense ADD CONSTRAINT FK_1F0BA00CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_expense ADD CONSTRAINT FK_1F0BA00CF395DB7B FOREIGN KEY (expense_id) REFERENCES expense (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA612469DE2');
        $this->addSql('ALTER TABLE tag_expense DROP FOREIGN KEY FK_1F0BA00CBAD26311');
        $this->addSql('ALTER TABLE tag_expense DROP FOREIGN KEY FK_1F0BA00CF395DB7B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_expense');
    }
}
