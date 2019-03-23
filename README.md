# laravel-api
RESTful api using laravel framework 

### Usage

### Installation

- enter your db connection cerdentitials 

- run
``` sh
$ php artisan migrate
```

- Install dependencies using: 
``` sh
$ composer install
```
API Endpints
``` sh
$ GET /api/categories
$ POST /api/categories
$ PUT /api/categories/{id} 
$ DELETE /api/categories/{id} 

$ GET /api/articles
$ POST /api/articles
$ PUT /api/articles/{id} 
$ DELETE /api/articles/{id} 

articles post example
{
"data" : 
	{
	"title" : "dd",
	"text" : "dd",
	"date" : "2018-10-05",
	"category_id" : 1
	}
	
}
```
