yiifeed
=======

yiifeed is a pre-moderated news aggregator. 


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application that your Web server supports PHP 5.4.0.


[API docs](modules/api/docs/index.md).

INSTALLATION
------------

### 1. Framework and dependencies

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this application template using the following command:

~~~
composer global require "fxp/composer-asset-plugin"
composer install
~~~


### 2. Configs

There are more `.php-orig` sample configs in `config` directory. Copy these to `.php` without `-orig` and adjust to your
needs.

### 3. Database

Create a database. By this moment you should have `config/db.php`. Specify your database connection there.

Then apply migrations by running:

```
yii migrate
```

### 4. Permissions 

Initilize permissions tree by running:

```
yii rbac/init 
```

You can use `rbac/assign` to assign roles to users:

```
yii rbac/assign admin alex
yii rbac/assign moderator boris
```

Will assign admin role to user with username=alex and moderator role to user with username=boris.

### 5. Cron

```
*/10 * * * * php yii queue/run > /dev/null 2>&1
```
