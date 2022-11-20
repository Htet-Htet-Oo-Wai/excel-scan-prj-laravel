## Version

### Use LEMP Environment ###

- PHP
  PHP 7.4.30
- Laravel
  8.75

### Enviroment Setting ###
- **Clone link**
```
git clone https://github.com/Htet-Htet-Oo-Wai/excel-scan-prj-laravel.git
```

- **Copy env file**
```
rename .env.example to .env
```

- **Project Setup**
```
1. install composer
```
composer install
```
2. generate app key
```
php artisan key:generate
```
3. create table
```
php artisan migrate
```
4. cache clear
```
php artisan optimize
```
5. server setup
```
php artisan serve
```


- Access in Browser
  - [http://localhost:8000]
