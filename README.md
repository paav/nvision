# Overview

Programming challenge from [www.nvbs.ru](http://www.nvbs.ru/).


# Requirements

Requirements are [here](_develop/requirements/reuirements.txt).


# Installation

1. `git clone https://github.com/paav/nvision.git`
2. `cd nvision`
3. `composer install`
4. Create database.
6. Configure database connection in an `app/config/parameters.yml` file.
7. Create database tables with a `php bin/console doctrine:schema:update --force` command.
8. Create virtual host (for Apache web server).

    Example:
    
    ```
    <VirtualHost *:80>
        DocumentRoot "/Users/alexey/www/nvision/web"
        ServerName nvision.dev
        ErrorLog "/Users/alexey/log/nvision-error_log"
        CustomLog "/Users/alexey/log/nvision-access_log" common
    </VirtualHost>
    ```

9. Open `http://nvision.dev` in your favorite browser.


# Input Data Uploading

## Method One

Make all steps from the [Installation](#installation) section.

```shell
mysql -u[your_db_user] -p[your_db_password] [db_name] <_develop/dump_data-only.sql
```

## Method Two

Make all steps from the [Installation](#installation) section.

Navigate to `http://nvision.dev/uploads` using your favorite browser and follow instructions on that page.


# Miscellanea

Full database dump (tables and data) is [here](_develop/dump_full.sql).

