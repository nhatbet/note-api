### Language
- php 8.1 
- laravel 10
- mysql:5.7.22
- nginx:stable-alpine
- composer:latest

### Cần set up ext-grpc cho php-8.1 (Extension gRPC là cần thiết để làm việc với Firestore thông qua gRPC, giúp tối ưu hóa tốc độ và hiệu suất khi giao tiếp với Google Cloud) (tham khảo: https://cloud.google.com/php/grpc)
`sudo apt-get update`
`sudo apt-get install -y php-dev php-pear pkg-config libz-dev`
`sudo pecl install grpc`
`sudo apt-get install php8.1-grpc` <!-- extension=grpc.so --> cài extension, hoặc sửa file php.ini

### Setup
Install docker and docker-compose on your PC
Access the project root directory. Execute cmd:
`cp .env.example .env` and config **.env**
`cp docker-compose.dev.yml docker-compose.yml` and config **docker-compose.yml**
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
