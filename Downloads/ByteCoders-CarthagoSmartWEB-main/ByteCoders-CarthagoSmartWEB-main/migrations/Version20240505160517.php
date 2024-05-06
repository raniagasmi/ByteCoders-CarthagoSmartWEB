<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505160517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recyclagedechets DROP FOREIGN KEY fk_typeD');
        $this->addSql('DROP TABLE collectdechets');
        $this->addSql('DROP TABLE recyclagedechets');
        $this->addSql('DROP TABLE typedechets');
        $this->addSql('ALTER TABLE user CHANGE roleUser roleUser JSON DEFAULT NULL, CHANGE urlImage urlImage VARCHAR(255) DEFAULT NULL, CHANGE confirmationCode confirmationCode VARCHAR(255) DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, CHANGE google_id google_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE consommation DROP FOREIGN KEY fk_userc');
        $this->addSql('ALTER TABLE consommation CHANGE id id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consommation RENAME INDEX fk_userc TO fk_user_c');
        $this->addSql('ALTER TABLE event DROP image');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY fk_user');
        $this->addSql('ALTER TABLE facture CHANGE imageF imageF VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE facture RENAME INDEX fk_userf TO fk_user');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY fk_user_conso');
        $this->addSql('ALTER TABLE paiement CHANGE id_facture id_facture INT DEFAULT NULL, CHANGE id id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paiement RENAME INDEX fk_userp TO fk_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collectdechets (id INT AUTO_INCREMENT NOT NULL, PointRamassage VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, DateRamassage DATE NOT NULL, typeid INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE recyclagedechets (id_recyc INT AUTO_INCREMENT NOT NULL, id INT NOT NULL, PointRecyclage VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_typeD (id), PRIMARY KEY(id_recyc)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE typedechets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categorie VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recyclagedechets ADD CONSTRAINT fk_typeD FOREIGN KEY (id) REFERENCES typedechets (id)');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE consommation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE consommation RENAME INDEX fk_user_c TO fk_userc');
        $this->addSql('ALTER TABLE event ADD image VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE facture CHANGE imageF imageF VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE facture RENAME INDEX fk_user TO fk_userf');
        $this->addSql('ALTER TABLE paiement CHANGE id_facture id_facture INT NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement RENAME INDEX fk_user TO fk_userp');
        $this->addSql('ALTER TABLE User CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\', CHANGE roleUser roleUser LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE urlImage urlImage VARCHAR(255) DEFAULT \'NULL\', CHANGE confirmationCode confirmationCode VARCHAR(255) DEFAULT \'NULL\', CHANGE google_id google_id VARCHAR(255) DEFAULT \'NULL\'');
    }
}
