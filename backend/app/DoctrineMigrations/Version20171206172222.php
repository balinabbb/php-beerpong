<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171206172222 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_136AC113B79D50E4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__result AS SELECT id, cup FROM result');
        $this->addSql('DROP TABLE result');
        $this->addSql('CREATE TABLE result (id INTEGER NOT NULL, cup INTEGER DEFAULT NULL, team1player1 INTEGER DEFAULT NULL, team1player2 INTEGER DEFAULT NULL, team2player1 INTEGER DEFAULT NULL, team2player2 INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_136AC113B79D50E4 FOREIGN KEY (cup) REFERENCES cup (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_136AC1138484A0A4 FOREIGN KEY (team1player1) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_136AC1131D8DF11E FOREIGN KEY (team1player2) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_136AC113A0BA747 FOREIGN KEY (team2player1) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_136AC1139302F6FD FOREIGN KEY (team2player2) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO result (id, cup) SELECT id, cup FROM __temp__result');
        $this->addSql('DROP TABLE __temp__result');
        $this->addSql('CREATE INDEX IDX_136AC113B79D50E4 ON result (cup)');
        $this->addSql('CREATE INDEX IDX_136AC1138484A0A4 ON result (team1player1)');
        $this->addSql('CREATE INDEX IDX_136AC1131D8DF11E ON result (team1player2)');
        $this->addSql('CREATE INDEX IDX_136AC113A0BA747 ON result (team2player1)');
        $this->addSql('CREATE INDEX IDX_136AC1139302F6FD ON result (team2player2)');
        $this->addSql('DROP INDEX IDX_B6A2DD68A76ED395');
        $this->addSql('DROP INDEX IDX_B6A2DD6819EB6921');
        $this->addSql('DROP INDEX UNIQ_B6A2DD685F37A13B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__access_token AS SELECT id, client_id, user_id, token, expires_at, scope FROM access_token');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('CREATE TABLE access_token (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_B6A2DD6819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO access_token (id, client_id, user_id, token, expires_at, scope) SELECT id, client_id, user_id, token, expires_at, scope FROM __temp__access_token');
        $this->addSql('DROP TABLE __temp__access_token');
        $this->addSql('CREATE INDEX IDX_B6A2DD68A76ED395 ON access_token (user_id)');
        $this->addSql('CREATE INDEX IDX_B6A2DD6819EB6921 ON access_token (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6A2DD685F37A13B ON access_token (token)');
        $this->addSql('DROP INDEX IDX_5933D02CA76ED395');
        $this->addSql('DROP INDEX IDX_5933D02C19EB6921');
        $this->addSql('DROP INDEX UNIQ_5933D02C5F37A13B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_code AS SELECT id, client_id, user_id, token, redirect_uri, expires_at, scope FROM auth_code');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('CREATE TABLE auth_code (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, redirect_uri CLOB NOT NULL COLLATE BINARY, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_5933D02C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5933D02CA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO auth_code (id, client_id, user_id, token, redirect_uri, expires_at, scope) SELECT id, client_id, user_id, token, redirect_uri, expires_at, scope FROM __temp__auth_code');
        $this->addSql('DROP TABLE __temp__auth_code');
        $this->addSql('CREATE INDEX IDX_5933D02CA76ED395 ON auth_code (user_id)');
        $this->addSql('CREATE INDEX IDX_5933D02C19EB6921 ON auth_code (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5933D02C5F37A13B ON auth_code (token)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, random_id, secret, redirect_uris, allowed_grant_types FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER NOT NULL, random_id VARCHAR(255) NOT NULL COLLATE BINARY, secret VARCHAR(255) NOT NULL COLLATE BINARY, redirect_uris CLOB NOT NULL, allowed_grant_types CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO client (id, random_id, secret, redirect_uris, allowed_grant_types) SELECT id, random_id, secret, redirect_uris, allowed_grant_types FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('DROP INDEX IDX_C74F2195A76ED395');
        $this->addSql('DROP INDEX IDX_C74F219519EB6921');
        $this->addSql('DROP INDEX UNIQ_C74F21955F37A13B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__refresh_token AS SELECT id, client_id, user_id, token, expires_at, scope FROM refresh_token');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('CREATE TABLE refresh_token (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_C74F219519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C74F2195A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO refresh_token (id, client_id, user_id, token, expires_at, scope) SELECT id, client_id, user_id, token, expires_at, scope FROM __temp__refresh_token');
        $this->addSql('DROP TABLE __temp__refresh_token');
        $this->addSql('CREATE INDEX IDX_C74F2195A76ED395 ON refresh_token (user_id)');
        $this->addSql('CREATE INDEX IDX_C74F219519EB6921 ON refresh_token (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F21955F37A13B ON refresh_token (token)');
        $this->addSql('DROP INDEX UNIQ_957A6479C05FB297');
        $this->addSql('DROP INDEX UNIQ_957A6479A0D96FBF');
        $this->addSql('DROP INDEX UNIQ_957A647992FC23A8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__fos_user AS SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles FROM fos_user');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('CREATE TABLE fos_user (id INTEGER NOT NULL, username VARCHAR(180) NOT NULL COLLATE BINARY, username_canonical VARCHAR(180) NOT NULL COLLATE BINARY, email VARCHAR(180) NOT NULL COLLATE BINARY, email_canonical VARCHAR(180) NOT NULL COLLATE BINARY, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL COLLATE BINARY, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO fos_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles) SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles FROM __temp__fos_user');
        $this->addSql('DROP TABLE __temp__fos_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_B6A2DD685F37A13B');
        $this->addSql('DROP INDEX IDX_B6A2DD6819EB6921');
        $this->addSql('DROP INDEX IDX_B6A2DD68A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__access_token AS SELECT id, client_id, user_id, token, expires_at, scope FROM access_token');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('CREATE TABLE access_token (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO access_token (id, client_id, user_id, token, expires_at, scope) SELECT id, client_id, user_id, token, expires_at, scope FROM __temp__access_token');
        $this->addSql('DROP TABLE __temp__access_token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6A2DD685F37A13B ON access_token (token)');
        $this->addSql('CREATE INDEX IDX_B6A2DD6819EB6921 ON access_token (client_id)');
        $this->addSql('CREATE INDEX IDX_B6A2DD68A76ED395 ON access_token (user_id)');
        $this->addSql('DROP INDEX UNIQ_5933D02C5F37A13B');
        $this->addSql('DROP INDEX IDX_5933D02C19EB6921');
        $this->addSql('DROP INDEX IDX_5933D02CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_code AS SELECT id, client_id, user_id, token, redirect_uri, expires_at, scope FROM auth_code');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('CREATE TABLE auth_code (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri CLOB NOT NULL, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO auth_code (id, client_id, user_id, token, redirect_uri, expires_at, scope) SELECT id, client_id, user_id, token, redirect_uri, expires_at, scope FROM __temp__auth_code');
        $this->addSql('DROP TABLE __temp__auth_code');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5933D02C5F37A13B ON auth_code (token)');
        $this->addSql('CREATE INDEX IDX_5933D02C19EB6921 ON auth_code (client_id)');
        $this->addSql('CREATE INDEX IDX_5933D02CA76ED395 ON auth_code (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, random_id, redirect_uris, secret, allowed_grant_types FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER NOT NULL, random_id VARCHAR(255) NOT NULL, secret VARCHAR(255) NOT NULL, redirect_uris CLOB NOT NULL COLLATE BINARY, allowed_grant_types CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO client (id, random_id, redirect_uris, secret, allowed_grant_types) SELECT id, random_id, redirect_uris, secret, allowed_grant_types FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('DROP INDEX UNIQ_957A647992FC23A8');
        $this->addSql('DROP INDEX UNIQ_957A6479A0D96FBF');
        $this->addSql('DROP INDEX UNIQ_957A6479C05FB297');
        $this->addSql('CREATE TEMPORARY TABLE __temp__fos_user AS SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles FROM fos_user');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('CREATE TABLE fos_user (id INTEGER NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO fos_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles) SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles FROM __temp__fos_user');
        $this->addSql('DROP TABLE __temp__fos_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
        $this->addSql('DROP INDEX UNIQ_C74F21955F37A13B');
        $this->addSql('DROP INDEX IDX_C74F219519EB6921');
        $this->addSql('DROP INDEX IDX_C74F2195A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__refresh_token AS SELECT id, client_id, user_id, token, expires_at, scope FROM refresh_token');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('CREATE TABLE refresh_token (id INTEGER NOT NULL, client_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INTEGER DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO refresh_token (id, client_id, user_id, token, expires_at, scope) SELECT id, client_id, user_id, token, expires_at, scope FROM __temp__refresh_token');
        $this->addSql('DROP TABLE __temp__refresh_token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74F21955F37A13B ON refresh_token (token)');
        $this->addSql('CREATE INDEX IDX_C74F219519EB6921 ON refresh_token (client_id)');
        $this->addSql('CREATE INDEX IDX_C74F2195A76ED395 ON refresh_token (user_id)');
        $this->addSql('DROP INDEX IDX_136AC113B79D50E4');
        $this->addSql('DROP INDEX IDX_136AC1138484A0A4');
        $this->addSql('DROP INDEX IDX_136AC1131D8DF11E');
        $this->addSql('DROP INDEX IDX_136AC113A0BA747');
        $this->addSql('DROP INDEX IDX_136AC1139302F6FD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__result AS SELECT id, cup FROM result');
        $this->addSql('DROP TABLE result');
        $this->addSql('CREATE TABLE result (id INTEGER NOT NULL, cup INTEGER DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO result (id, cup) SELECT id, cup FROM __temp__result');
        $this->addSql('DROP TABLE __temp__result');
        $this->addSql('CREATE INDEX IDX_136AC113B79D50E4 ON result (cup)');
    }
}
