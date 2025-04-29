<p align="center">
    <a href="https://s-cart.org"><img src="https://s-cart.org/logo.png" height="100"><a/>
    <a href="https://gp247.net"><img src="https://static.gp247.net/logo/logo.png" height="100"></a>
</p>
<p align="center">Mã nguồn mở miễn phí cho website thương mại điện tử<br>
    <code><b>composer create-project s-cart/s-cart</b></code></p>
<p align="center">
 <a href="https://s-cart.org">Trang chủ</a> | <a href="https://demo.s-cart.org">Demo</a> | <a href="https://s-cart.org/en/docs/master">Tài liệu</a>  |  <a href="https://s-cart.org/en/docs/master/about-api-scart.html">Tài liệu API</a> | <a href="https://s-cart.org/en/about.html">Tính năng của S-Cart</a> | <a href="https://www.facebook.com/groups/scart.opensource">Nhóm FB</a>
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

## Giới thiệu về S-Cart X
S-Cart là dự án website thương mại điện tử miễn phí tốt nhất dành cho cá nhân và doanh nghiệp, được xây dựng trên nền tảng Laravel Framework và các công nghệ mới nhất.
Mục tiêu của chúng tôi là "Hiệu quả và thân thiện cho tất cả mọi người":
- Hiệu quả: Đáp ứng ngay cả những yêu cầu nhỏ nhất của khách hàng.
- Thân thiện: Dễ sử dụng, dễ bảo trì, dễ phát triển.
- Tất cả mọi người: Doanh nghiệp, cá nhân, lập trình viên, sinh viên.

## HÌNH ẢNH:
<img src="https://static.s-cart.org/guide/info/s-cart-content.jpg">
<img src="https://static.s-cart.org/guide/use/common/shop.jpg">
<img src="https://static.s-cart.org/guide/use/common/dashboard.jpg">

## Các chức năng của S-Cart:

### 💥 S-Cart - Thương mại điện tử Laravel MIỄN PHÍ cho doanh nghiệp 💥

#### Tính năng cốt lõi
- Xây dựng gói plugin theo mô hình HMVC
- Hỗ trợ nâng cấp và vá lỗi S-Cart qua dòng lệnh
- Tài liệu đầy đủ cho nhà phát triển và khách hàng

#### 👉 Chức năng của website bán hàng chuyên nghiệp
- **Đa ngôn ngữ, đa tiền tệ**
- **Đa nhà cung cấp**
- Đầy đủ tính năng thương mại điện tử:
  - Quản lý giỏ hàng
  - Quản lý đơn hàng
  - Quản lý sản phẩm
  - Quản lý khách hàng
- **Quản lý nội dung CMS**:
  - Danh mục
  - Tin tức
  - Trang nội dung
- **Tiện ích mở rộng**:
  - Plugin thanh toán
  - Phương thức vận chuyển
  - Hệ thống giảm giá
  - Tính thuế
- **Plugin chuyên nghiệp**:
  - Đa nhà cung cấp: <a href="https://s-cart.org/en/multi-vendor.html">https://s-cart.org/en/multi-vendor.html</a>
  - Đa cửa hàng: <a href="https://s-cart.org/en/multi-store.html">https://s-cart.org/en/multi-store.html</a>
- **Tài nguyên cho nhà phát triển**:
  - Thư viện trực tuyến: plugin và template
  - Hỗ trợ API với bảo mật cho ứng dụng và tích hợp di động

#### 👉 Tính năng quản trị mạnh mẽ
- **Quản lý người dùng**:
  - Phân quyền dựa trên vai trò (quản trị viên, quản lý, marketing, v.v.)
  - Bảo mật toàn diện với ghi nhật ký đầy đủ
  - Kiểm soát truy cập, xác thực, và CAPTCHA
- **Công cụ kinh doanh**:
  - Quản lý sản phẩm
  - Xử lý đơn hàng
  - Quản lý khách hàng
  - Phân tích và thống kê
  - Sao lưu và khôi phục dữ liệu
  - Theo dõi hoạt động

#### Tài liệu API
- Demo API: <a href="https://s-cart.org/en/docs/master/about-api-scart.html">https://s-cart.org/en/docs/master/about-api-scart.html</a>

## S-Cart 10.x:


> Được hỗ trợ bởi hệ thống GP247 <a href="https://github.com/gp247net">https://github.com/gp247net</a>

> Core Laravel framework 12.x <a href="https://github.com/laravel/laravel">https://github.com/laravel/laravel</a>


