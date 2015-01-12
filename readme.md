# SIMPLEREADER #
Simplepie RSS Reader built with laravel
## Information ##
* Laravel Version: **4.2**

## Requirements ##

Composer is required to install laravel and its dependancies
* https://getcomposer.org/

PHP from command line
(add php.exe to your ENV)

## Installation ##

* Clone repo to your working dir or download the last version from https://github.com/xdubois/simpleReader/archive/master.zip
* Create an empty database
* go to "website" folder with a command line interpreter
* run: composer update
* Create a `.env.local.php` file in the `website/laravel/` folder and put in the following, changing the values as necessary or run the command "php artisan db:configure":
```
<?php

return array(
  'DB_HOST' => 'localhost',
  'DB_NAME' => 'simplereader',
  'DB_USERNAME' => 'root',
  'DB_PASSWORD' => '',
);
```
* run: php artisan app:install

You're app is now ready to use.
Visit /public folder

## Optionnal ##

Set your document_root to /public folder
