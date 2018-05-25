<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525075439 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, color_id INT NOT NULL, mood_id INT NOT NULL, name VARCHAR(100) NOT NULL, dob DATETIME DEFAULT NOW(), INDEX IDX_9E5E43A87ADA1FB5 (color_id), UNIQUE INDEX UNIQ_9E5E43A8B889D33E (mood_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cat_food (cat_id INT NOT NULL, food_id INT NOT NULL, INDEX IDX_C90BDE46E6ADA943 (cat_id), INDEX IDX_C90BDE46BA8E87C4 (food_id), PRIMARY KEY(cat_id, food_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cat ADD CONSTRAINT FK_9E5E43A87ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE cat ADD CONSTRAINT FK_9E5E43A8B889D33E FOREIGN KEY (mood_id) REFERENCES mood (id)');
        $this->addSql('ALTER TABLE cat_food ADD CONSTRAINT FK_C90BDE46E6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cat_food ADD CONSTRAINT FK_C90BDE46BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cat_food DROP FOREIGN KEY FK_C90BDE46E6ADA943');
        $this->addSql('ALTER TABLE cat DROP FOREIGN KEY FK_9E5E43A87ADA1FB5');
        $this->addSql('ALTER TABLE cat_food DROP FOREIGN KEY FK_C90BDE46BA8E87C4');
        $this->addSql('ALTER TABLE cat DROP FOREIGN KEY FK_9E5E43A8B889D33E');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE cat_food');
    }
}
