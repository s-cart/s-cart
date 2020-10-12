<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Total/Discount');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Total/Discount');

    \Illuminate\Support\Facades\Validator::extend('discount_unique', function ($attribute, $value, $parameters, $validator) {
        $disountId = $parameters[0] ?? '';
        return (new \App\Plugins\Total\Discount\Admin\Models\AdminDiscount)
        ->checkDiscountValidationAdmin('code', $value, $disountId, session('adminStoreId'));
    });