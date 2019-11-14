<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107190518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE ID_CATEGORIE ID_CATEGORIE INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE ID_CLIENT ID_CLIENT INT AUTO_INCREMENT NOT NULL, CHANGE ADRESSE_MAIL_NOTRE_MESSAGERIE ADRESSE_MAIL_NOTRE_MESSAGERIE VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE documentperso CHANGE ID_DOCUMENT ID_DOCUMENT INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE ID_ENTREPRISE ID_ENTREPRISE INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE ID_FACTURE ID_FACTURE INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE ID_CATEGORIE ID_CATEGORIE INT NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE ID_CLIENT ID_CLIENT INT NOT NULL, CHANGE ADRESSE_MAIL_NOTRE_MESSAGERIE ADRESSE_MAIL_NOTRE_MESSAGERIE VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE documentperso CHANGE ID_DOCUMENT ID_DOCUMENT INT NOT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE ID_ENTREPRISE ID_ENTREPRISE INT NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE ID_FACTURE ID_FACTURE INT NOT NULL');
    }
}
