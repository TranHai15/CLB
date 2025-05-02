# Hệ thống Quản lý Câu lạc bộ & Hỏi đáp

Ứng dụng Laravel 12 nhẹ nhàng để quản lý thành viên câu lạc bộ, kế hoạch & công việc, nội dung (bài đăng/tin tức), tài nguyên, giao dịch quỹ và nội dung Facebook do AI sinh ra. Thiết kế theo mô hình module, soft-delete và chuẩn hóa schema công việc giúp dễ bảo trì và mở rộng.

## Tính năng chính

-   **Quản lý Người dùng & Thành viên CLB**

    -   Đăng ký/Đăng nhập bằng email/password hoặc Google OAuth
    -   Mở rộng profile CLB: mã sinh viên, khóa nhập học, chuyên ngành, vị trí, điện thoại, giới tính

-   **Kế hoạch & Công việc**

    -   Tạo/Sửa/Xóa kế hoạch với trạng thái (pending/ongoing/completed)
    -   Công việc tách thành các bảng nhỏ: phân công, lịch sử trạng thái, thành viên tham gia, issues & solutions, bằng chứng, ghi chú
    -   Soft-delete và lưu lịch sử đầy đủ

-   **Quản lý Nội dung**

    -   **Bài đăng** với bình luận đa cấp
    -   **Tin tức** với thẻ (tags) và bình luận riêng
    -   **Tài nguyên học liệu** phân loại theo danh mục (N–N)

-   **Quỹ & Nội dung AI**

    -   Ghi nhận giao dịch (amount, description)
    -   Lưu prompt và content AI sinh ra cho Facebook để review lại

## Yêu cầu & Chuẩn bị

-   PHP 8.1+
-   Composer
-   Node.js & npm
-   MySQL 5.7+ hoặc MariaDB
-   Thông tin OAuth Google (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URL`)

## Hướng dẫn cài đặt

1. **Clone source về**

    ```bash
    git clone https://github.com/TranHai15/CLB.git
    cd CLB
    ```

2. **Cài đặt thư viện PHP**

    ```bash
    composer install
    ```

3. **Cài đặt JS & build assets**

    ```bash
    npm install
    npm run dev
    ```

4. **Thiết lập biến môi trường**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    - Thiết lập DB, `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URL` trong `.env`

5. **Chạy migration & seeder**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Khởi động server**

    ```bash
    php artisan serve
    ```

    Mở trình duyệt tại `http://localhost:8000`
