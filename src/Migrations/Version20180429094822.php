<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180429094822 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, note_max INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_choice (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, note INT DEFAULT NULL, INDEX IDX_C6F6759A1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_choice ADD CONSTRAINT FK_C6F6759A1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_choice DROP FOREIGN KEY FK_C6F6759A1E27F6BF');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_choice');
    }
}
