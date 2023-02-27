<?php

namespace App\Pmo\DB\Traits;

use Illuminate\Support\Str;
use DB;
trait DataSampleSeederTrait
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function runProcess()
    {
        $db = DB::connection(SC_CONNECTION);

        $arrayIdNews = $this->arrayIdNews();

        $dataNews = $this->dataNews($arrayIdNews);
        $db->table(SC_DB_PREFIX.'shop_news')->insert($dataNews);

        $dataNewsDescription = $this->dataNewsDescription($arrayIdNews);
        $db->table(SC_DB_PREFIX.'shop_news_description')->insert($dataNewsDescription);

        $dataNewsStore = $this->dataNewsStore($arrayIdNews);
        $db->table(SC_DB_PREFIX.'shop_news_store')->insert($dataNewsStore);


        $arrayIdCategory = $this->arrayIdCategory();
        $dataCategory = $this->dataCategory($arrayIdCategory);
        $db->table(SC_DB_PREFIX.'shop_category')->insert($dataCategory);

        $dataCategoryStore = $this->dataCategoryStore($dataCategory);
        $db->table(SC_DB_PREFIX.'shop_category_store')->insert($dataCategoryStore);

        $dataCategoryDescription = $this->dataCategoryDescription($dataCategory);
        $db->table(SC_DB_PREFIX.'shop_category_description')->insert($dataCategoryDescription);

        $dataSupplier = $this->dataSupplier();
        $db->table(SC_DB_PREFIX.'shop_supplier')->insert($dataSupplier);

        $dataBrand = $this->dataBrand();
        $db->table(SC_DB_PREFIX.'shop_brand')->insert($dataBrand);

        $dataBrandStore = $this->dataBrandStore($dataBrand);
        $db->table(SC_DB_PREFIX.'shop_brand_store')->insert($dataBrandStore);

        $dataBanner = $this->dataBanner();
        $db->table(SC_DB_PREFIX.'shop_banner')->insert($dataBanner);

        $dataBannerStore = $this->dataBannerStore($dataBanner);
        $db->table(SC_DB_PREFIX.'shop_banner_store')->insert($dataBannerStore);


        $mappingIdProduct = $this->mappingIdProduct($arrayIdCategory);
        $arrayIdProduct = $mappingIdProduct['arrId'];

        $dataProduct = $this->dataProduct($dataBrand, $dataSupplier, $mappingIdProduct);
        $db->table(SC_DB_PREFIX.'shop_product')->insert($dataProduct);

        $dataProductStore = $this->dataProductStore($arrayIdProduct);
        $db->table(SC_DB_PREFIX.'shop_product_store')->insert($dataProductStore);

        $dataProductDescription = $this->dataProductDescription($dataProduct);
        $db->table(SC_DB_PREFIX.'shop_product_description')->insert($dataProductDescription);

        $db->table(SC_DB_PREFIX.'shop_product_build')->insert($mappingIdProduct['arrBuild']);
        $db->table(SC_DB_PREFIX.'shop_product_group')->insert($mappingIdProduct['arrGroup']);
        $db->table(SC_DB_PREFIX.'shop_product_promotion')->insert($mappingIdProduct['arrPromotion']);
        $db->table(SC_DB_PREFIX.'shop_product_image')->insert($mappingIdProduct['arrImage']);
        $db->table(SC_DB_PREFIX.'shop_product_category')->insert($mappingIdProduct['arrCategory']);
        $db->table(SC_DB_PREFIX.'shop_product_attribute')->insert($mappingIdProduct['arrAtt']);
    }

    public function arrayIdNews() {
        $ids = [];
        for ($i=1; $i <= 6; $i++) {
            $ids[$i] = (string)Str::orderedUuid();
        }
        return $ids;
    }

    public function dataNews($ids) {
        $dataNews = [];
        foreach ($ids as $key => $id) {
            $dataNews[] = [
                'id' => $id, 'alias' => 'demo-scart-blog-'.$key, 'image' => '/data/content/blog-'.$key.'.jpg', 'status' => 1, 'created_at' => date('Y-m-d H:i:s')
            ];
        }
        return $dataNews;
    }

    public function dataNewsDescription($ids) {
        $dataNewsDescription = [];
        foreach ($ids as $key => $id) {
            $dataNewsDescription[] = [
                'news_id' => $id, 'lang' => 'en', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua','title' => 'Easy Polo Black Edition '.$key, 'content' =>  '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 150px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'
            ];
            $dataNewsDescription[] = [
                'news_id' => $id, 'lang' => 'vi', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua','title' => 'Easy Polo Black Edition '.$key, 'content' =>  '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 150px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'
            ];
        }
        return $dataNewsDescription;
    }

    public function dataNewsStore($ids) {
        $dataNewsStore = [];
        foreach ($ids as $key => $id) {
            $dataNewsStore[] = [
                'news_id' => $id, 'store_id' => SC_ID_ROOT
            ];
        }
        return $dataNewsStore;
    }

    public function arrayIdCategory() {
        $ids = [];
        for ($i=1; $i <= 27; $i++) {
            $ids[$i] = (string)Str::orderedUuid();
        }
        return $ids;
    }

    public function dataCategory($arrayIdCategory) {
        $dataCategory = [];
        $dataCategory[] = ['id' => $arrayIdCategory[1], 'alias' => 'am-thuc', 'image' => '/data/category/laptop1.png', 'parent' => 0, 'top' => 1, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[2], 'alias' => 'du-lich', 'image' => '/data/category/headphone1.png', 'parent' => 0, 'top' => 1, 'sort' => 1, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[3], 'alias' => 'my-nghe', 'image' => '/data/category/phone1.png', 'parent' => 0, 'top' => 1, 'sort' => 2, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[4], 'alias' => 'van-hoa', 'image' => '/data/category/camera1.png', 'parent' => 0, 'top' => 1, 'sort' => 3, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[5], 'alias' => 'the-thao', 'image' => '/data/category/wifi1.png', 'parent' => 0, 'top' => 1, 'sort' => 4, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[6], 'alias' => 'cong-nghe', 'image' => '/data/category/iot1.png', 'parent' => 0, 'top' => 1, 'sort' => 5, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[7], 'alias' => 'ky-thuat', 'image' => '/data/category/usb1.png', 'parent' => 0, 'top' => 1, 'sort' => 6, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[8], 'alias' => 'dich-vu', 'image' => '/data/category/service1.png', 'parent' => 0, 'top' => 1, 'sort' => 7, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[9], 'alias' => 'banh-my-sai-gon', 'image' => '/data/category/speaker1.png', 'parent' => $arrayIdCategory[5], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[10], 'alias' => 'gom-bat-trang', 'image' => '/data/category/laptop6.png', 'parent' => $arrayIdCategory[4], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[11], 'alias' => 'dan-ca-quan-ho', 'image' => '/data/category/cpu1.png', 'parent' => $arrayIdCategory[6], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[12], 'alias' => 'don-ca-tai-tu', 'image' => '/data/category/cpu2.png', 'parent' => $arrayIdCategory[6], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[13], 'alias' => 'nem-chua', 'image' => '/data/category/blueetooth2.png', 'parent' => $arrayIdCategory[3], 'top' => 1, 'sort' => 7, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[14], 'alias' => 'toi-ly-son', 'image' => '/data/category/wifi2.png', 'parent' => $arrayIdCategory[5], 'top' => 1, 'sort' => 20, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[15], 'alias' => 'phong-nha-kebang', 'image' => '/data/category/headphone3.png', 'parent' => $arrayIdCategory[2], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[16], 'alias' => 'pho-nam-dinh', 'image' => '/data/category/laptop2.png', 'parent' => $arrayIdCategory[1], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[17], 'alias' => 'com-lang-vong', 'image' => '/data/category/laptop3.png', 'parent' => $arrayIdCategory[1], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[18], 'alias' => 'bun-cha-hanoi', 'image' => '/data/category/laptop4.png', 'parent' => $arrayIdCategory[1], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[19], 'alias' => 'com-tam-an-giang', 'image' => '/data/category/laptop5.png', 'parent' => $arrayIdCategory[6], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[20], 'alias' => 'vinh-ha-long', 'image' => '/data/category/headphone2.png', 'parent' => $arrayIdCategory[2], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[21], 'alias' => 'lua-ha-dong', 'image' => '/data/category/camera1.png', 'parent' => $arrayIdCategory[4], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[22], 'alias' => 'non-quai-thao', 'image' => '/data/category/camera2.png', 'parent' => $arrayIdCategory[4], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[23], 'alias' => 'tranh-dong-ho', 'image' => '/data/category/monitor2.png', 'parent' => $arrayIdCategory[3], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[24], 'alias' => 'trai-cay-nam-bo', 'image' => '/data/category/monitor1.png', 'parent' => $arrayIdCategory[3], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[25], 'alias' => 'chieu-coi-nga-son', 'image' => '/data/category/phone2.png', 'parent' => $arrayIdCategory[3], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[26], 'alias' => 'nhac-co-truyen', 'image' => '/data/category/server1.png', 'parent' => $arrayIdCategory[2], 'top' => 0, 'sort' => 0, 'status' => 1];
        $dataCategory[] = ['id' => $arrayIdCategory[27], 'alias' => 'con-dao', 'image' => '/data/category/print1.png', 'parent' => $arrayIdCategory[2], 'top' => 1, 'sort' => 10, 'status' => 1];
        return $dataCategory;
    }

    public function dataCategoryStore($dataCate) {
        $dataCategoryStore = [];
        foreach ($dataCate as  $cate) {
            $dataCategoryStore[] = [
                'category_id' => $cate['id'], 'store_id' => SC_ID_ROOT
            ];
        }
        return $dataCategoryStore;
    }

    public function dataCategoryDescription($dataCate) {
        $dataCategoryDescription = [];
        foreach ($dataCate as  $cate) {
            $dataCategoryDescription[] = [
                'category_id' => $cate['id'],'lang' => 'en','title' => Str::title(str_replace('-', ' ', $cate['alias']))
            ];
            $dataCategoryDescription[] = [
                'category_id' => $cate['id'],'lang' => 'vi','title' => Str::title(str_replace('-', ' ', $cate['alias']))
            ];
        }
        return $dataCategoryDescription;
    }

    public function dataSupplier() {
        $dataSupplier = [];
        $id1 = (string)Str::orderedUuid();
        $id2 = (string)Str::orderedUuid();
        $dataSupplier[$id1] = ['id' => $id1, 'alias' => 'supplier-abc', 'name' => 'Supplier ABC','email' => 'abc@gmail.com','phone' => '0123456789', 'image' => '/data/supplier/supplier.jpg', 'store_id' => SC_ID_ROOT];
        $dataSupplier[$id2] = ['id' => $id2, 'alias' => 'supplier-xyz', 'name' => 'Supplier XYZ','email' => 'xyz@gmail.com','phone' => '0987654321', 'image' => '/data/supplier/supplier.jpg', 'store_id' => SC_ID_ROOT];
        return $dataSupplier;
    }

    public function dataBrand() {
        $dataBrand = [];
        for ($i=1; $i <=10 ; $i++) { 
            ${'id'.$i} = (string)(string)Str::orderedUuid();
        }
        $dataBrand[$id1] = ['id' => $id1, 'alias' => 'danang', 'name' => 'DaNang','image' => '/data/brand/acer.png','status' =>1];
        $dataBrand[$id2] = ['id' => $id2, 'alias' => 'saigon', 'name' => 'SaiGon','image' => '/data/brand/assus.png','status' =>1];
        $dataBrand[$id3] = ['id' => $id3, 'alias' => 'hanoi', 'name' => 'HaNoi','image' => '/data/brand/casio.png','status' =>1];
        $dataBrand[$id4] = ['id' => $id4, 'alias' => 'bentre', 'name' => 'BenTre','image' => '/data/brand/dell.png','status' =>1];
        $dataBrand[$id5] = ['id' => $id5, 'alias' => 'nghean', 'name' => 'NgheAn','image' => '/data/brand/microsoft.png','status' =>1];
        $dataBrand[$id6] = ['id' => $id6, 'alias' => 'longan', 'name' => 'LongAn','image' => '/data/brand/nokia.png','status' =>1];
        $dataBrand[$id7] = ['id' => $id7, 'alias' => 'camau', 'name' => 'CaMau','image' => '/data/brand/panasonic.png','status' =>1];
        $dataBrand[$id8] = ['id' => $id8, 'alias' => 'hagiang', 'name' => 'HaGiang','image' => '/data/brand/sharp.png','status' =>1];
        $dataBrand[$id9] = ['id' => $id9, 'alias' => 'thanhhoa', 'name' => 'ThanhHoa','image' => '/data/brand/sony.png','status' =>1];
        $dataBrand[$id9] = ['id' => $id10, 'alias' => 'thanhhoa', 'name' => 'ThanhHoa','image' => '/data/brand/vaio.png','status' =>1];
        return $dataBrand;
    }

    public function dataBrandStore($dataBrand) {
        $dataBrandStore = [];
        foreach ($dataBrand as  $brand) {
            $dataBrandStore[] = [
                'brand_id' => $brand['id'], 'store_id' => SC_ID_ROOT
            ];
        }
        return $dataBrandStore;
    }

    public function dataBanner() {
        $dataBanner = [];
        $dataBanner[] = ['id' => (string)Str::orderedUuid(), 'title' => 'Banner home 1 (s-cart-light)','image' => '/data/banner/banner-home-1.jpg','status' => 1, 'html' => '<h1 class="swiper-title-1" data-caption-animate="fadeScale" data-caption-delay="100">Top-notch Furniture</h1><p class="biggest text-white-70" data-caption-animate="fadeScale" data-caption-delay="200">Sofa Store provides the best furniture and accessories for homes and offices.</p><div class="button-wrap" data-caption-animate="fadeInUp" data-caption-delay="300"> <span class="button button-zachem-tak-delat button-white button-zakaria"> Shop now</span> </div>', 'target' => '_self', 'type' => 'banner'];
        $dataBanner[] = ['id' => (string)Str::orderedUuid(), 'title' => 'Banner home 2 (s-cart-light)','image' => '/data/banner/banner-home-2.jpg','status' => 1, 'html' => '<h1 class="swiper-title-1" data-caption-animate="fadeScale" data-caption-delay="100">Top-notch Furniture</h1><p class="biggest text-white-70" data-caption-animate="fadeScale" data-caption-delay="200">Sofa Store provides the best furniture and accessories for homes and offices.</p><div class="button-wrap" data-caption-animate="fadeInUp" data-caption-delay="300"> <span class="button button-zachem-tak-delat button-white button-zakaria"> Shop now</span> </div>', 'target' => '_self', 'type' => 'banner'];
        $dataBanner[] = ['id' => (string)Str::orderedUuid(), 'title' => 'Banner breadcrumb (s-cart-light)','image' => '/data/banner/breadcrumb.jpg','status' => 1, 'html' => '', 'target' => '_self', 'type' => 'breadcrumb'];
        $dataBanner[] = ['id' => (string)Str::orderedUuid(), 'title' => 'Banner store (s-cart-light)','image' => '/data/banner/banner-store.jpg','status' => 1, 'html' => '', 'target' => '_self', 'type' => 'banner-store'];
        return $dataBanner;
    }

    public function dataBannerStore($dataBanner) {
        $dataBannerStore = [];
        foreach ($dataBanner as  $banner) {
            $dataBannerStore[] = [
                'banner_id' => $banner['id'], 'store_id' => SC_ID_ROOT
            ];
        }
        return $dataBannerStore;
    }

    public function mappingIdProduct($arrayIdCategory) {
        $arrId = [];
        $arrBuild = [];
        $arrBuildId = [];
        $arrGroup = [];
        $arrGroupId = [];
        $arrPromotion = [];
        $arrImage = [];
        $arrCategory = [];
        $arrAtt = [];
        for ($i=1; $i <= 36; $i++) {
            $arrId[$i] = (string)Str::orderedUuid();
        }
        $arrBuild[] = ['build_id' => $arrId['5'],'product_id' => $arrId['3'], 'quantity' => 1];
        $arrBuild[] = ['build_id' => $arrId['5'],'product_id' => $arrId['7'], 'quantity' => 2];
        $arrBuild[] = ['build_id' => $arrId['10'],'product_id' => $arrId['13'], 'quantity' => 1];
        $arrBuild[] = ['build_id' => $arrId['10'],'product_id' => $arrId['17'], 'quantity' => 2];
        $arrBuild[] = ['build_id' => $arrId['15'],'product_id' => $arrId['16'], 'quantity' => 1];
        $arrBuild[] = ['build_id' => $arrId['15'],'product_id' => $arrId['14'], 'quantity' => 2];
        $arrBuild[] = ['build_id' => $arrId['33'],'product_id' => $arrId['13'], 'quantity' => 2];
        $arrBuild[] = ['build_id' => $arrId['33'],'product_id' => $arrId['3'], 'quantity' => 2];

        $arrBuildId = [$arrId['5'],$arrId['10'],$arrId['15'],$arrId['33']];

        $arrGroup[] = ['group_id' => $arrId['4'],'product_id' => $arrId['2']];
        $arrGroup[] = ['group_id' => $arrId['4'],'product_id' => $arrId['6']];
        $arrGroup[] = ['group_id' => $arrId['14'],'product_id' => $arrId['2']];
        $arrGroup[] = ['group_id' => $arrId['14'],'product_id' => $arrId['12']];
        $arrGroup[] = ['group_id' => $arrId['19'],'product_id' => $arrId['11']];
        $arrGroup[] = ['group_id' => $arrId['19'],'product_id' => $arrId['21']];
        $arrGroup[] = ['group_id' => $arrId['34'],'product_id' => $arrId['3']];
        $arrGroup[] = ['group_id' => $arrId['34'],'product_id' => $arrId['7']];

        $arrGroupId = [$arrId['4'],$arrId['14'],$arrId['19'],$arrId['34']];

        $arrPromotion[] = ['product_id' => $arrId['1'], 'price_promotion' => 50];
        $arrPromotion[] = ['product_id' => $arrId['2'], 'price_promotion' => 30];
        $arrPromotion[] = ['product_id' => $arrId['6'], 'price_promotion' => 50];
        $arrPromotion[] = ['product_id' => $arrId['8'], 'price_promotion' => 40];
        $arrPromotion[] = ['product_id' => $arrId['12'], 'price_promotion' => 50];
        $arrPromotion[] = ['product_id' => $arrId['16'], 'price_promotion' => 30];
        $arrPromotion[] = ['product_id' => $arrId['18'], 'price_promotion' => 60];
        $arrPromotion[] = ['product_id' => $arrId['22'], 'price_promotion' => 50];
        $arrPromotion[] = ['product_id' => $arrId['26'], 'price_promotion' => 60];
        $arrPromotion[] = ['product_id' => $arrId['28'], 'price_promotion' => 50];
        $arrPromotion[] = ['product_id' => $arrId['30'], 'price_promotion' => 60];
        $arrPromotion[] = ['product_id' => $arrId['31'], 'price_promotion' => 50];
        $arrPromotion[] = ['product_id' => $arrId['35'], 'price_promotion' => 60];
        $arrPromotion[] = ['product_id' => $arrId['36'], 'price_promotion' => 50];

        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-2.png', 'product_id' => $arrId[1]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-11.png', 'product_id' => $arrId[1]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-8.png', 'product_id' => $arrId[11]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-6.png', 'product_id' => $arrId[2]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-13.png', 'product_id' => $arrId[11]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-12.png', 'product_id' => $arrId[5]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-17.png', 'product_id' => $arrId[5]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-11.png', 'product_id' => $arrId[2]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-5.png', 'product_id' => $arrId[2]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-12.png', 'product_id' => $arrId[9]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-15.png', 'product_id' => $arrId[8]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-19.png', 'product_id' => $arrId[7]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-12.png', 'product_id' => $arrId[7]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-1.png', 'product_id' => $arrId[5]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-12.png', 'product_id' => $arrId[4]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-7.png', 'product_id' => $arrId[15]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-12.png', 'product_id' => $arrId[15]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-16.png', 'product_id' => $arrId[17]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-6.png', 'product_id' => $arrId[17]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-12.png', 'product_id' => $arrId[17]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-18.png', 'product_id' => $arrId[22]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-19.png', 'product_id' => $arrId[22]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-24.png', 'product_id' => $arrId[24]];
        $arrImage[] = ['id' => (string)Str::orderedUuid(), 'image' => '/data/product/product-22.png', 'product_id' => $arrId[24]];

        $arrCategory[] = ['product_id' => $arrId[1], 'category_id' => $arrayIdCategory[13]];
        $arrCategory[] = ['product_id' => $arrId[2], 'category_id' => $arrayIdCategory[13]];
        $arrCategory[] = ['product_id' => $arrId[1], 'category_id' => $arrayIdCategory[10]];
        $arrCategory[] = ['product_id' => $arrId[1], 'category_id' => $arrayIdCategory[6]];
        $arrCategory[] = ['product_id' => $arrId[3], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[4], 'category_id' => $arrayIdCategory[17]];
        $arrCategory[] = ['product_id' => $arrId[5], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[6], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[7], 'category_id' => $arrayIdCategory[12]];
        $arrCategory[] = ['product_id' => $arrId[8], 'category_id' => $arrayIdCategory[10]];
        $arrCategory[] = ['product_id' => $arrId[9], 'category_id' => $arrayIdCategory[6]];
        $arrCategory[] = ['product_id' => $arrId[10], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[11], 'category_id' => $arrayIdCategory[10]];
        $arrCategory[] = ['product_id' => $arrId[12], 'category_id' => $arrayIdCategory[9]];
        $arrCategory[] = ['product_id' => $arrId[13], 'category_id' => $arrayIdCategory[5]];
        $arrCategory[] = ['product_id' => $arrId[14], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[15], 'category_id' => $arrayIdCategory[6]];
        $arrCategory[] = ['product_id' => $arrId[16], 'category_id' => $arrayIdCategory[5]];
        $arrCategory[] = ['product_id' => $arrId[17], 'category_id' => $arrayIdCategory[9]];
        $arrCategory[] = ['product_id' => $arrId[18], 'category_id' => $arrayIdCategory[19]];
        $arrCategory[] = ['product_id' => $arrId[19], 'category_id' => $arrayIdCategory[6]];
        $arrCategory[] = ['product_id' => $arrId[20], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[21], 'category_id' => $arrayIdCategory[10]];
        $arrCategory[] = ['product_id' => $arrId[22], 'category_id' => $arrayIdCategory[21]];
        $arrCategory[] = ['product_id' => $arrId[23], 'category_id' => $arrayIdCategory[12]];
        $arrCategory[] = ['product_id' => $arrId[24], 'category_id' => $arrayIdCategory[9]];
        $arrCategory[] = ['product_id' => $arrId[25], 'category_id' => $arrayIdCategory[27]];
        $arrCategory[] = ['product_id' => $arrId[26], 'category_id' => $arrayIdCategory[16]];
        $arrCategory[] = ['product_id' => $arrId[27], 'category_id' => $arrayIdCategory[15]];
        $arrCategory[] = ['product_id' => $arrId[28], 'category_id' => $arrayIdCategory[15]];
        $arrCategory[] = ['product_id' => $arrId[29], 'category_id' => $arrayIdCategory[13]];
        $arrCategory[] = ['product_id' => $arrId[30], 'category_id' => $arrayIdCategory[16]];
        $arrCategory[] = ['product_id' => $arrId[31], 'category_id' => $arrayIdCategory[11]];
        $arrCategory[] = ['product_id' => $arrId[32], 'category_id' => $arrayIdCategory[16]];
        $arrCategory[] = ['product_id' => $arrId[33], 'category_id' => $arrayIdCategory[20]];
        $arrCategory[] = ['product_id' => $arrId[34], 'category_id' => $arrayIdCategory[19]];
        $arrCategory[] = ['product_id' => $arrId[35], 'category_id' => $arrayIdCategory[16]];
        $arrCategory[] = ['product_id' => $arrId[36], 'category_id' => $arrayIdCategory[16]];


        $arrAtt[] = ['name' => 'Blue', 'attribute_group_id' => 1, 'product_id' => $arrId[36], 'add_price' => 5];
        $arrAtt[] = ['name' => 'White', 'attribute_group_id' => 1, 'product_id' => $arrId[36], 'add_price' => 0];
        $arrAtt[] = ['name' => 'S', 'attribute_group_id' => 2, 'product_id' => $arrId[36], 'add_price' => 2];
        $arrAtt[] = ['name' => 'XL', 'attribute_group_id' => 2, 'product_id' => $arrId[36], 'add_price' => 3];
        $arrAtt[] = ['name' => 'Blue', 'attribute_group_id' => 1, 'product_id' => $arrId[12], 'add_price' => 10];
        $arrAtt[] = ['name' => 'Red', 'attribute_group_id' => 1, 'product_id' => $arrId[12], 'add_price' => 0];
        $arrAtt[] = ['name' => 'S', 'attribute_group_id' => 2, 'product_id' => $arrId[12], 'add_price' => 0];
        $arrAtt[] = ['name' => 'M', 'attribute_group_id' => 2, 'product_id' => $arrId[12], 'add_price' => 0];

        $data['arrId'] = $arrId;
        $data['arrBuild'] = $arrBuild;
        $data['arrBuildId'] = $arrBuildId;
        $data['arrGroup'] = $arrGroup;
        $data['arrGroupId'] = $arrGroupId;
        $data['arrPromotion'] = $arrPromotion;
        $data['arrImage'] = $arrImage;
        $data['arrCategory'] = $arrCategory;
        $data['arrAtt'] = $arrAtt;
        return $data;
    }

    public function dataProduct($dataBrand, $dataSupplier, $mappingIdProduct) {
        $arrId = $mappingIdProduct['arrId'];
        $dataProduct = [];
        $arrPrice = [60,80,100];
        $arrSku = ['PHO-BO-NAM-DNH', 'NEM-NUONG-THANH-HOA', 'BANH-GAI-TU-TRU','BUN-HUE-GIA-TRUYEN','BANH-TRANG-TRON','MUOI-TAY-NINH','NHAN-LONG-HUNG-YEN','SAU-RIENG-DAK-LAK','BIA-LON-SAIGON','BIA-TUOI-HANOI','NUOC-MAM-PHAN-THIET','BANH-MY-CHA-CA','HU-TIEU-NAM-VANG',
        'CANH-CHUA-CA-LOC','CHOM-CHOM-NHAN','CAM-VINH-LOAI-I','KEO-DUA-BEN-TRE','NON-LA-VIETNAM','AO-DAI-VIETNAM','XOAI-CAT-HOA-LOC','COM-NIU-SAI-GON','COM-TAM-AN-GIANG','VAI-THIEU-LUC-NGAN','NEM-CHUA-THANH-HOA','CHA-CA-NHA-TRANG','CHA-CA-THAC-LAC','HOA-DAO-NHAT-TAN','CAY-TO-BAY-MON','MY-CAY-7-CAP-DO',
        'COM-CHIEN-HAI-SAN','CHAO-LONG-TIET-CANH','THIT-TRAU-GAC-BEP','CU-DO-HA-TINH','BANH-DAU-XANH-HUNG-YEN','CAM-SANH-MONG-NUOC','THANH-LONG-RUOT-DO'];
        for ($i=1; $i <= 36; $i++) {
            $kind = SC_PRODUCT_SINGLE;
            if (in_array($arrId[$i], $mappingIdProduct['arrGroupId'])) {
                $kind = SC_PRODUCT_GROUP; 
            }
            if (in_array($arrId[$i], $mappingIdProduct['arrBuildId'])) {
                $kind = SC_PRODUCT_BUILD; 
            }
            $dataProduct[$arrId[$i]] = [
                'id' => $arrId[$i],'sku' => $arrSku[($i-1)],'alias' => strtolower($arrSku[($i-1)]),'image' => '/data/product/product-'.$i.'.png','price' => $arrPrice[array_rand($arrPrice)],'stock' => 100, 'status' => 1,'tax_id' => 'auto','kind' => $kind,
                'brand_id'=> array_rand($dataBrand), 'supplier_id' => array_rand($dataSupplier)
            ];
        }
        return $dataProduct;
    }

    public function dataProductStore($arrayIdProduct) {
        $dataProductStore = [];
        foreach ($arrayIdProduct as  $id) {
            $dataProductStore[] = [
                'product_id' => $id, 'store_id' => SC_ID_ROOT
            ];
        }
        return $dataProductStore;
    }

    public function dataProductDescription($dataProduct) {
        $dataProductDescription = [];
        $des = "- 27-inch (diagonal) Retina 5K display
        - 3.1GHz 6-core 10th-generation Intel Core i5
        - AMD Radeon Pro 5300 graphics";
        foreach ($dataProduct as $product) {
            $dataProductDescription[] = [
                'product_id' => $product['id'], 'lang' => 'en', 'description' => $des, 'name' => Str::title(str_replace('-', ' ', $product['alias'])), 'content' =>  '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 150px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'
            ];
            $dataProductDescription[] = [
                'product_id' => $product['id'], 'lang' => 'vi', 'description' => $des, 'name' => Str::title(str_replace('-', ' ', $product['alias'])), 'content' =>  '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt="" src="/data/product/product-10.png" style="width: 150px; float: right; margin: 10px;" /></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'
            ];
        }
        return $dataProductDescription;
    }
}
