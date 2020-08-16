<p align="center">
    <img src="https://s-cart.org/logo.png?v=4" width="150">
</p>
<p align="center">Free Laravel e-commerce for business<br>
    <code><b>composer create-project s-cart/s-cart</b></code></p>
<p align="center">
 <a href="https://s-cart.org">Home page</a> | <a href="https://demo.s-cart.org">Demo</a> | <a href="https://demo.s-cart.org/sc_admin">Demo admin</a> | <a href="https://s-cart.org/docs/master/installation.html">Installation</a>  | <a href="https://s-cart.org/docs/master/video-guide.html">Video Guide</a> | <a href="https://s-cart.org/download.html">Download full source</a>
</p>
<p align="center">
<a href="https://packagist.org/packages/s-cart/s-cart"><img src="https://poser.pugx.org/s-cart/s-cart/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/s-cart/s-cart"><img src="https://poser.pugx.org/s-cart/s-cart/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/s-cart/s-cart"><img src="https://poser.pugx.org/s-cart/s-cart/license.svg" alt="License"></a>
</p>

## About S-cart
SCart e-commerce: Free open source for businesses, built on the Laravel framework.
Our highest goals are aimed at general users:
- Customers do not need to know much about technology.
- Powerful system, many useful functions.
- Easy to access, easy to use.

## Support the project
Support this project :stuck_out_tongue_winking_eye: :pray:
<p align="center">
    <a href="https://www.paypal.me/LeLanh" target="_blank"><img src="https://img.shields.io/badge/Donate-PayPal-green.svg" data-origin="https://img.shields.io/badge/Donate-PayPal-green.svg" alt="PayPal Me"></a>
</p>

## IMAGES:
<img src="https://s-cart.org/data/30/shop-list.jpg?v=1">
<img src="https://s-cart.org/data/30/admin-dashboard.jpg?v=1">

## SCart functions:

<pre>
======= FRONT-END =======
- Multi-store, multi-domain (from V3)
- Multi-language
- Multi-currency
- Multi-address
- Shopping cart
- Customer login
- Product attributes: cost price, promotion price, stock, tax..
- CMS content: category, news, content, web page
- Plugin: Shipping, payment, Discount, Total...
- Upload manager: banner, images,..
- SEO support: custome URL
- API module
- Support library plugin, template online
...

======= ADMIN =======

- Admin roles, permission
- Product manager
- Order management
- Customer management
- Template manager
- Plugin manager
- Store manager
- System config: email setting, info shop, maintain status,...
- Backup, restore data
- Report: chart, statistics, export csv, pdf...
...

</pre>

## Technology
- Core <a href="https://laravel.com">Laravel Framework</a>

## Requirements:

Version 3.0

> Core laravel framework 7.x Requirements::

```
- PHP >= 7.2.5
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

<b>How to map your domain to s-cart? <a href="https://s-cart.org/docs/master/installation.html">CLICK HERE</a></b>

**Step1: Install last version S-cart**

Option 1: **From composer**
```
composer create-project s-cart/s-cart
```

Option 2: **From github**
```
git clone https://github.com/s-cart/s-cart.git
```
Then, install vendor:
```
composer install
```
Option 3: **Download full source (included vendors)**
```
https://s-cart.org/download.html
```

**Step2: Set writable permissions for the following directories:**

- <code>storage</code>
- <code>vendor</code>
- <code>public/data</code>
- <code>bootstrap/cache</code>


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
- 1: Import file database/*.sql to database.
- 2: Rename or delete file public/install.php
- 3: Copy file .env.example to .env if file .env not exist.
- 4: Generate API key if APP_KEY is null. 
  Use command "php artisan key:generate"
- 5: Generates the encryption keys
  Use command "php artisan passport:keys"
- 6: Config value of file .env:
APP_DEBUG=false (Set "false" is security)
DB_HOST=127.0.0.1 (Database host)
DB_PORT=3306 (Database port)
DB_DATABASE=s-cart (Database name)
DB_USERNAME=root (User name use database)
DB_PASSWORD= (Password connect to database)
APP_URL=http://localhost (Your url)
ADMIN_PREFIX=sc_admin (Path to admin)
DB_PREFIX=sc_ (Must be "sc_" because it is fixed in the .sql file)
```

**Step5: Install completed**

- Access to url admin: <b>your-domain/sc_admin</b>.
- User/pass <code><b>admin</b>/<b>admin</b></code>


## License:

`SCart` is licensed under [The MIT License (MIT)](LICENSE).

## Demo:

- Font-end : http://demo.s-cart.org
- Back-end: http://demo.s-cart.org/sc_admin   <code>User/pass: test/123456</code>

## 

VPS SSD $5/mo, gets $100 in credit over 60 days. [DigitalOcean](https://m.do.co/c/84e350ce07c4).