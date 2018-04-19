# cms

## Install

### Configure database

`.env` or `config/database.php`

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
in `config/app.php` add to `providers` section
```
vvvkor\cms\cmsServiceProvider::class,
```
and to `aliases` section
```
'Cms' => vvvkor\cms\Facades\Cms::class,
```

### Add CMS routes

To add routes to `routes/web.php`

```
$ php artisan make:auth
```

or add manually to `routes/web.php`

```
Cms::routes();
```

### Publish views, translations, config (optional)

Copy to your app if you want to modify files

```
$ php artisan vendor:publish --provider=vvvkor\cms\CmsServiceProvider
```

### Use WYSIWYG CKEditor (optional)

You can use CKEditor for visual formatting of texts
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

1. Using browser go to home page of your project.
2. Login with e-mail `admin@domain.com` and password `admin`.
3. Go to home page again.
4. In top menu bar there are links `Sections` and `Users`.
5. Use these links to manage sections and users.