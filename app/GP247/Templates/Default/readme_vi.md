# Tạo Template mới

Để tạo một template mới, sử dụng lệnh artisan sau:

```bash
php artisan gp247:make-template --name=YourTemplateName --download=0
```

Trong đó:
- `YourTemplateName`: Tên template của bạn
- `--download=0`: Tạo template trực tiếp trong thư mục app/GP247/Templates
- `--download=1`: Tạo file zip template trong thư mục storage/tmp

# Cấu trúc Template GP247

Đây là format chuẩn cho việc phát triển template trong hệ thống GP247.

## Cấu trúc thư mục

```
template/
├── blocks/         # Các khối giao diện (partials) dùng trong template
├── Lang/           # Các file ngôn ngữ
├── Plugins/        # Phần mở rộng đi kèm template (tùy chọn)
├── public/         # Tài nguyên public (css, js, images). Khi cài đặt sẽ được copy tới public/GP247/Templates/{template}
├── AppConfig.php   # Cấu hình chính của template
├── config.php      # Cấu hình hiển thị/tuỳ chọn của template
├── function.php    # Các hàm helper dùng trong template
├── gp247.json      # Khai báo thông tin template
├── Provider.php    # Service provider của template
└── Route.php       # Khai báo routes của template
```

## Mô tả các thành phần

### 1. gp247.json
Khai báo thông tin cơ bản của template:
- name: Tên template
- image: Logo template
- auth: Tác giả
- configGroup: Nhóm cấu hình (đối với Template: "Templates")
- configCode: Mã cấu hình
- configKey: Khóa cấu hình (duy nhất, trùng tên thư mục template)
- version: Phiên bản
- requireCore: Phiên bản Gp247/Core tương thích
- requirePackages: Các package yêu cầu (mặc định `gp247/front`)
- requireExtensions: Tên các extension (plugin, template) yêu cầu

### 2. AppConfig.php
Chứa các phương thức vòng đời của template:
- install(), uninstall(), enable(), disable()
- setupStore(), removeStore()
- clickApp(), getInfo()

### 3. Provider.php
Đăng ký service, event, middleware cần thiết cho template.

### 4. Route.php
Khai báo các route frontend của template.

### 5. blocks/
Chứa các thành phần giao diện dùng chung (ví dụ header, footer, breadcrumb, danh sách sản phẩm...).

### 6. Plugins/
Nơi đặt các phần mở rộng đi kèm template (không bắt buộc). Mỗi plugin có cấu trúc riêng theo chuẩn extension của GP247.

### 7. public/
Chứa tài nguyên tĩnh của template (css, js, images). Khi cài đặt sẽ được publish sang `public/GP247/Templates/{template}`.

## Cách sử dụng

1. Khởi tạo:
   - Đổi tên thư mục theo tên template (trùng `configKey`)
   - Cập nhật thông tin trong `gp247.json`

2. Phát triển:
   - Khai báo route trong `Route.php`
   - Xây dựng giao diện trong `blocks/` và các thư mục con theo nhu cầu
   - Viết helper trong `function.php`
   - Thêm ngôn ngữ trong `Lang/`
   - Thêm tài nguyên vào `public/`

3. Cài đặt:
   - Tham khảo hướng dẫn chi tiết: [English guide](https://gp247.net/en/docs/user-guide-extension/guide-to-installing-the-extension.html) | [Tiếng Việt](https://gp247.net/vi/docs/user-guide-extension/guide-to-installing-the-extension.html)

## Lưu ý

- Sử dụng namespace đúng chuẩn
- Đảm bảo đa ngôn ngữ
- Kiểm tra các dependency trước khi cài đặt
- Xử lý lỗi và rollback khi cần thiết
- Đảm bảo responsive design và hiệu năng tải trang

---

