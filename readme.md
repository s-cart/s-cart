<p align="center">
    <img src="https://s-cart.org/logo.png?v=4" width="150">
</p>
<p align="center">Free open source e-commerce for business<br>
    <code><b>composer create-project s-cart/s-cart</b></code></p>
<p align="center">
 <a href="https://s-cart.org">Home</a> | <a href="https://demo.s-cart.org">Demo</a> | <a href="https://s-cart.org/en/docs/master">Document</a>  |  <a href="https://s-cart.org/en/docs/master/about-api-scart.html">API document</a> | <a href="https://s-cart.org/en/about.html">Features in S-Cart</a> | <a href="https://www.facebook.com/groups/scart.opensource">Group FB</a>
</p>

<p align="center">
<a href="https://packagist.org/packages/s-cart/s-cart"><img src="https://poser.pugx.org/s-cart/s-cart/d/total" alt="Packagist Downloads"></a>
<a href="https://github.com/s-cart/s-cart"><img src="https://img.shields.io/github/downloads/s-cart/s-cart/total" alt="Git Downloads"></a>
<a href="https://github.com/s-cart/s-cart/releases"><img src="https://poser.pugx.org/s-cart/s-cart/v/stable" alt="Latest Stable Version"></a>
<a href="https://github.com/s-cart/s-cart/blob/master/LICENSE"><img src="https://poser.pugx.org/s-cart/s-cart/license" alt="License"></a>
</p>

<p align="center">
    <a href="https://www.youtube.com/channel/UCR8kitefby3N6KvvawQVqdg"><img src="https://img.shields.io/youtube/channel/subscribers/UCR8kitefby3N6KvvawQVqdg?style=social"></a>
</p>

## About S-cart
S-Cart is the best free e-commerce website project for individuals and businesses, built on top of Laravel Framework and the latest technologies.
Our goal is "Efficient and friendly for everyone":
- Efficiency: Meet even the smallest requirements of customers.
- Friendly: Easy to use, easy to maintain, easy to develop.
- Everyone: Businesses, individuals, developers, students.

## IMAGES:
<img src="https://static.s-cart.org/guide/info/s-cart-content.jpg">
<img src="https://static.s-cart.org/guide/use/common/shop.jpg">
<img src="https://static.s-cart.org/guide/use/common/dashboard.jpg">

## S-Cart functions:

<pre>
💥S-Cart - FREE Laravel ecommerce for business💥:
- Build plugin packages HMVC
- Support to upgrade and patch S-Cart via command line
- Full document for dev and client
👉Full support for the functions of a professional sales website:
- Multi-language, multi-currency
- Multi-vendor
- Make cart, manage orders, manage products, manage customers...
- CMS news management: categories, news, news pages
- Plugin: Payment, shipping, discounts, taxes ...
- Plugin pro: multi-vendor, multi-store
- Online library: plugin, template
- API suppport and security for app, mobile
👉Powerful admin page:
- Roles, permission: admin, manager, maketing, ..
- Security with log full, access, auth, captcha ...
- Manage products, orders, customers ...
- Charts, statistics
- Backup, restore
- Activity log
- And many other functions.
Demo API: <a href="https://s-cart.org/en/developer/master/about-api-scart.html">https://s-cart.org/en/developer/master/about-api-scart.html</a>
👉Plugin pro:
- Multi-vendor: <a href="https://s-cart.org/en/multi-vendor.html">https://s-cart.org/en/multi-vendor.html</a>
- Multi-store: <a href="https://s-cart.org/en/multi-store.html">https://s-cart.org/en/multi-store.html</a>
</pre>

## Technology
- Core <a href="https://laravel.com">Laravel Framework</a>

## Laravel core:

S-Cart 6.x

> Core laravel framework 8.x 

S-Cart 7.x

> Core laravel framework 9.x 

S-Cart 8.x

> Core laravel framework 10.x 

## Requirements:

```
- PHP ^7.3|^8.0 (S-Cart 6.x)
- PHP ^8.0.2 (S-Cart 7.x)
- PHP ^8.1 (S-Cart 8.x)
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
```

## Installation & configuration:

