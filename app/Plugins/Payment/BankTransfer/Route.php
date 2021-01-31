<?php
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX.'/bank_transfer',
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Payment\BankTransfer\Admin',
    ], 
    function () {
        Route::get('/', 'AdminController@index')
            ->name('admin_bank_transfer.index');
    }
);
