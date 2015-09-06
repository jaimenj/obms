# Online Business Management System

Web application based on Symfony 2.7 LTS for on-line business management.
This is a simple ERP, or a project of ERP, a project presented as a final studies project.
It's a too big project and a very ambicious one, I know, but it's been made like a code kata for mantaining myself updated in knowledge.
Feel free to use, fork, clone, update, contribute, make pull requests, and call me for work if you have money ;)

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

### AdministrationBundle

Here is where access to the application is managed. Administrators may create
other administrator, as well as users.

## Installation

You need to install globally Composer and Bower for libraries management, both client and server libraries.

Download the project cloneing it, and execute this:

	$ git clone git@github.com:jaimenj/obms.git
	$ composer install --prefer-dist
	$ bower update
	$ php app/console doctrine:database:create
	$ php app/console doctrine:schema:create
	$ php app/console doctrine:fixtures:load

You can arbitrary execute this for local development, it will create sample data:

	$ php app/console sample:data

## Tests

Execute for tests:

	$ phpunit -c app/

It needs phpunit command.

Very important: Do not execute in production environment. It will delete original data stored in linked database in development/test environment.

## More

This is free-time project, for practice purposes only. It can be a serious project in the future. All contributions are welcome.

That's all, enjoy.
