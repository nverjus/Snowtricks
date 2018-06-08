# Snowtricks, a snowboarders community

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3be5a0b496fe4f92945aed3521420520)](https://www.codacy.com/app/nverjus/Snowtricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=nverjus/Snowtricks&amp;utm_campaign=Badge_Grade)

## Prerequisite installation

The project use [Docker](https://www.docker.com/), a containerisation tool, so the project has only 3 dependencies:

-   Docker (1.12+)
-   docker-compose (1.10+)
-   GNU make

> **Note**: if you're using Windows, we recommend using the Linux terminal in Windows 10
> (<https://msdn.microsoft.com/fr-fr/commandline/wsl/install_guide>) or to use a terminal emulator to be able to use Make

### Clone the project

    $ git clone git@github.com:nverjus/Snowtricks.git
    $ cd Snowtricks

Use `make` to see the Makefile help :

    $ make
    start                          Install and start the project
    stop                           Remove docker containers
    clear                          Remove all the cache, the logs and the sessions
    clean                          Clear and remove dependencies
    cc                             Clear the cache in dev and prod env
    tty                            Run app container in interactive mode
    db                             Reset the database and load fixtures

### Configuration

Duplicate `docker-compose.override.yml.dist` and name the copy `docker-compose.override.yml` in this file you can choose the port and the database informations for the application.

Duplicate `.env.dist` and name the copy `.env`.

Edit this line with your database informations : `DATABASE_URL=mysql://snowtricks:snowtricks@mysql:3306/snowtricks`

Edit this line with your mail server informations : `MAILER_URL=gmail://username:password@localhost`
Follow the links in the file for more informations.

Run `make start` to start the app.

By default, the app is reachable at `http://localhost:8080`
