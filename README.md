# cms

## Features

* Lightweight
* Minimal footprint (just one additional table in database)
* Manage users
* Profile page
* Manage pages ("sections") hierarchy (view as table or as nested list)
* Public and protected pages (and attached files)
* Publication can be planned for future
* Many articles per page
* Many uploads per article
* Localizable (english and russian translations icluded)
* Uses standard Laravel authentication
* Ready to use WYSIWYG CKEditor
* Cache pages
* Image thumbnails (also cached)

## Developer info

* Uses two database tables: `users` extended from standard Laravel authentication and `sections` for pages, articles, files.
* `Cms` facade and `cms()` helper function.
* Repository to read sections `SectionRepository`.
* Policies for managing users and sections (`UserPolicy`, `SectionPolicy`).
* Middleware: `CheckUserRole` and `CachePages`.
* Thumbnails generated and cached with `intervention/image`.
* Views marked up with `bootstrap` classes.

## Install

In short: configure database then run:
```
$ php artisan make:auth
$ composer require vvvkor/cms
$ php artisan migrate
$ php artisan make:cms
```

### Configure database (if you have not alredy)

Set parameters in `.env` or `config/database.php` files of your project.

### Enable authorization (if you have not alredy)

``` bash
$ php artisan make:auth
``` 

### Require CMS package

``` bash
$ composer require vvvkor/cms
``` 

### Add service provider (if auto-discovery is disabled)

In `config/app.php` add to `providers` section
```
vvvkor\cms\cmsServiceProvider::class,
```
and to `aliases` section
```
'Cms' => vvvkor\cms\Facades\Cms::class,
```

### Migrate tables with default data

```
$ php artisan migrate
```

### Add CMS routes

To add routes to `routes/web.php` run

```
$ php artisan make:cms
```

or add manually to `routes/web.php`

```
Cms::routes();
```

### Publish views, translations, config (optional)

Copy stuff to your app if you want to modify it.  
Views are marked with Bootstrap classes.

```
$ php artisan vendor:publish --provider=vvvkor\cms\CmsServiceProvider
```

### Use WYSIWYG CKEditor (optional)

You can use CKEditor for visual formatting of texts.
```
$ composer require unisharp/laravel-ckeditor
```

In `config/app.php` add to `providers` section
```
Unisharp\Ckeditor\ServiceProvider::class,
```
Publish assets
```
$ php artisan vendor:publish --tag=ckeditor
```

## Usage

* Using browser go to home page of your project.
* Log in as administrator with e-mail `admin@domain.com` and password `admin`.
* Or as privileged reader with e-mail `reader@domain.com` and password `reader`.
* Go to home page again.
* For administrator, on top of page there are links to manage `Sections` and `Users`.
* For reader, there is a link to a protected page in top menu.