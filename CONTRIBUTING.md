# Contributing to this project

Any contribution to this project is appreciated, whether it is related to fixing bugs, suggestions or improvements. Feel
free to take your part in the development!

However, you should follow the following simple guidelines for your contribution to be properly received:

-   This project uses the [GitFlow branching model](http://nvie.com/posts/a-successful-git-branching-model/) for the 
    process from development to release. Because of GitFlow contributions can only be accepted via pull requests on
    [GitHub](https://github.com/nplhse/cois).
-   Please keep in mind, that this project follows [SemVer v2.0.0](http://semver.org/).
-   You should make sure to follow the [PHP Standards Recommendations](http://www.php-fig.org/psr/) and the
    [Symfony best practices](http://symfony.com/doc/current/best_practices/index.html).
-   Also, you must agree to comply to the [Code of Conduct](CODE_OF_CONDUCT.md) of this project.

## Setup of your dev environment
This project expects you use its Docker integration or to have local webserver and a locally installed MySQL/MariaDB 
instance, see installation part of the [README](README.md). It seamlessly integrates with the 
[Symfony binary cli tool](https://github.com/symfony-cli/symfony-cli).

### Using Docker
If you'd like there is support for Docker which includes the following parts:

- [FrankenPHP](https://frankenphp.dev) as Webserver
- [MySQL](https://www.mysql.com) as Database with an [Adminer](https://www.adminer.org/de/) backend
- [MailCatcher](https://mailcatcher.me)

### Run Tests

To be able to run the tests properly you need to execute `make test-database`. This command creates the testing database
including the schema and all required fixtures.

If you have the need to re-populate the database with some fresh Fixtures you could either directly execute 
`bin/console doctrine:fixtures:load` or use `make reset-database` instead of `make reset` which resets the whole 
project.

When using these fixtures there are always several pre-configured Users by default:

| Username    | Password   | Description                         |
| ----------- |------------| ----------------------------------- |
| admin       | _password_ | **Admin** user with full privileges |
| foo         | _bar_      | Default user                        |

## Available make commands
| Command           | Description                                                                                                   |
|-------------------|---------------------------------------------------------------------------------------------------------------|
| help              | Outputs help screen                                                                                           |
| setup             | Setup the whole project                                                                                       |
| setup-dev         | Setup the project in dev environment                                                                          |
| install           | Install composer dependencies                                                                                 |
| setup-database    | Setup the database backend                                                                                    |
| setup-test-db     | Setup the test database                                                                                       |
| setup-fixtures    | Install the fixtures                                                                                          |
| reset-database    | Reset the whole database (caution!)                                                                           |
| checks            | Run check-styles and static-analysis                                                                          |
| ci                | Run CI pipeline                                                                                               |
| reset             | Reset pipeline for the whole project (caution!)                                                               |
| start             | Build and start the containers                                                                                |
| build             | Builds the Docker images                                                                                      |
| up                | Start the docker hub in detached mode (no logs)                                                               |
| down              | Stop the docker hub                                                                                           |
| logs              | Show live logs                                                                                                |
| sh                | Connect to the PHP FPM container                                                                              |
| composer          | Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack' |
| vendor            | Install vendors according to the current composer.lock file                                                   |
| sf                | List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about         |
| cc                | Clear the cache                                                                                               |
| cs                | Run all coding standards checks                                                                               |
| static-analysis   | Run the static analysis                                                                                       |
| lint-php          | Lint files with php-cs-fixer                                                                                  |
| fix-php           | Fix files with php-cs-fixer                                                                                   |
| eslint            | Run ESLint                                                                                                    |
| stan              | Run PHPStan                                                                                                   |
| psalm             | Run PHPStan                                                                                                   |
| test              | Run tests                                                                                                     |
