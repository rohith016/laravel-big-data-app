installation

composer create-project --prefer-dist laravel/laravel app-name

composer install/update

composer require laravel/breeze

php artisan breeze:install

npm install

[

create mysql database

mysql
show databases;
create database laravel_big_data;
create user 'laravel_big_user'@'localhost' identified by 'Big_Laravel@12345';
grant all privileges on laravel_big_data.* to 'laravel_big_user'@'localhost';
flush privileges;
]

php artisan queue:table
php artisan migrate
php artisan serve
npm run dev

php artisan make:model Sale -cm
php artisan make:request UploadSalesRequest
php artisan migrate
php artisan make:class Services/SaleService
php artisan make:job SalesCsvProcess
php artisan make:view sales/create
php artisan make:view sales/index

add code to controller, model, migration, request, route, job, views


php artisan queue:work



bulk email send

php artisan make:controller EmailController --resource
php artisan make:request uploadEmailFileRequest
php artisan make:class Services/EmailService
php artisan make:job SendEmailJob
php artisan make:mail SendUserMail
php artisan make:view emails/index
php artisan make:view emails/create
php artisan make:email emails/mail-template
php artisan make:view emails/mail-template
