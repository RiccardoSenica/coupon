# Installation

Requirements:
- PHP >= 7.3
- MySQL
- Composer

Installation (Mac):
- brew install php
- brew install mysql
- curl -sS https://getcomposer.org/installer | php
- mv compose.phar /usr/local/bin/composer
- chmod +x /usr/local/bin/composer

Create a db and a user with write privileges:
- mysql -uroot
- create database coupon;
- create user ‘coupon_user’ identified with mysql_native_password by ‘password’;
- grant all privileges on coupon.* to ‘coupon_user’;
- quit;

Prepare project (run in project root folder):
- [add the variables to .env]
- composer install
- php artisan migrate:fresh

Launch project (run in project root folder, different terminals):
- php -S localhost:8000 public/index.php
- php artisan queue:work —daemon

Swagger:
- It is located at /api/documentation
