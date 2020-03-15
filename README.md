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

## Symfony Cloud

Now that the project is deployed, let's describe a typical scenario where you want to fix a bug or add a new feature.

First, you need to know that the master branch always represents the production environment. Any other branch is for developing new features, fixing bugs, or updating the infrastructure.

Let's create a new environment (a Git branch) to make some changes, without impacting production:

```
git checkout master
symfony env:create feat-a
```

This command creates a new local feat-a branch based on the master branch and activate a related environment on SymfonyCloud. If you have some services enabled, the new environment inherits the data of the parent environment (the production one here).

> If you want to check that the change is correct on your local machine, run `symfony server:start` and `symfony open:local` to test it in your local browser.

Commit the change:

```
git commit -a -m "Update text"
```

And deploy the change to the feat-a environment:

```
symfony deploy
```

Browse the new version and notice that the domain name is different now (each environment has its own domain name):

```
symfony open:remote
```

Iterate by changing the code, committing, and deploying. When satisfied with the changes, merge it to master, deploy, and remove the feature branch:

```
git checkout master
git merge feat-a
git branch -d feat-a
symfony env:delete feat-a
symfony deploy
```
