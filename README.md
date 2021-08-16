# Sunflowerseed

## Prerequisites

- php >= 7.2.5
- composer

## Development

```
$ git clone git@github.com:MichinobuMaeda/sunflowerseed.git
$ cd sunflowerseed
$ composer install
$ npm install
$ cp .env.local .env
$ cp tests/local/test.php public/
$ touch storage/database.sqlite
$ php artisan migrate:fresh
$ php artisan serve
``` 

for php 7.2

```
$ curl -s https://getcomposer.org/installer | php7.2
$ php7.2 composer.phar install
```

## Create this project

https://github.com/MichinobuMaeda?tab=repositories

- [New]
    - Repository name: sunflowerseed

```
$ composer create-project --prefer-dist laravel/laravel:^7.0 sunflowerseed
$ cd sunflowerseed
$ git init
$ git add .
$ git commit -m "first commit"
$ git branch -M main
$ git remote add origin git@github.com:MichinobuMaeda/sunflowerseed.git
$ git push -u origin main
$ composer require laravel/ui:^2.0 --dev
$ php artisan ui bootstrap
$ npm install
$ npm install bootstrap@next @popperjs/core --save-dev
$ npm install bootstrap @popperjs/core --save-dev
$ npm run dev
```
