<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190521123334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, spot_id INT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, start_date_at DATETIME NOT NULL, end_date_at DATETIME NOT NULL, INDEX IDX_D044D5D42DF1D37C (spot_id), INDEX IDX_D044D5D4F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_user (session_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4BE2D663613FECDF (session_id), INDEX IDX_4BE2D663A76ED395 (user_id), PRIMARY KEY(session_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D42DF1D37C FOREIGN KEY (spot_id) REFERENCES spot (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session_user ADD CONSTRAINT FK_4BE2D663613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_user ADD CONSTRAINT FK_4BE2D663A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE session_user DROP FOREIGN KEY FK_4BE2D663613FECDF');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_user');
    }
}
