# elgg-dockerized
This repository contains all stuff to run the social network engine elgg in a docker environment. 
This repository was made to work with docker-compose. Feel free to use it, but remember if you use it, you use it at your own risk. ;)


## What is included:

+ A Dockerfile based on Debian bookworm with PHP8.02-FPM and all needed packages for elgg (gd, mbstring, ...) and chaching stuff.
+ Included memcache packages
+ Included redis packages
+ Included opcache packages
+ Included imagick
+ A docker-compose.yml for quick start
+ A basic env-file for your customize settings
+ Configuration files for PHP and Nginx (so you can customize it)

## Which Elgg-Version will be installed

In this commit the actual elgg version **5.1.0** will be installed, but you can change to lower Versions too.

## How to use

+ Download or clone this repository
+ Rename the file env-file to .env
+ Customize the .env file with your credentials (db and elgg) and elgg site settings.
+ Customize the docker-compose.yml if you want. This file will start a redis and memcache service too. If you not need them, delete them.
+ Create the folders elgg-db,elgg-varhtml and elgg-vardata. (or create your own custom folder and map them to the service volumes.)
+ As DB-Host, Memcached-Host and Redis-Host you can use the service names. In default based on this docker-compose.yml this is elgg-db as Mysql/Mariadb host, elgg-memcached as Memchached host and elgg-redis as Redis host.
+ If you want to customize the configuration for nginx or php-fpm, you can do this in the config folder.
+ If everything is customized, then run the follwing commad in your folder: `docker-compose build --no-cache`
+ If the build is done then you can start your new elgg image with `docker-compose up` for foreground or `docker-compose up -d`.
+ That's it.

> [!NOTE]
> The basic elgg configuration (create admin account and settings.php) runs only on the first start of the container, if you want to run this again, you have to delete the file CONTAINER_INITIALISATION_COMPLETE_PLACEHOLDER in the elgg-varhtml folder and restart the container.

> [!NOTE]
> The Elgg-Site will be available on Port 8980 (by default, of course you can change it) which is mapped on the Port 80 inside the container and http only. If you want to secure your site (and you really should) you can install a reverse proxy server on your host which makes the SSL connection for you and use the backend http://localhost:8980. Make sure the Port 8980 is not available from the internet (firewalling.) If your reverse proxy has a SSL certificate for the domain my-elgg.com (in example) then your elgg parameter `ELGG_WWW_ROOT` should look like `https://my-elgg.com/`. 


## The .env file in explanation

The .env ist the only place, where you have to curtomize your credentials or site settings for a basic elgg site. Of course you can customize your site in the settings.php later too.
This .env file has set the following env variables, which will be used automatically by docker-compose.
```
#Elgg-Version to use (change this if you want a lower or maybe in the furture a higher version)
ELGG_VERSION="5.1.0"
# Mysql-DB Container Parameter
MYSQL_ROOT_PASSWORD="password"
# The Databse which to use for elgg
MYSQL_DATABASE="elgg"
# The DB-User for elgg
MYSQL_USER="elgg"
# The Password for the DB-User for elgg
MYSQL_PASSWORD="elgg"
# Optional show log console messages
MYSQL_LOG_CONSOLE="true"
# Elgg-App Container Parameter
## Elgg Databasesettings
# The DB-User for elgg
ELGG_DB_USER="elgg"
# The Password for the DB-User for elgg
ELGG_DB_PASS="elgg"
# Use here the service name of the mysql/mariadb service, NOT the container name.
ELGG_DB_HOST="elgg-db"
# The DB-User for elgg
ELGG_DB_NAME="elgg"
# The DB-Port default 3306
ELGG_DB_PORT="3306"
# The Table-Prefix for elgg tables
ELGG_DB_PREFIX="elgg_"
# Elgg Admin-Account
ELGG_USERNAME="admin"
ELGG_PASSWORD="admin-password"
ELGG_DISPLAY_NAME="Admin"
ELGG_EMAIL="adminmail@yourelgg.com"
# Elggsite-Settings
ELGG_WWW_ROOT="http://localhost/"
ELGG_SITE_NAME="My Elgg Site"
ELGG_SITE_ACCESS="2"
# The Elgg Path inside the image. Important, only change this when you know what you do. A change is not needed.
ELGG_DATA_ROOT="/var/www/data/"
ELGG_PATH="/var/www/html/"
```

enjoy your elgg.
