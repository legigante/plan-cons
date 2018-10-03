<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180819100503 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE propertydate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasktype (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD type_id INT NOT NULL, ADD date_rla DATE DEFAULT NULL, ADD date_dpgf DATE DEFAULT NULL, ADD date_start DATE DEFAULT NULL, ADD date_expected_end DATE DEFAULT NULL, ADD date_recallage DATE DEFAULT NULL, ADD date_end DATE DEFAULT NULL, ADD is_closed TINYINT(1) NOT NULL, ADD date_strat DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25C54C8C93 FOREIGN KEY (type_id) REFERENCES tasktype (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25C54C8C93 ON task (type_id)');
        $this->addSql('ALTER TABLE user ADD color VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25C54C8C93');
        $this->addSql('DROP TABLE propertydate');
        $this->addSql('DROP TABLE tasktype');
        $this->addSql('DROP INDEX IDX_527EDB25C54C8C93 ON task');
        $this->addSql('ALTER TABLE task DROP type_id, DROP date_rla, DROP date_dpgf, DROP date_start, DROP date_expected_end, DROP date_recallage, DROP date_end, DROP is_closed, DROP date_strat');
        $this->addSql('ALTER TABLE user DROP color');
    }
}
