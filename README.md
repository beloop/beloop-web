# beloop-web

Website for Beloop LMS

## Requirements

Before starting the application you must:

* Install PHP 7.2 or higher and these PHP extensions (which are installed and enabled by default in most PHP 7 installations): Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer;
* Install Composer, which is used to install PHP packages;
* Install MySQL, since igt is the DB engine used by the application.

The symfony binary provides a tool to check if your computer meets these requirements. Open your console terminal and run this command:

```bash
bin/symfony_requirements
```

## Installation

Install project dependencies using composer:

```bash
composer install
```

After the installation you will be asked to provided configuration values, like database host and such. Please provided correct values, as they are neded to run the application.

Create the databases running these commands:

```bash
php bin/console doctrine:database:create --connection=default
php bin/console doctrine:database:create --connection=analytics
```

Once databases have been created, run these commands to create the schemas:

```bash
php bin/console doctrine:schema:create --em=default
php bin/console doctrine:schema:create --em=analytics
```

And finally, populate the tables with some dummy data:

```bash
php bin/console doctrine:fixtures:load --em=default
php bin/console doctrine:fixtures:load --em=analytics
```

## Getting started

Start the server, and use `admin@gmail.com:1234` as login credentials:

```bash
php bin/console assetic:watch
php bin/console server:run
```
