<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426110046 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_choice DROP FOREIGN KEY FK_C6F6759A1E27F6BF');
        $this->addSql('DROP INDEX IDX_C6F6759A1E27F6BF ON question_choice');
        $this->addSql('ALTER TABLE question_choice DROP question_id');
        $this->addSql('ALTER TABLE question_choices ADD question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_choices ADD CONSTRAINT FK_B1243241E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_B1243241E27F6BF ON question_choices (question_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_choice ADD question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_choice ADD CONSTRAINT FK_C6F6759A1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_C6F6759A1E27F6BF ON question_choice (question_id)');
        $this->addSql('ALTER TABLE question_choices DROP FOREIGN KEY FK_B1243241E27F6BF');
        $this->addSql('DROP INDEX IDX_B1243241E27F6BF ON question_choices');
        $this->addSql('ALTER TABLE question_choices DROP question_id');
    }
}
