# Book shop

You have old dusty book laying on your table? Or reading doesn't excite you anymore?
Say no more... this website is all you ever needed.
Sell your books on this fabulous website... it's completely FREE.
If you want to deploy this masterpiece on your machine you can find instruction bellow!


# Demo
https://tadassapitavicius.com/book-shop/

## Technologies used


- Php 8.0.1
- Laravel 8.26.1
- VueJs 2.6.12
- MySql 8.0.22
- TailwindCss 2.0.3
- Composer 2.0.9 for php packages
- NodeJs 6.14.11 for npm packages

## How to deploy

1. Copy all files from this repo
1. Make sure you have right technologies installed
1. Copy .env.example and rename it to .env (if you using unix operating system just run this command in app root `mv .env.example .env`)
1. Run `composer install` and `npm install`(needed dependencies will be installed)
1. Run `php artisan storage:link` to create link to storage files
1. Compile all VueJs and other files by `npm run dev ` or `npm run watch` for development,`npm run prod` for production
1. Then run `php artisan key:generate` and replace database and email credentials inside .env file
1. Migrate tables by running `php artisan migrate`

## Api endpoints

## 1. Getting all the books
```
'https://tadassapitavicius.com'~ | /book-shop/api/v1/books
```
#### __MUST__ be GET request

#### Possible output
```json
[
    "data": [
        {
            "id": 75,
            "title": "Non",
            "cover": "https://tadassapitavicius.com/book-shop/storage/covers/7912b0cce0bdf418683188bb52a7fb32.png",
            "price": 1574.84,
            "authors": "Ms. Jennyfer Waelchi V",
            "genres": "Corporis"
        },
        {
            "id": 60,
            "title": "Sint",
            "cover": "https://tadassapitavicius.com/book-shop/storage/covers/66053dd0c5bb4190bbc3be90184b06a2.png",
            "price": 1177.26,
            "authors": "Courtney Hilpert",
            "genres": "Non, Veniam"
        }
    ],
    "links": {
        "first": "https://tadassapitavicius.com/book-shop/api/v1/books?page=1",
        "last": "https://tadassapitavicius.com/book-shop/api/v1/books?page=2",
        "prev": null,
        "next": "https://tadassapitavicius.com/book-shop/api/v1/books?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
        "links": [
    {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
    },
    {
        "url": "https://tadassapitavicius.com/book-shop/api/v1/books?page=1",
        "label": 1,
        "active": true
    },
    {
        "url": "https://tadassapitavicius.com/book-shop/api/v1/books?page=2",
        "label": 2,
        "active": false
    },
    {
        "url": "https://tadassapitavicius.com/book-shop/api/v1/books?page=2",
        "label": "Next &raquo;",
        "active": false
    }
    ],
        "path": "https://tadassapitavicius.com/book-shop/api/v1/books",
        "per_page": 25,
        "to": 25,
        "total": 38
    }
]
```

## 2. Getting specific book
```
'https://tadassapitavicius.com'~ | /book-shop/api/v1/books/{id}
```
#### __MUST__ be GET request

#### Possible output
```json
 "data": {
    "id": 75,
    "title": "Non",
    "cover": "https://tadassapitavicius.com/book-shop/storage/covers/7912b0cce0bdf418683188bb52a7fb32.png",
    "price": 1574.84,
    "description": "Ut saepe at praesentium ea magni esse aut. Est magni sit dolor dignissimos blanditiis ipsum. Qui sunt qui corrupti quos voluptatum perferendis.",
    "authors": "Ms. Jennyfer Waelchi V",
    "genres": "Corporis"
}
```
