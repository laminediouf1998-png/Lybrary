<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251230020533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur CHANGE nom_prenom nom_prenom VARCHAR(100) NOT NULL, CHANGE nationalite nationalite VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55AB14026EA0B0C ON auteur (nom_prenom)');
        $this->addSql('ALTER TABLE genre CHANGE nom nom VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_835033F86C6E55B5 ON genre (nom)');
        $this->addSql('ALTER TABLE livre CHANGE titre titre VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC634F99CC1CF4E6 ON livre (isbn)');
        $this->addSql('ALTER TABLE livre_auteur ADD CONSTRAINT FK_A11876B537D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_auteur ADD CONSTRAINT FK_A11876B560BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_55AB14026EA0B0C ON auteur');
        $this->addSql('ALTER TABLE auteur CHANGE nom_prenom nom_prenom VARCHAR(255) NOT NULL, CHANGE nationalite nationalite VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_835033F86C6E55B5 ON genre');
        $this->addSql('ALTER TABLE genre CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_AC634F99CC1CF4E6 ON livre');
        $this->addSql('ALTER TABLE livre CHANGE titre titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE livre_auteur DROP FOREIGN KEY FK_A11876B537D925CB');
        $this->addSql('ALTER TABLE livre_auteur DROP FOREIGN KEY FK_A11876B560BB6FE6');
        $this->addSql('ALTER TABLE livre_genre DROP FOREIGN KEY FK_1053AB9E37D925CB');
        $this->addSql('ALTER TABLE livre_genre DROP FOREIGN KEY FK_1053AB9E4296D31F');
    }
}
