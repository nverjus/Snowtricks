# Snowtricks, a snowboarders community

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3be5a0b496fe4f92945aed3521420520)](https://www.codacy.com/app/nverjus/Snowtricks?utm_source=github.com&utm_medium=referral&utm_content=nverjus/Snowtricks&utm_campaign=Badge_Grade)

Test account :

<ul>
  <li>Role Admin
    <ul>
      <li>username : admin</li>
      <li>password : admin</li>
    </ul>
  </li>

### Clone the project

    $ git clone git@github.com:nverjus/Snowtricks.git
    $ cd Snowtricks

### Configuration

Duplicate `.env.dist` and name the copy `.env`.

Edit this line with your database informations : `DATABASE_URL=mysql://snowtricks:snowtricks@mysql:3306/snowtricks`

Edit this line with your mailer informations : `MAILER_URL=smtp://maildev:25`, default value work with MailDev Docker container

Follow the links in the file for more informations.

### Install without docker

#### Requirements

[Apache2 with rewrite mod enabled](https://httpd.apache.org/download.cgi)

[PHP 7.1](http://php.net/downloads.php)

[MySQL](https://www.mysql.com)

#### Installation

Copy the repository in your Apache web folder

On Linux : `/var/www/html/`

Move to directory

`$ cd path/to/directory`

Install [Composer](https://getcomposer.org/download/) and run

`$ php composer.phar install`

 To setup the database run :

 `$ php bin/console d:d:c`

 `$ php bin/console d:s:c`

 To load the fixtures run :

 `$ php bin/console d:f:l`

 Copy the 000-default.conf file to 'sites-availables' folder from Apache

 On Linux :

 `$ sudo cp docker/000-default.conf /etc/apache2/sites-available/000-default.conf`

 `$ sudo systemctl restart apache2`

 Run <http://localhost> in your web brower to access the app.

### Installation with Docker

#### Requirements

-   Docker (1.12+)
-   docker-compose (1.10+)
-   GNU make

#### Installation

Duplicate `docker-compose.override.yml.dist` and name the copy `docker-compose.override.yml`. In this file you can choose the port and the database informations for the application.

Use `make` to see the Makefile help :

    $ make
    start                          Install and start the project
    stop                           Remove docker containers
    clear                          Remove all the cache, the logs and the sessions
    clean                          Clear and remove dependencies
    cc                             Clear the cache in dev and prod env
    tty                            Run app container in interactive mode
    db                             Reset the database and load fixtures

Run `make start` to start the app.

By default, the app is reachable at `http://localhost:8080` and the mail server at `http://localhost:8001/`
