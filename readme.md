<p align="center">
    <a href="https://s-cart.org"><img src="https://s-cart.org/logo.png" height="100"><a/>
    <a href="https://gp247.net"><img src="https://static.gp247.net/logo/logo.png" height="100"></a>
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

## About S-Cart X
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
Demo API: <a href="https://s-cart.org/en/docs/master/about-api-scart.html">https://s-cart.org/en/docs/master/about-api-scart.html</a>
👉Plugin pro:
- Multi-vendor: <a href="https://s-cart.org/en/multi-vendor.html">https://s-cart.org/en/multi-vendor.html</a>
- Multi-store: <a href="https://s-cart.org/en/multi-store.html">https://s-cart.org/en/multi-store.html</a>
</pre>

## Technology
- Core <a href="https://laravel.com">Laravel Framework</a>

## Laravel core:

S-Cart 10.x

> Power by GP247 system

> Core laravel framework 12.x 


## Website structure using GP247

    Website-folder/
    |
    ├── app
    │     └── GP247
    │           ├── Core(+) //Customize controller of Core
    │           ├── Helpers(+) //Auto load Helpers/*.php
    │           ├── Plugins(+) //Use `php artisan gp247:make-plugin --name=NameOfPlugin`
    │           ├── Front(+) //Customize controller of Front 
    │           ├── Shop(+) //Customize controller of Shop 
    │           └── Templates(+) //Use `php artisan gp247:make-template --name=NameOfTempate`
    ├── public
    │     └── GP247
    │           ├── Core(+)
    │           ├── Plugins(+)
    │           └── Templates(+)
    ├── resources
    │            └── views/vendor
    │                           |── gp247-core(+) //Customize view core
    │                           └── gp247-front(+) //Customize view front
    ├── vendor
    │     ├── gp247/core
    │     ├── gp247/front
    │     └── gp247/shop
    └──...

## Support the project
Support this project :stuck_out_tongue_winking_eye: :pray:
<p align="center">
    <a href="https://www.paypal.me/LeLanh" target="_blank"><img src="https://img.shields.io/badge/Donate-PayPal-green.svg" data-origin="https://img.shields.io/badge/Donate-PayPal-green.svg" alt="PayPal Me"></a>
</p>

## Quick Installation Guide
- **Step 1**: 

  Refer to the command: 
  >`composer create-project s-cart/s-cart`

- **Step 2**: Check the configuration in the .env file

  Ensure that the database configuration and APP_KEY information in the .env file are complete.

  If the APP_KEY is not set, use the following command to generate it: 
  >`php artisan key:generate`

- **Step 3**: Initialize S-Cart

  Run the command: 
  >`php artisan sc:install`


## Useful information:

**To view S-Cart version**

>`php artisan sc:info`

**Update S-Cart**

Update the package using the command: 

>`composer update gp247/core`

>`composer update gp247/front`

>`composer update gp247/shop`

Then, run the command: 

>`php artisan sc:update`

**To create a plugin:**

>`php artisan gp247:make-plugin  --name=PluginName`

To create a zip file plugin

>`php artisan gp247:make-plugin  --name=PluginName --download=1`

**To create a template:**

>`php artisan gp247:make-template  --name=TemplateName`

To create a zip file template:

>`php artisan gp247:make-template  --name=TemplateName --download=1`

## Customize

**Customize gp247-config and functions**

>`php artisan gp247:customize config`

**Customize view admin**

>`php artisan gp247:customize view`

**Overwrite gp247_* helper functions**

>Step 1: Use the command `php artisan gp247:customize config` to copy the file `app/config/gp247_functions_except.php`

>Step 2: Add the list of functions you want to override to `gp247_functions_except.php`

>Step 3: Create a new function in the `app/GP247/Helpers folder`

**Overwrite gp247 controller files**

>Step 1: Copy the controller files you want to override in vendor/gp247/core/src/Core/Controllers -> app/GP247/Core/Admin/Controllers

>Step 2: Change `namespace GP247\Core\Admin\Controllers` to `namespace App\GP247\Core\Admin\Controllers`

**Overwrite gp247 API controller files**

>Step 1: Copy the controller files you want to override in vendor vendor/gp247/core/src/Api/Controllers ->  app/GP247/Core/Api/Controllers

>Step 2: Change `namespace GP247\Core\Api\Controllers` to `namespace App\GP247\Core\Api\Controllers`

## Add route

Use prefix and middleware constants `GP247_ADMIN_PREFIX`, `GP247_ADMIN_MIDDLEWARE` in route declaration.

References: https://github.com/gp247net/core/blob/master/src/Admin/routes.php


## Environment variables in .env file

**Quickly disable GP247 and plugins**
> `GP247_ACTIVE=1` // To disable, set value 0

**Disable APIs**
> `GP247_API_MODE=1` // To disable, set value 0

**Data table prefixes**
> `GP247_DB_PREFIX=gp247_` //Cannot change after install gp247

**Path prefix to admin**
> `GP247_ADMIN_PREFIX=gp247_admin`
