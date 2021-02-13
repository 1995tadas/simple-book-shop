# Book shop

You have old dusty books laying on your table? Or reading doesn't excite you anymore?
Say no more... this website is all you ever needed.
Sell your book on this fabulous website... it's completely FREE.
If you want to deploy this masterpiece on your machine you can find instruction bellow!

## Technologies used


- Php 8.0.1
- Laravel 8.26.1
- VueJs 2.6.12
- MySql 8.0.22
- TailwindCss
- Composer 2.0.9 for php packages
- NodeJs 6.14.11 for npm packages

## How to deploy

1. Copy all files from this repo
1. Make sure you have right technologies installed
1. Copy .env.example and rename it to .env (if you using unix operating system just run this command in app root `mv .env.example .env`)
1. Run `composer install` and `npm install`(needed dependencies will be installed)
1. Compile all VueJs and other files by `npm run dev ` or `npm run watch` for development,`npm run prod` for production
1. Then run `php artisan key:generate` and replace database credentials inside .env file
1. Migrate tables by running `php artisan migrate`
