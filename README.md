## Upepo

Admin Panel for Laravel 8.*

## Installation

Install the package through [Composer](http://getcomposer.org/). 

    composer require "simbamahaba/upepo"

1) Publish vendors files _php artisan vendor:publish_

2) Before installing the migrations, delete the shopping cart migration already published, since Upepo has its own migration for it.

3) Run the _php artisan migrate_.

4) To the _App\Http\Kernel.php_, add the following to the application's route middleware:
```
'not.for.admin' => \App\Http\Middleware\RedirectIfAdmin::class,
'admin.only' => \App\Http\Middleware\RedirectIfNotAdmin::class,
'customer' => \App\Http\Middleware\RedirectIfCustomer::class,
'customer.email.verified' => \App\Http\Middleware\EnsureCustomerEmailIsVerified::class,
'loggedcustomer' => \App\Http\Middleware\RedirectIfNotCustomer::class,
'verifiedcustomer' => \App\Http\Middleware\NotVerifiedCustomer::class,
```