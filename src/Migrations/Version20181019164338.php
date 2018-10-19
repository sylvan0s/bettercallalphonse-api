<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181019164338 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, note_max INT NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, ordered INT DEFAULT 1 NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_choice (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX IDX_C6F6759A1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, birthdate DATETIME DEFAULT NULL, date_entry DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_energy_choice (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, note INT NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_CE9356EFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_question_choice (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, question_choice_id INT NOT NULL, question_id INT NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_D42A1915A76ED395 (user_id), INDEX IDX_D42A19159053224A (question_choice_id), INDEX IDX_D42A19151E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_suggestion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, suggestion LONGTEXT NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_7AE735F7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_suggestion_like (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, suggestion_id INT NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_B5DAE32FA76ED395 (user_id), INDEX IDX_B5DAE32FA41BB822 (suggestion_id), UNIQUE INDEX user_suggestion_unique (user_id, suggestion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_suggestion_mega_like (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, suggestion_id INT NOT NULL, creation_date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_7354A5DEA76ED395 (user_id), INDEX IDX_7354A5DEA41BB822 (suggestion_id), UNIQUE INDEX user_suggestion_unique (user_id, suggestion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_choice ADD CONSTRAINT FK_C6F6759A1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE user_energy_choice ADD CONSTRAINT FK_CE9356EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_question_choice ADD CONSTRAINT FK_D42A1915A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_question_choice ADD CONSTRAINT FK_D42A19159053224A FOREIGN KEY (question_choice_id) REFERENCES question_choice (id)');
        $this->addSql('ALTER TABLE user_question_choice ADD CONSTRAINT FK_D42A19151E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE user_suggestion ADD CONSTRAINT FK_7AE735F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_suggestion_like ADD CONSTRAINT FK_B5DAE32FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_suggestion_like ADD CONSTRAINT FK_B5DAE32FA41BB822 FOREIGN KEY (suggestion_id) REFERENCES user_suggestion (id)');
        $this->addSql('ALTER TABLE user_suggestion_mega_like ADD CONSTRAINT FK_7354A5DEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_suggestion_mega_like ADD CONSTRAINT FK_7354A5DEA41BB822 FOREIGN KEY (suggestion_id) REFERENCES user_suggestion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_choice DROP FOREIGN KEY FK_C6F6759A1E27F6BF');
        $this->addSql('ALTER TABLE user_question_choice DROP FOREIGN KEY FK_D42A19151E27F6BF');
        $this->addSql('ALTER TABLE user_question_choice DROP FOREIGN KEY FK_D42A19159053224A');
        $this->addSql('ALTER TABLE user_energy_choice DROP FOREIGN KEY FK_CE9356EFA76ED395');
        $this->addSql('ALTER TABLE user_question_choice DROP FOREIGN KEY FK_D42A1915A76ED395');
        $this->addSql('ALTER TABLE user_suggestion DROP FOREIGN KEY FK_7AE735F7A76ED395');
        $this->addSql('ALTER TABLE user_suggestion_like DROP FOREIGN KEY FK_B5DAE32FA76ED395');
        $this->addSql('ALTER TABLE user_suggestion_mega_like DROP FOREIGN KEY FK_7354A5DEA76ED395');
        $this->addSql('ALTER TABLE user_suggestion_like DROP FOREIGN KEY FK_B5DAE32FA41BB822');
        $this->addSql('ALTER TABLE user_suggestion_mega_like DROP FOREIGN KEY FK_7354A5DEA41BB822');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_choice');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_energy_choice');
        $this->addSql('DROP TABLE user_question_choice');
        $this->addSql('DROP TABLE user_suggestion');
        $this->addSql('DROP TABLE user_suggestion_like');
        $this->addSql('DROP TABLE user_suggestion_mega_like');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
