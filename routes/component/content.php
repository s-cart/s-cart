<?php
$prefixSearch = sc_config('PREFIX_SEARCH')??'search';
$prefixContact = sc_config('PREFIX_CONTACT')??'contact';
$prefixNews = sc_config('PREFIX_NEWS')??'news';

Route::get('/'.$prefixSearch.$suffix, 'ShopFront@search')
->name('search');
Route::post('/subscribe', 'ShopFront@emailSubscribe')
->name('subscribe');
Route::get('/'.$prefixContact.$suffix, 'ShopFront@getContact')
->name('contact');
Route::post('/contact', 'ShopFront@postContact')
->name('contact.post');
Route::get('/'.$prefixNews, 'ShopFront@news')
->name('news');
Route::get('/'.$prefixNews.'/{alias}'.$suffix, 'ShopFront@newsDetail')
->name('news.detail');
