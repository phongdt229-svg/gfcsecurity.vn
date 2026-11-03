<?php
/** Menu admin "Hướng dẫn sử dụng": cách cập nhật nội dung website, dành cho người quản trị nội dung. */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', function () {
	add_menu_page( 'Hướng dẫn sử dụng', 'Hướng dẫn sử dụng', 'edit_posts', 'gfc-guide', 'gfc_guide_screen', 'dashicons-book-alt', '2.5' );
} );

function gfc_guide_screen() {
	$u = function ( $path ) {
		return esc_url( admin_url( $path ) );
	};
	$info    = $u( 'customize.php?autofocus%5Bsection%5D=gfc_contact' );
	$content = $u( 'admin.php?page=gfc-page-editor' );
	$branch  = $u( 'edit.php?post_type=gfc_branch' );
	$menus   = $u( 'nav-menus.php' );
	$posts   = $u( 'edit.php' );
	$new     = $u( 'post-new.php' );
	$pages   = $u( 'edit.php?post_type=page' );
	$media   = $u( 'upload.php' );
	$form    = $u( 'admin.php?page=wpcf7' );
	$logo    = $u( 'customize.php?autofocus%5Bsection%5D=title_tagline' );
	?>
	<div class="wrap gfc-guide">
		<h1>Hướng dẫn sử dụng</h1>
		<p class="gfc-guide-lead">Tra bảng dưới đây để biết cần vào đâu, rồi đọc mục tương ứng nếu cần từng bước.</p>

		<h2 id="tra-cuu">Muốn đổi gì, vào đâu</h2>
		<div class="gfc-guide-table"><table class="widefat striped">
			<thead><tr><th>Muốn đổi</th><th>Vào</th><th>Chi tiết</th></tr></thead>
			<tbody>
				<tr><td>Chữ, ảnh, nút, con số trên Trang chủ, Giới thiệu, Liên hệ, Danh mục dịch vụ</td><td><a href="<?php echo $content; // phpcs:ignore ?>">Nội dung trang</a></td><td><a href="#noi-dung">Mục 1</a></td></tr>
				<tr><td>Chứng nhận, khách hàng, báo chí, đánh giá, câu hỏi thường gặp</td><td><a href="<?php echo $content; // phpcs:ignore ?>">Nội dung trang</a></td><td><a href="#danh-sach">Mục 2</a></td></tr>
				<tr><td>Tên công ty, mã số thuế, email, số điện thoại, địa chỉ văn phòng, Zalo, Facebook</td><td><a href="<?php echo $info; // phpcs:ignore ?>">Thông tin công ty</a></td><td><a href="#cong-ty">Mục 3</a></td></tr>
				<tr><td>Logo, tên website, biểu tượng trên tab trình duyệt</td><td><a href="<?php echo $logo; // phpcs:ignore ?>">Nhận dạng site</a></td><td><a href="#logo">Mục 4</a></td></tr>
				<tr><td>Menu đầu trang, link ở chân trang</td><td><a href="<?php echo $menus; // phpcs:ignore ?>">Giao diện → Menu</a></td><td><a href="#menu">Mục 5</a></td></tr>
				<tr><td>Tin tức, tin tuyển dụng</td><td><a href="<?php echo $posts; // phpcs:ignore ?>">Bài viết</a></td><td><a href="#tin-tuc">Mục 6</a></td></tr>
				<tr><td>Trang dịch vụ: giá, nhiệm vụ, quy trình</td><td><a href="<?php echo $posts; // phpcs:ignore ?>">Bài viết</a></td><td><a href="#dich-vu">Mục 7</a></td></tr>
				<tr><td>Danh sách chi nhánh, bản đồ</td><td><a href="<?php echo $branch; // phpcs:ignore ?>">Chi nhánh</a></td><td><a href="#chi-nhanh">Mục 8</a></td></tr>
				<tr><td>Ô nhập của form liên hệ, email nhận yêu cầu</td><td><a href="<?php echo $form; // phpcs:ignore ?>">Form liên hệ</a></td><td><a href="#form">Mục 9</a></td></tr>
				<tr><td>Hồ sơ năng lực, Câu hỏi thường gặp, Chính sách bảo mật, Quyền lợi nhân viên</td><td><a href="<?php echo $pages; // phpcs:ignore ?>">Trang</a></td><td><a href="#trang">Mục 10</a></td></tr>
				<tr><td>Nút chuyển ngôn ngữ Việt - Anh</td><td><a href="<?php echo $u( 'options-general.php?page=gtranslate_options' ); // phpcs:ignore ?>">Cài đặt → GTranslate</a></td><td><a href="#ngon-ngu">Mục 11</a></td></tr>
				<tr><td>Từ khoá, tiêu đề và mô tả trên Google</td><td><a href="<?php echo $posts; // phpcs:ignore ?>">Bài viết</a> / <a href="<?php echo $pages; // phpcs:ignore ?>">Trang</a></td><td><a href="#seo">Mục 12</a></td></tr>
			</tbody>
		</table></div>

		<h2 id="noi-dung">1. Sửa nội dung Trang chủ, Giới thiệu, Liên hệ, Danh mục dịch vụ</h2>
		<ol>
			<li>Vào <a href="<?php echo $content; // phpcs:ignore ?>">Nội dung trang</a> và chọn tab của trang cần sửa.</li>
			<li>Bấm vào tên khối để mở. Các khối xếp theo thứ tự từ trên xuống như trên trang.</li>
			<li>Sửa chữ trong ô. Muốn đổi ảnh thì bấm <strong>Chọn ảnh</strong> rồi chọn từ Thư viện hoặc tải ảnh mới lên.</li>
			<li>Bấm <strong>Lưu thay đổi</strong>, rồi bấm <strong>Xem trang</strong> để kiểm tra. Nếu chưa thấy thay đổi, nhấn Ctrl + F5.</li>
		</ol>
		<ul>
			<li><strong>Xuống dòng:</strong> nhấn Enter trong ô chữ thì trên trang cũng xuống dòng.</li>
			<li><strong>Ô để trống:</strong> đoạn văn và tiêu đề được để trống. Ô nút, nhãn, ảnh và link nếu để trống thì hệ thống giữ nội dung cũ. Muốn bỏ hẳn, hãy xoá mục đó (xem Mục 2).</li>
			<li><strong>Nội dung lặp:</strong> chữ giống nhau giữa bản máy tính và điện thoại được gộp một ô, sửa một lần là đổi cả hai.</li>
			<li><strong>Mô tả ảnh (SEO):</strong> không hiện trên trang, chỉ giúp công cụ tìm kiếm hiểu ảnh. Nên ghi ngắn gọn ảnh đó có gì.</li>
			<li><strong>Con số thống kê</strong> và câu <strong>“63 văn phòng đại diện”</strong> là chữ nhập tay, không tự đếm theo mục Chi nhánh. Thêm hoặc bớt chi nhánh thì nhớ sửa cả ở đây.</li>
			<li><strong>Video:</strong> dán link nhúng (dạng <code>youtube.com/embed/...</code>), không dán link xem video thông thường.</li>
		</ul>
		<p id="khoi-phuc"><strong>Lỡ sửa sai:</strong> mỗi lần lưu đều tạo một bản lưu. Bấm <strong>Khôi phục bản trước</strong> ở cuối màn hình Nội dung trang, kéo thanh trượt đến thời điểm trước khi sửa, rồi bấm nút khôi phục. Phần so sánh hiện nhiều ký tự mã hoá, nên hãy chọn theo thời gian lưu.</p>

		<h2 id="danh-sach">2. Thêm, xoá, đổi thứ tự trong danh sách</h2>
		<p>Những phần có nhiều mục giống nhau hiện thành <strong>Danh sách</strong> có viền xanh, ví dụ logo khách hàng, chứng nhận, đánh giá, câu hỏi thường gặp. Bấm vào một mục để mở các nút:</p>
		<ul>
			<li><strong>Nhân bản:</strong> tạo bản sao ngay dưới mục đó. Muốn <em>thêm mục mới</em>, hãy nhân bản một mục rồi sửa bản sao.</li>
			<li><strong>↑ Lên / ↓ Xuống:</strong> đổi vị trí.</li>
			<li><strong>Xoá mục này:</strong> xoá sau khi bạn xác nhận. Danh sách phải còn ít nhất một mục.</li>
		</ul>
		<p class="gfc-guide-note">Các nút này <strong>lưu ngay</strong> khi bấm, kèm mọi chữ bạn đang sửa dở trên trang.</p>

		<h2 id="cong-ty">3. Thông tin công ty</h2>
		<ol>
			<li>Vào <a href="<?php echo $info; // phpcs:ignore ?>">Thông tin công ty</a>. Khung bên phải là bản xem trước.</li>
			<li>Sửa các ô, rồi bấm <strong>Xuất bản</strong> ở trên cùng để áp dụng.</li>
		</ol>
		<ul>
			<li>Thay đổi tự áp dụng cho chân trang, trang Liên hệ, nút liên hệ nổi và cột phải bài viết.</li>
			<li><strong>Để trống một ô thì dòng đó tự ẩn.</strong> Ví dụ xoá địa chỉ Chi nhánh 2 thì chi nhánh đó biến mất; điền link Facebook thì biểu tượng Facebook hiện ra.</li>
			<li>Nút <strong>Hồ sơ năng lực</strong> trên Trang chủ và Giới thiệu chỉ hiện khi đã điền link hồ sơ.</li>
			<li>Địa chỉ TP.HCM trong danh sách chi nhánh là dữ liệu riêng. Đổi địa chỉ trụ sở thì sửa thêm ở <a href="<?php echo $branch; // phpcs:ignore ?>">Chi nhánh</a>.</li>
		</ul>

		<h2 id="logo">4. Logo</h2>
		<ul>
			<li><strong>Logo đầu trang và chân trang:</strong> vào <a href="<?php echo $logo; // phpcs:ignore ?>">Nhận dạng site</a>, đổi Logo, rồi bấm <strong>Xuất bản</strong>. Cũng tại đây có tên website và biểu tượng tab trình duyệt.</li>
			<li><strong>Logo trên banner cột phải bài viết:</strong> ở cuối <a href="<?php echo $info; // phpcs:ignore ?>">Thông tin công ty</a>.</li>
		</ul>

		<h2 id="menu">5. Menu đầu trang và link chân trang</h2>
		<ol>
			<li>Vào <a href="<?php echo $menus; // phpcs:ignore ?>">Giao diện → Menu</a>, chọn menu cần sửa trong ô thả xuống rồi bấm <strong>Chọn</strong>: <strong>Menu chính</strong>, <strong>Footer — Dịch vụ</strong> hoặc <strong>Footer — Hỗ trợ khách hàng</strong>.</li>
			<li>Thêm mục từ cột bên trái. Kéo thả để đổi thứ tự; kéo lệch sang phải để thành menu con.</li>
			<li>Bấm <strong>Lưu menu</strong>.</li>
		</ol>
		<p>Menu đầu trang tự dùng chung cho máy tính và điện thoại. Link chân trang chỉ hiện một cấp, không có menu con.</p>

		<h2 id="tin-tuc">6. Đăng tin tức, tin tuyển dụng</h2>
		<ol>
			<li>Vào <a href="<?php echo $new; // phpcs:ignore ?>">Bài viết → Thêm mới</a>, nhập tiêu đề và nội dung.</li>
			<li>Ở khung bên phải, chọn <strong>Danh mục</strong>: Bảo vệ TPHCM, miền Nam, miền Trung, miền Bắc, Kiến thức ngành bảo vệ, hoặc Tuyển dụng cho tin tuyển dụng.</li>
			<li>Cũng ở khung bên phải, đặt ảnh đại diện để bài có ảnh trong danh sách tin.</li>
			<li>Bấm <strong>Xuất bản</strong>.</li>
		</ol>
		<p class="gfc-guide-note">Bốn bài ở khối “Chia sẻ kiến thức” trên Trang chủ là bài chọn tay, bài mới không tự hiện vào đó. Muốn đổi, sửa tiêu đề, ảnh, link trong khối này ở <a href="<?php echo $content; // phpcs:ignore ?>">Nội dung trang</a>.</p>

		<h2 id="dich-vu">7. Trang dịch vụ</h2>
		<p>Mỗi dịch vụ là một bài viết. Mở bài, cuộn xuống khung <strong>Nội dung trang dịch vụ</strong>. Khối nào để trống sẽ tự ẩn.</p>
		<ul>
			<li>Ô ghi “mỗi dòng: A | B” thì nhập mỗi mục một dòng, hai phần cách nhau bằng dấu <code>|</code>. Ví dụ ở Nhiệm vụ: <code>Kiểm soát ra vào | Kiểm soát người và phương tiện</code>.</li>
			<li><strong>Bảng giá:</strong> nếu ô “Bảng giá — nội dung HTML” có dữ liệu thì ô đó được dùng, các ô bảng giá còn lại bị bỏ qua. Muốn dùng các ô đơn giản, hãy xoá trống ô HTML.</li>
		</ul>
		<p><strong>Thêm dịch vụ mới:</strong></p>
		<ol>
			<li>Tạo <a href="<?php echo $new; // phpcs:ignore ?>">bài viết mới</a>, chọn danh mục “Danh mục dịch vụ Long Vân Security”. Phải điền ô <strong>Banner — tiêu đề</strong> thì bài mới hiển thị theo khung trang dịch vụ. Xuất bản rồi chép lại đường dẫn của bài.</li>
			<li>Bài không tự xuất hiện trong các danh sách. Vào <a href="<?php echo $content; // phpcs:ignore ?>">Nội dung trang</a>, tab Danh mục dịch vụ, nhân bản một thẻ dịch vụ rồi đổi tên, ảnh, link. Làm tương tự ở khối dịch vụ trên Trang chủ nếu cần.</li>
			<li>Thêm vào <a href="<?php echo $menus; // phpcs:ignore ?>">menu</a> nếu muốn hiện trên menu.</li>
		</ol>

		<h2 id="chi-nhanh">8. Chi nhánh</h2>
		<ol>
			<li>Vào <a href="<?php echo $branch; // phpcs:ignore ?>">Chi nhánh</a>, mở một chi nhánh hoặc bấm <strong>Thêm chi nhánh</strong>.</li>
			<li>Tên chi nhánh nhập ở ô tiêu đề; điền địa chỉ, và link trang dịch vụ tỉnh nếu có.</li>
			<li>Ô <strong>Sắp xếp</strong> bên phải quyết định vị trí: số nhỏ đứng trước.</li>
			<li>Bấm <strong>Xuất bản</strong> hoặc <strong>Cập nhật</strong>. Danh sách trên Trang chủ và Giới thiệu tự đổi theo.</li>
		</ol>
		<p><strong>Lấy link bản đồ:</strong> trên Google Maps, tìm địa điểm → Chia sẻ → Nhúng bản đồ → Sao chép HTML. Trong đoạn đã sao chép, chỉ dán phần link nằm trong <code>src="..."</code> vào ô bản đồ.</p>

		<h2 id="form">9. Form liên hệ</h2>
		<ul>
			<li>Vào <a href="<?php echo $form; // phpcs:ignore ?>">Form liên hệ</a> và mở <strong>Form liên hệ</strong>.</li>
			<li>Tab <strong>Nội dung Form</strong>: các ô khách hàng nhập. Tab <strong>Cấu hình Mail</strong>: địa chỉ nhận yêu cầu, ở ô “Mail nhận”.</li>
			<li>Yêu cầu của khách được gửi về email, không lưu trong trang quản trị.</li>
		</ul>
		<p class="gfc-guide-note">Khi website còn chạy trên máy cá nhân, email chưa gửi được. Sau khi lên hosting, hãy gửi thử một yêu cầu để kiểm tra.</p>

		<h2 id="trang">10. Các trang văn bản</h2>
		<p>Hồ sơ năng lực, Câu hỏi thường gặp, Chính sách bảo mật, Quyền lợi và chế độ đãi ngộ, Tiêu chuẩn tuyển chọn sửa như văn bản bình thường trong <a href="<?php echo $pages; // phpcs:ignore ?>">Trang</a>. Câu hỏi ở khối “Câu hỏi thường gặp” trên Trang chủ là dữ liệu riêng, sửa ở <a href="<?php echo $content; // phpcs:ignore ?>">Nội dung trang</a>.</p>

		<h2 id="ngon-ngu">11. Tiếng Anh và tiếng Việt</h2>
		<p>Khách chuyển ngôn ngữ bằng mục lá cờ ở cuối menu đầu trang: rê chuột vào rồi chọn VI hoặc EN (trên điện thoại, mục này nằm trong menu ba gạch). Mục này do plugin tự thêm nên không hiện trong Giao diện → Menu. Bản tiếng Anh do Google tự dịch khi khách xem, nên bạn chỉ cần nhập nội dung tiếng Việt.</p>
		<ul>
			<li><strong>Kiểm tra bản dịch:</strong> máy có thể dịch chưa sát, nhất là thuật ngữ, giá và cam kết. Hiện chưa có chỗ sửa tay từng câu tiếng Anh.</li>
			<li><strong>Không được dịch:</strong> chữ nằm trong ảnh, như banner, chứng nhận và sơ đồ.</li>
			<li><strong>Tên công ty:</strong> có lúc hiện “Long Van”, có lúc “Long Vân”.</li>
			<li><strong>Công cụ tìm kiếm:</strong> bản tiếng Anh không có đường dẫn riêng nên Google Search không lập chỉ mục được.</li>
		</ul>

		<h2 id="seo">12. SEO với Yoast</h2>
		<p>Mở bài viết hoặc trang, tìm khung <strong>Yoast SEO</strong> để sửa từ khoá chính, tiêu đề SEO và mô tả. Từ khoá và mô tả có sẵn được tạo tự động từ nội dung, nên hãy đọc lại các bài quan trọng.</p>
		<ul>
			<li><strong>Điểm:</strong> chỉ hiện trong danh sách bài sau khi bài được mở và cập nhật. Điểm là gợi ý để viết tốt hơn, không phải thứ hạng trên Google.</li>
			<li><strong>Điểm dễ đọc:</strong> chỉ để tham khảo, vì Yoast không phân tích sâu được tiếng Việt.</li>
			<li><strong>Trang chủ, Giới thiệu, Liên hệ:</strong> sửa nội dung ở Nội dung trang, rồi mở trang trong <a href="<?php echo $pages; // phpcs:ignore ?>">Trang</a> để xem điểm.</li>
			<li><strong>Không nhồi từ khoá:</strong> mỗi bài nên có một từ khoá riêng, viết tự nhiên trong tiêu đề, đoạn đầu và mô tả.</li>
		</ul>

		<h2 id="anh">Lưu ý về ảnh</h2>
		<ul>
			<li>Chọn ảnh mới cùng tỉ lệ với ảnh đang dùng để bố cục không bị lệch.</li>
			<li>Ảnh tải lên <a href="<?php echo $media; // phpcs:ignore ?>">Thư viện</a> được tự động tạo thêm bản WebP nhẹ hơn, ảnh gốc giữ nguyên. Không cần nén trước, nhưng tránh dùng ảnh quá lớn.</li>
			<li>Chỉ dùng ảnh, logo của khách hàng và chứng nhận mà công ty có quyền sử dụng.</li>
		</ul>

		<h2 id="su-co">Khi gặp sự cố</h2>
		<div class="gfc-guide-table"><table class="widefat striped">
			<thead><tr><th>Hiện tượng</th><th>Cách xử lý</th></tr></thead>
			<tbody>
				<tr><td>Đã lưu nhưng trang vẫn như cũ</td><td>Nhấn Ctrl + F5 để tải lại.</td></tr>
				<tr><td>Báo “Trang vừa được sửa ở nơi khác”</td><td>Có người khác hoặc tab khác vừa lưu. Thay đổi của bạn chưa được lưu, hãy kiểm tra nội dung mới rồi nhập lại.</td></tr>
				<tr><td>Mở trang bằng WPBakery, thấy các mã như <code>{{hotline1}}</code></td><td>Đừng xoá hay đổi các mã này, vì hệ thống dùng chúng để điền thông tin. Nên sửa ở Nội dung trang thay vì WPBakery.</td></tr>
				<tr><td>Không thấy menu Nội dung trang</td><td>Tài khoản cần vai trò Quản trị viên hoặc Biên tập viên.</td></tr>
				<tr><td>Trang bị lệch sau khi sửa</td><td>Bấm Khôi phục bản trước, xem <a href="#khoi-phuc">cuối Mục 1</a>.</td></tr>
			</tbody>
		</table></div>

		<h2 id="ky-thuat">Phần cần nhờ kỹ thuật</h2>
		<p>Không sửa được trong trang quản trị: nhãn của nút liên hệ nổi (như “Thuê bảo vệ”), chữ trên banner cột phải bài viết, và bố cục của trang tin tức, trang dịch vụ.</p>
		<p><a href="#tra-cuu">↑ Về bảng tra cứu</a></p>
	</div>
	<style>
	.gfc-guide{max-width:860px}
	.gfc-guide h2{margin:32px 0 10px;padding-top:12px;border-top:1px solid #dcdcde;font-size:17px;scroll-margin-top:40px}
	.gfc-guide #tra-cuu{border-top:0;padding-top:0}
	.gfc-guide p,.gfc-guide li{font-size:14px;line-height:1.6}
	.gfc-guide ol,.gfc-guide ul{margin-left:22px}
	.gfc-guide ul{list-style:disc}
	.gfc-guide-lead{font-size:15px}
	.gfc-guide-note{background:#fff;border-left:4px solid #dba617;padding:10px 12px}
	.gfc-guide-table{overflow-x:auto}
	.gfc-guide td,.gfc-guide th{font-size:14px;vertical-align:top}
	</style>
	<?php
}
