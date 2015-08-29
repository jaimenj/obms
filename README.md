# Online Business Management System

Web application based on Symfony 2.7 LTS for on-line business management.
It's a simple ERP, or a project of ERP.

## Development Requirements

Composer, Bower, PHP, Apache2 and MariaDB. Preferably it will be deployed on a Linux machine.

## Main structure and functionality

### FrontBundle

Just outside visits are done here. Users who have not been authenticated
or authorized will be here. It will display the relevant information.

### AppBundle

The main features of the application will be here.

### ApiBundle

REST API development.

### AdministracionBundle

Here is where access to the application is managed. Administrators may create
other administrator, as well as users.

## Installation

You need to install globally Composer and Bower for libraries management, both client and server libraries.

Download the project, and execute this:

	$ composer install --prefer-dist
	$ bower update
	$ php app/console doctrine:database:create
	$ php app/console doctrine:schema:create
	$ php app/console doctrine:fixtures:load

You can arbitrary execute this for local development, it will create example data:

	$ php app/console example:data

## Tests

Execute for tests before pushing:

	$ phpunit -c app/phpunit.xml

It needs phpunit command.

You can manually execute the tests with full configuration doing:

	$ phpunit -c app/phpunit.full.xml

Very important: Do not execute in production environment. It will delete original data stored in linked database in development/test environment.

# Builds

It's required Ant for building, just execute ant in project directory to build all.

	$ ant

This may be executed for nightly builds.

## More

This is free-time project, for practice purposes only. It can be a serious project in the future. All contributions are welcome.

That's all, enjoy.
