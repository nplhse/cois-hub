# COIS-Hub - Collaborative IVENA statistics

[![Continuous Integration](https://github.com/nplhse/cois-hub/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/nplhse/cois-hub/actions/workflows/continuous-integration.yml) [![codecov](https://codecov.io/gh/nplhse/cois-hub/graph/badge.svg?token=QJ4RX5ELW6)](https://codecov.io/gh/nplhse/cois-hub) [![Maintainability](https://api.codeclimate.com/v1/badges/ddf676af0fa232a4a540/maintainability)](https://codeclimate.com/github/nplhse/cois-hub/maintainability)

# Requirements
-   Webserver (Apache, Nginx, LiteSpeed, IIS, etc.) with PHP 8.2 or higher and MySQL 8.0 (or MariaDB 10.0) as database.

# Setup
This project expects you to have local webserver and a locally installed MySQL/MariaDB instance. Alternatively there is 
full support for Docker, see [Setup of your dev environment](CONTRIBUTING.md#setup-of-your-dev-environment) for more 
detailed information.

## Install from GitHub
1. Launch a **terminal** or **console** and navigate to the webroot folder. Clone 
[this repository from GitHub](https://github.com/nplhse/cois-hub) to a folder in the webroot of your server, e.g. 
`~/webroot/cois-hub`.

    ```
    $ cd ~/webroot
    $ git clone https://github.com/nplhse/cois-hub.git
    ```

2. Install the tool and it`s dependencies by using **make**:

    ```
    $ cd ~/webroot/cois-hub
    $ make setup
    ```

3. You are ready to go, just open the site with your favorite browser!

### Using Docker
This project includes full support for Docker which mainly includes the database, and we recommend using the 
[Symfony binary](https://github.com/symfony-cli/symfony-cli). There is a `make start` command that builds the containers
und starts them in detached mode. More about the `make` setup can be found in the [CONTRIBUTING](CONTRIBUTING.md) file 
at [available make commands](CONTRIBUTING.md#available-make-commands).

# Contributing
Any contribution to this project is appreciated, whether it is related to fixing bugs, suggestions or improvements. Feel
free to take your part in the development of this project!

However, you should follow some simple guidelines which you can find in the [CONTRIBUTING](CONTRIBUTING.md) file. Also, 
you must agree to the [Code of Conduct](CODE_OF_CONDUCT.md).

# License
See [LICENSE](LICENSE.md).
