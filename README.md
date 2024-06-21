### Language
- php 8.1 
- laravel 10
- mysql:5.7.22
- nginx:stable-alpine
- composer:latest

### Setup
Install docker and docker-compose on your PC
Access the project root directory. Execute cmd:
- ##### 1. Linux, macos
    - `make install`
- ##### 2. Window
    - `docker-compose up -d`
    - `docker-compose run --rm composer composer install`
    - `docker-compose run --rm php php artisan migrate`
    - `docker-compose run --rm php php artisan db:seed`
> 📝 Refer to file **makefile**

### Relationship Design
- [Entity Relations Diagram](https://drive.google.com/file/d/1OdaRFwW5zPkwtuGHJAC_4O3d9IDvn9ZR/view?usp=sharing)
