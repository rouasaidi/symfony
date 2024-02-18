<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215140407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_497DD634A76ED395 ON categorie (user_id)');
        $this->addSql('ALTER TABLE feedback_don ADD donation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feedback_don ADD CONSTRAINT FK_E02AB6614DC1279C FOREIGN KEY (donation_id) REFERENCES donation (id)');
        $this->addSql('CREATE INDEX IDX_E02AB6614DC1279C ON feedback_don (donation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634A76ED395');
        $this->addSql('DROP INDEX IDX_497DD634A76ED395 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP user_id');
        $this->addSql('ALTER TABLE feedback_don DROP FOREIGN KEY FK_E02AB6614DC1279C');
        $this->addSql('DROP INDEX IDX_E02AB6614DC1279C ON feedback_don');
        $this->addSql('ALTER TABLE feedback_don DROP donation_id');
    }
}
