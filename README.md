# robert-php-dev-test
PHP Architect Test for Robert

# Installation
Create database (denyudin_robert_cat) and tables with command:
```sh
mysql -u {mysql_username} -p < /home/schema.sql
```
Setup DB config hare --api/translations.php:5:
```php
const DB_HOST = 'localhost:3306';
const DB_NAME = 'denyudin_robert_cat';
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root';
```
Run php webserver with command:
```sh
php -S localhost:8000
```
Ready to use!