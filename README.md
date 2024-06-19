Car4Sure
========================

The "Car4Sure" is an Insurence Policy Management App.


Requirements
------------

  * PHP 8.2.0 or higher;
  * and the [usual Symfony application requirements][2].
  * Install Composer and NPM globally

Installation
------------

**Option 1.** Clone the code repository:

```bash
git clone https://github.com/nadeem-goolamhossen-dev/car4sure.git car4sure
cd car4sure/
```

**Option 2.** Open code editor:

```bash
open project in code editor
configure database settings in.env file, example  : DATABASE_URL="mysql://root@127.0.0.1:3306/car4sure?serverVersion=8.0.32&charset=utf8mb4"
```

**Option 3.** Run the following commands inside the project :

```bash
open terminal and execute the commands : 
composer install
npm install
php bin/console importmap:install
php bin/console asset-map:compile
```

**Option 4.** Initialise the app using this command:

```bash
composer require --dev orm-fixtures
composer require doctrine/doctrine-fixtures-bundle --dev
php bin/console app:init
```

<p align="left">
USERS : <br>
Admin : admin@gmail.com / admin <br>
User : user01@gmail.com / user
</p>

Usage
-----

There's no need to configure anything before running the application. There are
2 different ways of running this application depending on your needs:

**Option 1.** [Download Symfony CLI][4] and run this command:

```bash
cd car4sure/
symfony serve -d
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).


Tests
-----

Execute this command to run tests:

```bash
cd my_project/
./bin/phpunit
```

[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://symfony.com/doc/current/setup/web_server_configuration.html
[4]: https://symfony.com/download
[5]: https://symfony.com/book
[6]: https://getcomposer.org/
