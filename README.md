# Kyoto Web Interface #

> This is a web interface designed to manage large amounts of country data and provide simple steps to create a simulation profile in mongodb. The site will also be used to perform analysis with useful charts.

## Operation ##

- admin/data.csv is loaded to show countries init data
- admin/params.csv loads the other parameters for simulation
- Shows simulation inspector/editor
- Shows simulation->country inspector/editor

## Requirements ##

- Apache
- PHP 5.3
	- Your main config file PHP.INI modification as outlined in /php.ini requires the following modifications
	- `extension=php_mongo.dll`
	- `mongo.native_long = 1`  (only required if having trouble with NumberLong/LongInt type)
- MongoDB plugin for PHP http://www.php.net/manual/en/mongo.installation.php OR https://github.com/mongodb/mongo-php-driver/downloads
- Permissions on folder /templates_c must be writeable for smarty.
- Be warned - some google visualisations require flash


## Installation Suggestions ##

- Linux
	- php5-cli
	- apache2
	- https://help.ubuntu.com/community/ApacheMySQLPHP

- OSX
	- mamp?


- Windows
	- WAMP - http://www.wampserver.com/en/
	- Convenient if installed to - C:\wamp\www\KyotoInterface\


## Useful ##

- `admin/config.php` : DB connection & Defaults
- `new MongoInt64(0)` : use to cast NumberLong() for java with mongo php
- Template Engine: http://www.smarty.net/
- CSS & Javascript Template: http://twitter.github.com/bootstrap/
- Mongo DB ORM https://github.com/lunaru/MongoRecord