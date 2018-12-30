<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181230131538 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE picture');
        $this->addSql('ALTER TABLE spot CHANGE paying paying INT NOT NULL, CHANGE type type INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, user_avatar_id INT DEFAULT NULL, user_gallery_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_16DB4F89A3806963 (user_gallery_id), UNIQUE INDEX UNIQ_16DB4F8986D8B6F4 (user_avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8986D8B6F4 FOREIGN KEY (user_avatar_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89A3806963 FOREIGN KEY (user_gallery_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE spot CHANGE paying paying VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE type type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
