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
- Trang chủ, Giới thiệu, Liên hệ, Danh mục dịch vụ: sửa ở menu admin "Nội dung trang" (inc/page-editor.php): chữ, ảnh, link, video, con số và thêm/xoá/đổi chỗ mục trong danh sách. Cần quyền unfiltered_html. Mỗi lần lưu tạo một Revision của trang.
- Có thể mở các trang đó bằng WPBakery, mỗi section là một row Raw HTML. Giữ nguyên các chỗ {{UPLOADS}}, {{HOME}}, {{THEME}}, {{CONTACT_FORM}}.
- Danh mục dịch vụ (/dich-vu-gfc) lấy nội dung từ trang riêng tư có đường dẫn noi-dung-danh-muc-dich-vu; không có trang này thì dùng live-tpl/cat-services.html.
- Đa ngôn ngữ: plugin GTranslate bản miễn phí (Cài đặt → GTranslate), gốc tiếng Việt, thêm English, nút nổi góc dưới trái. Dịch bằng Google trên trình duyệt, không tạo URL riêng.
- Hướng dẫn cho người quản trị nội dung: menu admin "Hướng dẫn sử dụng" (inc/admin-guide.php). Đổi màn hình hoặc tên nút thì cập nhật cả đây.
- Danh sách chi nhánh trên Trang chủ và Giới thiệu lấy từ menu admin "Chi nhánh" (mã {{branch_locations}}, {{branch_items}}).
- Menu header: Giao diện → Menu → "Menu chính".
- Footer, trang Liên hệ, nút nổi, banner bài viết: sửa ở menu admin "Thông tin công ty". Để trống một ô thì dòng đó tự ẩn.
- Link footer: Giao diện → Menu ("Footer — Dịch vụ", "Footer — Hỗ trợ khách hàng").
- Trong row WPBakery giữ nguyên các mã dạng {{hotline1}}, {{email}}, {{office1_address}}.
- Nằm cố định trong live-tpl/: nhãn nút liên hệ nổi, banner cột phải bài viết, khung trang tin tức và trang dịch vụ.
- Form trang Liên hệ dùng plugin Contact Form 7 (ID lấy từ Tuỳ biến, mặc định 6434). Chỉnh trường và email nhận tại menu Liên hệ trong admin.
