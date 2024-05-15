<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515120840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, purchase_line_id INT DEFAULT NULL, amount INT NOT NULL, INDEX IDX_6117D13B56A1BF3B (purchase_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_line (id INT AUTO_INCREMENT NOT NULL, date_created DATE NOT NULL, date_update DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B56A1BF3B FOREIGN KEY (purchase_line_id) REFERENCES purchase_line (id)');
        $this->addSql('ALTER TABLE product ADD purchase_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD558FBEB9 ON product (purchase_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD558FBEB9');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B56A1BF3B');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_line');
        $this->addSql('DROP INDEX IDX_D34A04AD558FBEB9 ON product');
        $this->addSql('ALTER TABLE product DROP purchase_id');
    }
}
