# cms

## Install

In your project

### Configure database

``.env`` or ``config/database.php``

### Enable authorization

``` bash
$ php artisan make:auth
``` 

### Require CMS package

``` bash
$ composer require vvvkor/cms
``` 

### Add service provider

If auto-discovery is disabled then 
``config/app.php`` 'providers'
vvvkor\cms\cmsServiceProvider::class,

'aliases'
'Cms' => vvvkor\cms\Facades\Cms::class,

### Add CMS routes

To add routes to ``routes/web.php``

```
php artisan make:auth
```

or add manually to ``routes/web.php``

```
Cms::routes();
```

### Publish views, translations, config (optional)

Copy to your app to modify files

```
php artisan vendor:publish --provider=vvvkor\cms\CmsServiceProvider
```

### Use WYSIWYG CKEditor (optional)

```
composer require unisharp/laravel-ckeditor
```

``config/app.php`` 'providers'
Unisharp\Ckeditor\ServiceProvider::class,

```
php artisan vendor:publish --tag=ckeditor
```

## Usage

Using browser go to home page of your project.
Login with e-mail ``admin@domain.com`` and password ``admin``.
Go to home page again.
In top menu bar there are links ``Sections`` and ``Users``.
Use these links to manage sections and users.