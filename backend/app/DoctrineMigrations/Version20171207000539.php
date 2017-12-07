<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171207000539 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE cup (id INTEGER NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE player (id INTEGER NOT NULL, name VARCHAR(140) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE result (id INTEGER NOT NULL, cup INTEGER DEFAULT NULL, team1player1 INTEGER DEFAULT NULL, team1player2 INTEGER DEFAULT NULL, team2player1 INTEGER DEFAULT NULL, team2player2 INTEGER DEFAULT NULL, team1score INTEGER NOT NULL, team2score INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_136AC113B79D50E4 ON result (cup)');
        $this->addSql('CREATE INDEX IDX_136AC1138484A0A4 ON result (team1player1)');
        $this->addSql('CREATE INDEX IDX_136AC1131D8DF11E ON result (team1player2)');
        $this->addSql('CREATE INDEX IDX_136AC113A0BA747 ON result (team2player1)');
        $this->addSql('CREATE INDEX IDX_136AC1139302F6FD ON result (team2player2)');
        $this->addSql('CREATE TABLE access_token (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6A2DD685F37A13B ON access_token (token)');
        $this->addSql('CREATE INDEX IDX_B6A2DD6819EB6921 ON access_token (client_id)');
        $this->addSql('CREATE INDEX IDX_B6A2DD68A76ED395 ON access_token (user_id)');
        $this->addSql('CREATE TABLE auth_code (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri CLOB NOT NULL, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5933D02C5F37A13B ON auth_code (token)');
        $this->addSql('CREATE INDEX IDX_5933D02C19EB6921 ON auth_code (client_id)');
        $this->addSql('CREATE INDEX IDX_5933D02CA76ED395 ON auth_code (user_id)');
        $this->addSql('CREATE TABLE client (id INTEGER NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris CLOB NOT NULL, secret VARCHAR(255) NOT NULL, allowed_grant_types CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE refresh_token (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F21955F37A13B ON refresh_token (token)');
        $this->addSql('CREATE INDEX IDX_C74F219519EB6921 ON refresh_token (client_id)');
        $this->addSql('CREATE INDEX IDX_C74F2195A76ED395 ON refresh_token (user_id)');
        $this->addSql('CREATE TABLE fos_user (id INTEGER NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE cup');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE fos_user');
    }
}
