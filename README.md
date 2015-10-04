# Online Business Management System

Web application based on Symfony 2.7 for on-line business management.
This is a simple ERP, or a project of ERP.
This project was presented as a final project of studies.
It's a too big project and a very ambicious one, I know, but it's being made like a code kata for mantaining myself updated in knowledge.
Feel free to use, fork, clone, update, contribute, and please make pull requests of your improvements ;)
Licensed under the MIT license.

![AppBusinesses](https://raw.githubusercontent.com/obms/obms/master/web/img/AppBusinesses.png)

## Development Requirements

Developed with Composer, Bower, PHP, Apache2 and Doctrine compatible database.

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

## Manual installation

You need to install globally Composer and Bower for libraries management, both client and server libraries.
You also need Apache2, PHP, Postgres or other compatible database with Doctrine databases.

Later clone and deploy in your local machine, execute this:

    $ git clone git@github.com:obms/obms.git
    $ composer install --prefer-dist
    $ bower update
    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:create
    $ php app/console doctrine:fixtures:load

You can arbitrarily execute this for local development, it will create sample data deleting the old:

    $ php app/console sample:data

## Automatic installation with Vagrant

You need Vagrant and VirtualBox in your machine and 2 or more free RAM in development. Just execute:

    $ vagrant up

And wait 15-20 minutes the machine to configure itself. You will have a full development machine with
all installed ready to collaborate in the project.
If all have been done correctly, you can connect to:

    [http://127.0.0.1:8888/app_dev.php](http://127.0.0.1:8888/app_dev.php) with HTTP with the browser.
    [https://127.0.0.1:8889/app_dev.php](https://127.0.0.1:8889/app_dev.php) with HTTPS with the browser.
    [127.0.0.1:8890](127.0.0.1:8890) directly to Postgres (like connecting to localhost:5432).

Or connect to the machine using SSH executing:

    $ vagrant ssh

Remeber to execute all command line commands into the virtual machine not into your local machine.
To stop the machine execute:

    $ vagrant halt

When continue working on it execute again:

    $ vagrant up

You will have installed a VirtualBox machine with Linux, Apache2, PHP, Postgres and all others tools and configs
needed for development into the virtual machine.
When you finish working you can execute this from command line to clear
you local host machine:

    $ vagrant destroy

All traces of the project will be deleted unless this directory with sources, and your machine will be untouched by
this project.

## Tests

Execute for tests:

    $ phpunit -c app/

It needs phpunit command.

VERY IMPORTANT: Do not execute this in production environment. It will delete original data stored in linked database.

[Code coverage of PHP automated tests](http://obmscoverage.jnjsite.com/) (nightly build)

## Contributions

Feel free to contribute. You can fork the repository, make your own improvements and later make pull requests to this repository.
There is a branch for each piece that has been divided the web application.
If you don't know what to do you can browse the code and have more ideas there.

Please pass the tests before pushing.

[Documentation](http://obmsdoc.jnjsite.com/) (nightly build)

[Browse for code style improvements](http://obmscode.jnjsite.com/) (nightly build)

## More

This is free-time project, for practice purposes only. It can be a serious project in the future. All contributions are welcome.

That's all, enjoy.
