=== GFC Security ===
Phiên bản: 1.0.0 | WordPress ≥ 6.0 | PHP ≥ 7.4

Theme dựng lại cho gfcsecurity.vn, giữ nguyên cấu trúc, nội dung và giao diện bản cũ.

== Cài đặt ==
1. Sao lưu website (file + database) trước khi đổi theme.
2. Giao diện → Giao diện → Thêm mới → Tải giao diện lên → chọn gfc-security-1.0.0.zip → Cài đặt → Kích hoạt.
   (Nên thử trên bản staging trước khi áp dụng cho site chính.)
3. Khi kích hoạt, theme tự:
   - Tạo mục "Chi nhánh" với 12 văn phòng mẫu (thêm đủ 63 văn phòng tại menu Chi nhánh trong admin).
   - Gán mẫu "Trang dịch vụ GFC" cho trang /bao-ve-ngan-hang và điền sẵn nội dung như bản cũ.

== Các phần cần biết ==
- Trang chủ: tự dùng file front-page.php. Chữ/ảnh trang chủ nằm trong inc/data.php.
- Ảnh: dùng lại ảnh có sẵn trong Thư viện Media (wp-content/uploads), không cần tải lại.
- Thông tin liên hệ (tổng đài, hotline, email, Zalo, ID form CF7...): Giao diện → Tuỳ biến → "Thông tin liên hệ GFC".
- Logo: Giao diện → Tuỳ biến → Nhận dạng site → Logo (để trống = dùng logo SVG hiện tại).
- Menu: Giao diện → Menu, gán vào "Menu chính", "Footer — Dịch vụ", "Footer — Hỗ trợ khách hàng".
  Chưa gán thì theme dùng menu y như bản cũ.
- Trang dịch vụ khác: sửa trang → Mẫu trang = "Trang dịch vụ GFC" → điền các ô trong khung
  "Nội dung trang dịch vụ GFC" (bảng giá, nhiệm vụ, quy trình...). Ô nào trống thì khối đó ẩn.
  Bài viết chi tiết bên dưới vẫn soạn trong trình soạn thảo như bình thường.
- Trang Liên hệ: tự áp dụng cho trang có đường dẫn /lien-he; dùng form Contact Form 7 (ID 6434).
  Nếu tắt plugin CF7, theme có form dự phòng gửi email về địa chỉ trong Tuỳ biến.

== Changelog ==
1.0.0 — Bản đầu tiên.

== Bản đang chạy local (sau 1.0.0) ==
- Giao diện dùng CSS, markup, font và icon của gfcsecurity.vn: live-tpl/*.html + assets/live/ (xem inc/live.php).
- Sửa được trong WordPress: bài viết, trang nội dung, khung trang dịch vụ.
- Nằm cố định trong live-tpl/: header, footer, trang chủ, Giới thiệu, Liên hệ, /dich-vu-gfc. Muốn đổi các phần này phải sửa file. Menu, Tuỳ biến và mục Chi nhánh trong admin không còn tác dụng với chúng.
