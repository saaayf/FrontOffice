<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304160508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entretient (id INT AUTO_INCREMENT NOT NULL, id_rec_id INT DEFAULT NULL, date DATE NOT NULL, type VARCHAR(255) NOT NULL, resultat VARCHAR(255) NOT NULL, INDEX IDX_E34739B4305E0476 (id_rec_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (location VARCHAR(50) NOT NULL, PRIMARY KEY(location)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motive (motive VARCHAR(50) NOT NULL, PRIMARY KEY(motive)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, motive VARCHAR(50) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, location VARCHAR(50) DEFAULT NULL, status VARCHAR(50) DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, created_at DATE NOT NULL, file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_29D6873EF92CD178 (motive), INDEX IDX_29D6873E8CDE5729 (type), INDEX IDX_29D6873E5E9E89CB (location), INDEX IDX_29D6873E7B00651C (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_skills (id INT NOT NULL, skill VARCHAR(255) NOT NULL, INDEX IDX_C6461D1BF396750 (id), INDEX IDX_C6461D15E3DE477 (skill), PRIMARY KEY(id, skill)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (idrec INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(idrec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recrutement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (idrep INT AUTO_INCREMENT NOT NULL, reclamation_id INT NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5FB6DEC72D6BA2D9 (reclamation_id), PRIMARY KEY(idrep)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (skill VARCHAR(255) NOT NULL, PRIMARY KEY(skill)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (status VARCHAR(50) NOT NULL, PRIMARY KEY(status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (type VARCHAR(50) NOT NULL, PRIMARY KEY(type)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entretient ADD CONSTRAINT FK_E34739B4305E0476 FOREIGN KEY (id_rec_id) REFERENCES recrutement (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EF92CD178 FOREIGN KEY (motive) REFERENCES motive (motive)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E8CDE5729 FOREIGN KEY (type) REFERENCES type (type)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E5E9E89CB FOREIGN KEY (location) REFERENCES location (location)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E7B00651C FOREIGN KEY (status) REFERENCES status (status)');
        $this->addSql('ALTER TABLE offer_skills ADD CONSTRAINT FK_C6461D1BF396750 FOREIGN KEY (id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE offer_skills ADD CONSTRAINT FK_C6461D15E3DE477 FOREIGN KEY (skill) REFERENCES skill (skill)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (idrec)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entretient DROP FOREIGN KEY FK_E34739B4305E0476');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EF92CD178');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E8CDE5729');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E5E9E89CB');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E7B00651C');
        $this->addSql('ALTER TABLE offer_skills DROP FOREIGN KEY FK_C6461D1BF396750');
        $this->addSql('ALTER TABLE offer_skills DROP FOREIGN KEY FK_C6461D15E3DE477');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE entretient');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE motive');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_skills');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE recrutement');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
