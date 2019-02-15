<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215171527 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friendship ADD user2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F441B8B65 FOREIGN KEY (user2_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7234A45F441B8B65 ON friendship (user2_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45F441B8B65');
        $this->addSql('DROP INDEX IDX_7234A45F441B8B65 ON friendship');
        $this->addSql('ALTER TABLE friendship DROP user2_id');
    }
}