<b>How to map your domain to s-cart? <a href="https://s-cart.org/en/docs/master/installation.html">CLICK HERE</a></b>

**Step1: Install last version S-cart**

Option 1: **From composer**

>composer create-project s-cart/s-cart


Option 2: **From github**

>git clone https://github.com/s-cart/s-cart.git

Then, install vendor:

>composer install


**Step2: Set writable permissions for the following directories:**

- <code>storage</code>
- <code>vendor</code>
- <code>public/data</code>
- <code>bootstrap/cache</code>
- <code>app/Plugins</code>


**Step3: Create database**
```
- Create a new database. Example database name is "s-cart"
```

**Step4: Install**

Option 1: **Install automatic**
```
Access your-domain.com/install.php to install S-cart.
```
Then, remove or rename file *public/install.php*

Option 2: **Manual installation**

If installing with link "install.php" unsuccessful, you can install it manually below.
```
1: Create new database, then import file /vendor/s-cart/core/src/DB/s-cart-yyyy-mm-dd.sql to database.
2: Rename or delete file public/install.php
3: Copy file .env.example to .env if file .env not exist.
4: Generate API key if APP_KEY is null. 
- Use command "php artisan key:generate"
5: Generates the encryption keys
  Use command "php artisan passport:keys"
6: Config value of file .env:
- APP_DEBUG=false (Set "false" is security)
- DB_HOST=127.0.0.1 (Database host)
- DB_PORT=3306 (Database port)
- DB_DATABASE=s-cart (Database name)
- DB_USERNAME=root (User name use database)
- DB_PASSWORD= (Password connect to database)
- APP_URL=http://localhost (Your url)
- ADMIN_PREFIX=sc_admin (Path to admin)
- DB_PREFIX=sc_ (Must be "sc_" because it is fixed in the .sql file)
```

**Step5: Install completed**

- Access to url admin: <b>your-domain/sc_admin</b>.
- User/pass <code><b>admin</b>/<b>admin</b></code>

More detail for installation: <a href="https://s-cart.org/en/docs/master/installation.html">HERE</a>

## Useful information:

To view S-Cart version information

>`php artisan sc:info`

To update the core version of S-Cart:

>`composer update s-cart/core`

Or you can use `php composer.phar update s-cart/core` if you don't have composer installed.

Then, run `php artisan sc:update`

To create a plugin:

>`php artisan sc:make plugin  --name=Group\PluginName`

To create a zip file plugin:

>`php artisan sc:make plugin  --name=Group\PluginName --download=1`

Detail: <a href="https://s-cart.org/en/docs/master/how-to-install-module-extension.html">HERE</a>

Library of free plugins for S-Cart: <a href="https://s-cart.org/en/plugin.html">HERE</a>

To create a template:

>`php artisan sc:make template  --name=your-template-name`

To create a zip file template:

>`php artisan sc:make template  --name=your-template-name --download=1`

To create data backup file (The sql file is stored in storage/backups):

>`php artisan sc:backup --path=abc.sql`

To recover data:

>`php artisan sc:restore --path=abc.sql`

To manually customize the admin page (<code>resources/views/admin + config/admin.php</code>):

>`php artisan sc:customize admin`

This command will create new directories `resources/views/admin` and file `config/admin.php`
After set the value `customize=true` in `config/admin.php` you can modify template admin. 

To manually customize file config validation (<code>config/validation.php</code>):

>`php artisan sc:customize validation`

More detail: https://s-cart.org/en/docs/master

## Funding and supporting the project

Please visit the <a href="https://s-cart.org/en/license.html" target="_blank">S-Cart</a>

## Security Vulnerabilities:

If you discover a security vulnerability within S-Cart ecommerce, please send an e-mail to Lanh Le via lanhktc@gmail.com. All security vulnerabilities will be promptly addressed.

## License:

`S-Cart` is licensed under [The MIT License (MIT)](LICENSE).

## Demo:

- Font-end : http://demo.s-cart.org
- Back-end: http://demo.s-cart.org/sc_admin   <code>User/pass: test/123456</code>

## Plugins pro:

- Multi vendor : https://s-cart.org/en/multi-vendor.html
- Multi store : https://s-cart.org/en/multi-store.html
