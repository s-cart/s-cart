<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'shop_product')->insert(
            [
                ['id' => 1, 'sku' => 'ABCZZ','alias' => 'demo-alias-name-product-1', 'image' => '/data/product/product-1.png', 'brand_id' => '1', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '99',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '1', 'minimum' => '0', 'store_id' => 1],
                ['id' => 2, 'sku' => 'LEDFAN1','alias' => 'demo-alias-name-product-2', 'image' => '/data/product/product-2.png', 'brand_id' => '1', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 3, 'sku' => 'CLOCKFAN1','alias' => 'demo-alias-name-product-3', 'image' => '/data/product/product-3.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 4, 'sku' => 'CLOCKFAN2','alias' => 'demo-alias-name-product-4', 'image' => '/data/product/product-4.png', 'brand_id' => '3', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '10', 'store_id' => 1],
                ['id' => 5, 'sku' => 'CLOCKFAN3','alias' => 'demo-alias-name-product-5', 'image' => '/data/product/product-5.png', 'brand_id' => '1', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 6, 'sku' => 'TMC2208','alias' => 'demo-alias-name-product-6', 'image' => '/data/product/product-6.png', 'brand_id' => '1', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 7, 'sku' => 'FILAMENT','alias' => 'demo-alias-name-product-7', 'image' => '/data/product/product-7.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 8, 'sku' => 'A4988','alias' => 'demo-alias-name-product-8', 'image' => '/data/product/product-8.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 9, 'sku' => 'ANYCUBIC-P','alias' => 'demo-alias-name-product-9', 'image' => '/data/product/product-9.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 10, 'sku' => '3DHLFD-P','alias' => 'demo-alias-name-product-10', 'image' => '/data/product/product-10.png', 'brand_id' => '4', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 11, 'sku' => 'SS495A','alias' => 'demo-alias-name-product-11', 'image' => '/data/product/product-11.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 12, 'sku' => '3D-CARBON175','alias' => 'demo-alias-name-product-12', 'image' => '/data/product/product-12.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '5', 'store_id' => 1],
                ['id' => 13, 'sku' => '3D-GOLD175','alias' => 'demo-alias-name-product-13', 'image' => '/data/product/product-13.png', 'brand_id' => '3', 'supplier_id' => '1', 'price' => '10000', 'cost' => '5000', 'stock' => '0',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 14, 'sku' => 'LCD12864-3D','alias' => 'demo-alias-name-product-14', 'image' => '/data/product/product-14.png', 'brand_id' => '3', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 15, 'sku' => 'LCD2004-3D','alias' => 'demo-alias-name-product-15', 'image' => '/data/product/product-15.png', 'brand_id' => '3', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 1, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '10', 'store_id' => 1],
                ['id' => 16, 'sku' => 'RAMPS15-3D','alias' => 'demo-alias-name-product-16', 'image' => '/data/product/product-16.png', 'brand_id' => '2', 'supplier_id' => '1', 'price' => '0', 'cost' => '0', 'stock' => '0',  'status' => '1', 'kind' => 2, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '0', 'store_id' => 1],
                ['id' => 17, 'sku' => 'ALOKK1-AY','alias' => 'demo-alias-name-product-17', 'image' => '/data/product/product-10.png', 'brand_id' => '3', 'supplier_id' => '1', 'price' => '15000', 'cost' => '10000', 'stock' => '100',  'status' => '1', 'kind' => 0, 'tax_id' => 'auto', 'date_available' => null, 'sold' => '0', 'minimum' => '5', 'store_id' => 1],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX.'shop_product_description')->insert(
            [
                ['product_id' => '1', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 1', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '2', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 2', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '3', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 3', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '4', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 4', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '5', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 5', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '6', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 6', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '7', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 7', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '8', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 8', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '9', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 9', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '10', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 10', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '11', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 11', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '12', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 12', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '13', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 13', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '14', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 14', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '15', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 15', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '16', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 16', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '17', 'lang' => 'en', 'name' => 'Easy Polo Black Edition 17', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '1', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 1', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '2', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 2', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '3', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 3', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '4', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 4', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '5', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 5', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '6', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 6', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '7', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 7', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '8', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 8', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '9', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 9', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '10', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 10', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '11', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 11', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '12', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 12', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '13', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 13', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '14', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 14', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '15', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 15', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '16', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 16', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
                ['product_id' => '17', 'lang' => 'vi', 'name' => 'Easy Polo Black Edition 17', 'keyword' => '', 'description' => '', 'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 262px; height: 262px; float: right; margin: 10px;" /></p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_category')->insert(
            [
                ['product_id' => '1', 'category_id' => '13'],
                ['product_id' => '2', 'category_id' => '13'],
                ['product_id' => '1', 'category_id' => '10'],
                ['product_id' => '1', 'category_id' => '6'],
                ['product_id' => '3', 'category_id' => '11'],
                ['product_id' => '4', 'category_id' => '11'],
                ['product_id' => '5', 'category_id' => '11'],
                ['product_id' => '6', 'category_id' => '11'],
                ['product_id' => '7', 'category_id' => '12'],
                ['product_id' => '8', 'category_id' => '10'],
                ['product_id' => '9', 'category_id' => '6'],
                ['product_id' => '10', 'category_id' => '11'],
                ['product_id' => '11', 'category_id' => '10'],
                ['product_id' => '12', 'category_id' => '9'],
                ['product_id' => '13', 'category_id' => '5'],
                ['product_id' => '14', 'category_id' => '11'],
                ['product_id' => '15', 'category_id' => '6'],
                ['product_id' => '16', 'category_id' => '9'],
                ['product_id' => '17', 'category_id' => '9'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_image')->insert(
            [
                ['image' => '/data/product/product-2.png', 'product_id' => '1'],
                ['image' => '/data/product/product-11.png', 'product_id' => '1'],
                ['image' => '/data/product/product-8.png', 'product_id' => '11'],
                ['image' => '/data/product/product-6.png', 'product_id' => '2'],
                ['image' => '/data/product/product-13.png', 'product_id' => '11'],
                ['image' => '/data/product/product-12.png', 'product_id' => '5'],
                ['image' => '/data/product/product-6.png', 'product_id' => '5'],
                ['image' => '/data/product/product-1.png', 'product_id' => '2'],
                ['image' => '/data/product/product-15.png', 'product_id' => '2'],
                ['image' => '/data/product/product-5.png', 'product_id' => '9'],
                ['image' => '/data/product/product-8.png', 'product_id' => '8'],
                ['image' => '/data/product/product-2.png', 'product_id' => '7'],
                ['image' => '/data/product/product-6.png', 'product_id' => '7'],
                ['image' => '/data/product/product-11.png', 'product_id' => '5'],
                ['image' => '/data/product/product-13.png', 'product_id' => '4'],
                ['image' => '/data/product/product-13.png', 'product_id' => '15'],
                ['image' => '/data/product/product-6.png', 'product_id' => '15'],
                ['image' => '/data/product/product-12.png', 'product_id' => '17'],
                ['image' => '/data/product/product-6.png', 'product_id' => '17'],
                ['image' => '/data/product/product-2.png', 'product_id' => '17'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_attribute')->insert(
            [
                ['name' => 'Blue', 'attribute_group_id' => '1', 'product_id' => '17', 'sort' => '0', 'add_price' => '50'],
                ['name' => 'White', 'attribute_group_id' => '1', 'product_id' => '17', 'sort' => '0', 'add_price' => '0'],
                ['name' => 'S', 'attribute_group_id' => '2', 'product_id' => '17', 'sort' => '0', 'add_price' => '20'],
                ['name' => 'XL', 'attribute_group_id' => '2', 'product_id' => '17', 'sort' => '0', 'add_price' => '30'],
                ['name' => 'Blue', 'attribute_group_id' => '1', 'product_id' => '10', 'sort' => '0', 'add_price' => '150'],
                ['name' => 'Red', 'attribute_group_id' => '1', 'product_id' => '10', 'sort' => '0', 'add_price' => '0'],
                ['name' => 'S', 'attribute_group_id' => '2', 'product_id' => '10', 'sort' => '0', 'add_price' => '0'],
                ['name' => 'M', 'attribute_group_id' => '2', 'product_id' => '10', 'sort' => '0', 'add_price' => '0'],
            ]
        );


        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_property')->insert(
            [
                ['id' => '1', 'code' => 'physical', 'name' => 'Product physical'],
                ['id' => '2', 'code' => 'download', 'name' => 'Product download']
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_build')->insert(
            [
                ['build_id' => '15', 'product_id' => '6', 'quantity' => '1'],
                ['build_id' => '15', 'product_id' => '7', 'quantity' => '2'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_group')->insert(
            [
                ['group_id' => '16', 'product_id' => '1'],
                ['group_id' => '16', 'product_id' => '2'],
            ]
        );

        DB::connection(SC_CONNECTION)->table(SC_DB_PREFIX . 'shop_product_promotion')->insert(
            [
                ['product_id' => '1', 'price_promotion' => '5000'],
                ['product_id' => '2', 'price_promotion' => '3000'],
                ['product_id' => '13', 'price_promotion' => '4000'],
                ['product_id' => '11', 'price_promotion' => '600'],
            ]
        );

    }
}
