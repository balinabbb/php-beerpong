REST API Template
=================

This is a template for generating a RESTful API based on the Symfony
Framework.^You can use this as a Composer Template for new projects.

```
composer create-project thetodd/rest-template
```

Bundles
--------------

# OAuthBundle
The OAuthBundle manages acces to the API via OAuth 2.0.

# AppBundle
Your API is generated in this Bundle. If you want to rename it or create another
Bundle, you can do it.

## New Entity
In every API there are several entities. If you want to create a new entity
please use the doctrine commands shipped with symfony.

```
php bin/console doctrine:generate:entity
```

When the entity is fully generated you should generate some getters and setters.

```
php bin/console doctrine:generate:entities AppBundle
```

Then you have to create the corresponding tables in you database. Please configure
your database connection at first in the parameters yaml file.

```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Routing
Routing is based on the annotations in the controllers. Please see AppBundle/PostController
for further information.

## Controllers
Every new Controller has to extend the BaseController, to use the JSON API functions.

Enjoy!
