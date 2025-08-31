<p align="center">
    <a href="https://s-cart.org"><img src="https://s-cart.org/logo.png" height="100"><a/>
    <a href="https://gp247.net"><img src="https://static.gp247.net/logo/logo.png" height="100"></a>
</p>
<p align="center">Free open source e-commerce for business<br>
</p>
<p align="center">
 <a href="https://s-cart.org">Home</a> | <a href="https://demo.s-cart.org">Demo</a> | <a href="https://gp247.net/en/docs/s-cart/s-cart-overview.html">About new S-Cart</a> | <a href="https://www.facebook.com/groups/scart.opensource">Group FB</a>
</p>

<p align="center">
<a href="https://packagist.org/packages/s-cart/s-cart"><img src="https://poser.pugx.org/s-cart/s-cart/d/total" alt="Packagist Downloads"></a>
<a href="https://github.com/s-cart/s-cart"><img src="https://img.shields.io/github/downloads/s-cart/s-cart/total" alt="Git Downloads"></a>
<a href="https://github.com/s-cart/s-cart/releases"><img src="https://poser.pugx.org/s-cart/s-cart/v/stable" alt="Latest Stable Version"></a>
<a href="https://github.com/s-cart/s-cart/blob/master/LICENSE"><img src="https://poser.pugx.org/s-cart/s-cart/license" alt="License"></a>
</p>



`From September 2025, s-cart will be moved to a new location::`

**New repo:** <a href="https://github.com/gp247net/s-cart">https://github.com/gp247net/s-cart</a>

**New package:** <a href="https://github.com/gp247net/s-cart">https://packagist.org/packages/gp247/s-cart</a>

**Installation:**

~~**composer create-project s-cart/s-cart**~~

>**composer create-project gp247/s-cart**


## About S-Cart X
S-Cart is the best free e-commerce website project for individuals and businesses, built on top of Laravel Framework and the latest technologies.
Our goal is "Efficient and friendly for everyone":
- Efficiency: Meet even the smallest requirements of customers.
- Friendly: Easy to use, easy to maintain, easy to develop.
- Everyone: Businesses, individuals, developers, students.

## IMAGES:
<img src="https://static.s-cart.org/guide/use/common/shop.jpg">
<img src="https://static.s-cart.org/guide/use/common/dashboard.jpg">

## S-Cart functions:

###  S-Cart - FREE Laravel ecommerce for business 

#### Core Features
- Build plugin packages HMVC
- Support to upgrade and patch S-Cart via command line
- Full documentation for developers and clients

####  Professional Sales Website Functions
- **Multi-language, multi-currency**
- **Multi-vendor**
- Complete e-commerce features:
  - Shopping cart management
  - Order management
  - Product management
  - Customer management
- **CMS Management**:
  - Categories
  - News
  - Content pages
- **Extensions**:
  - Payment plugins
  - Shipping methods
  - Discount systems
  - Tax calculation
- **Pro Plugins for S-Cart**:
  - Multi-vendor: https://gp247.net/en/docs/s-cart/multi-vendor.html
  - Multi-store: https://gp247.net/en/docs/s-cart/multi-store.html
- **Developer Resources**:
  - Online library of plugins and templates
  - API support with security for apps and mobile integration

####  Powerful Admin Features
- **User Management**:
  - Role-based permissions (admin, manager, marketing, etc.)
  - Comprehensive security with full logging
  - Access control, authentication, and CAPTCHA
- **Business Tools**:
  - Product management
  - Order processing
  - Customer relationship management
  - Analytics and statistics
  - Data backup and restoration
  - Activity monitoring


## S-Cart 10.x:


> Powered by GP247 system <a href="https://github.com/gp247net">https://github.com/gp247net</a>

> Core Laravel framework 12.x <a href="https://github.com/laravel/laravel">https://github.com/laravel/laravel</a>


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

### Method 1: Installation via Composer (Recommended)

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

- **Step 4**: Install sample data (optional)

  If you want to install sample data, run the command:
  >`php artisan sc:sample`

### Method 2: Installation via Git Clone

- **Step 1**: Clone repository from GitHub

  >`git clone https://github.com/s-cart/s-cart.git`

- **Step 2**: Move to project directory

  >`cd s-cart`

- **Step 3**: Create .env file from sample file

  >`cp .env.example .env`

- **Step 4**: Generate APP_KEY

  >`php artisan key:generate`

- **Step 5**: Install dependencies via Composer

  >`composer install`

- **Step 6**: Configure database in .env file

  Edit database connection information in .env file:
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database_name
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```

- **Step 7**: Initialize S-Cart

  >`php artisan sc:install`

- **Step 8**: Install sample data (optional)

  >`php artisan sc:sample`

### Important Note on Directory Permissions

Make sure the following directories have write permissions:
- `app/GP247`
- `public/GP247`
- `public/vendor`
- `resources/views/vendor`
- `storage`
- `vendor`

Without proper write permissions, installation and various features will not work correctly.

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


**Customize lfm configuration for upload**

>`php artisan vendor:publish --tag=config-lfm`

**Customize core admin view**

>`php artisan vendor:publish --tag=gp247:view-core`

**Overwrite gp247_* helper functions**

>Step 1: Add the list of functions you want to override to `config/gp247_functions_except.php`

>Step 2: Create new php files containing the new functions in the `app/GP247/Helpers` directory, for example `app/GP247/Helpers/myfunction.php`

**Overwrite gp247 controller files**

>Step 1: Copy the controller files you want to override from vendor/gp247/core/src/Core/Controllers -> app/GP247/Core/Controllers

>Step 2: Change `namespace GP247\Core\Controllers` to `namespace App\GP247\Core\Controllers`

**Overwrite gp247 API controller files**

>Step 1: Copy the controller files you want to override from vendor/gp247/core/src/Api/Controllers -> app/GP247/Core/Api/Controllers

>Step 2: Change `namespace GP247\Core\Api\Controllers` to `namespace App\GP247\Core\Api\Controllers`

## Add route

Use prefix and middleware constants `GP247_ADMIN_PREFIX`, `GP247_ADMIN_MIDDLEWARE` in route declaration.

References: https://github.com/gp247net/core/blob/master/src/routes.php


## Environment variables in .env file

**Disable APIs**
> `GP247_API_MODE=1` // To disable, set value 0

**Data table prefixes**
> `GP247_DB_PREFIX=gp247_` //Cannot change after install gp247

**Path prefix to admin**
> `GP247_ADMIN_PREFIX=gp247_admin`