## Cấu trúc website sử dụng GP247

    Website-folder/
    |
    ├── app
    │     └── GP247
    │           ├── Core(+) //Tùy chỉnh controller của Core
    │           ├── Helpers(+) //Tự động tải Helpers/*.php
    │           ├── Plugins(+) //Sử dụng `php artisan gp247:make-plugin --name=NameOfPlugin`
    │           ├── Front(+) //Tùy chỉnh controller của Front 
    │           ├── Shop(+) //Tùy chỉnh controller của Shop 
    │           └── Templates(+) //Sử dụng `php artisan gp247:make-template --name=NameOfTempate`
    ├── public
    │     └── GP247
    │           ├── Core(+)
    │           ├── Plugins(+)
    │           └── Templates(+)
    ├── resources
    │            └── views/vendor
    │                           |── gp247-core(+) //Tùy chỉnh view core
    │                           └── gp247-front(+) //Tùy chỉnh view front
    ├── vendor
    │     ├── gp247/core
    │     ├── gp247/front
    │     └── gp247/shop
    └──...

## Hỗ trợ dự án
Hỗ trợ dự án này :stuck_out_tongue_winking_eye: :pray:
<p align="center">
    <a href="https://www.paypal.me/LeLanh" target="_blank"><img src="https://img.shields.io/badge/Donate-PayPal-green.svg" data-origin="https://img.shields.io/badge/Donate-PayPal-green.svg" alt="PayPal Me"></a>
</p>

## Hướng dẫn cài đặt nhanh
- **Bước 1**: 

  Tham khảo lệnh: 
  >`composer create-project s-cart/s-cart`

- **Bước 2**: Kiểm tra cấu hình trong tệp .env

  Đảm bảo rằng cấu hình cơ sở dữ liệu và thông tin APP_KEY trong tệp .env đã hoàn chỉnh.

  Nếu APP_KEY chưa được thiết lập, sử dụng lệnh sau để tạo: 
  >`php artisan key:generate`

- **Bước 3**: Khởi tạo S-Cart

  Chạy lệnh: 
  >`php artisan sc:install`

- **Bước 4**: Cài đặt dữ liệu mẫu (tùy chọn)

  Nếu bạn muốn cài đặt dữ liệu mẫu, chạy lệnh:
  >`php artisan sc:sample`

### Lưu ý quan trọng về quyền thư mục

Đảm bảo các thư mục sau có quyền ghi:
- `app/GP247`
- `public/GP247`
- `public/vendor`
- `resources/views/vendor`
- `storage`
- `vendor`

Nếu không có quyền ghi đúng, việc cài đặt và các tính năng khác nhau sẽ không hoạt động chính xác.

## Thông tin hữu ích:

**Xem phiên bản S-Cart**

>`php artisan sc:info`

**Cập nhật S-Cart**

Cập nhật gói bằng lệnh: 

>`composer update gp247/core`

>`composer update gp247/front`

>`composer update gp247/shop`

Sau đó, chạy lệnh: 

>`php artisan sc:update`

**Tạo plugin:**

>`php artisan gp247:make-plugin  --name=PluginName`

Tạo tệp zip plugin

>`php artisan gp247:make-plugin  --name=PluginName --download=1`

**Tạo template:**

>`php artisan gp247:make-template  --name=TemplateName`

Tạo tệp zip template:

>`php artisan gp247:make-template  --name=TemplateName --download=1`

## Tùy chỉnh


**Tùy chỉnh cấu hình lfm cho tải lên**

>`php artisan vendor:publish --tag=config-lfm`

**Tùy chỉnh giao diện quản trị core**

>`php artisan vendor:publish --tag=gp247:view-core`

**Ghi đè các hàm helper gp247_***

>Bước 1: Thêm danh sách các hàm bạn muốn ghi đè vào `config/gp247_functions_except.php`

>Bước 2: Tạo các tệp php mới chứa các hàm mới trong thư mục `app/GP247/Helpers`, ví dụ `app/GP247/Helpers/myfunction.php`

**Ghi đè các tệp controller gp247**

>Bước 1: Sao chép các tệp controller bạn muốn ghi đè từ vendor/gp247/core/src/Core/Controllers -> app/GP247/Core/Controllers

>Bước 2: Thay đổi `namespace GP247\Core\Controllers` thành `namespace App\GP247\Core\Controllers`

**Ghi đè các tệp controller API gp247**

>Bước 1: Sao chép các tệp controller bạn muốn ghi đè từ vendor/gp247/core/src/Api/Controllers -> app/GP247/Core/Api/Controllers

>Bước 2: Thay đổi `namespace GP247\Core\Api\Controllers` thành `namespace App\GP247\Core\Api\Controllers`

## Thêm route

Sử dụng các hằng số prefix và middleware `GP247_ADMIN_PREFIX`, `GP247_ADMIN_MIDDLEWARE` trong khai báo route.

Tham khảo: https://github.com/gp247net/core/blob/master/src/routes.php


## Biến môi trường trong tệp .env

**Tắt API**
> `GP247_API_MODE=1` // Để tắt, đặt giá trị 0

**Tiền tố bảng dữ liệu**
> `GP247_DB_PREFIX=gp247_` //Không thể thay đổi sau khi cài đặt gp247

**Tiền tố đường dẫn đến trang quản trị**
> `GP247_ADMIN_PREFIX=gp247_admin` 