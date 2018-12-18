<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213150639 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_position DROP FOREIGN KEY FK_A7D40644CFFE9AD6');
        $this->addSql('DROP INDEX IDX_A7D40644CFFE9AD6 ON order_position');
        $this->addSql('ALTER TABLE order_position DROP orders_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_position ADD orders_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_position ADD CONSTRAINT FK_A7D40644CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('CREATE INDEX IDX_A7D40644CFFE9AD6 ON order_position (orders_id)');
    }
}
