<?php
/**
 * Nội dung mặc định của trang chủ (giữ nguyên như website hiện tại).
 * Sửa chữ / ảnh trực tiếp trong file này. Ảnh trỏ vào thư viện Media sẵn có (wp-content/uploads).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_home_data() {
	return array(

		'hero' => array(
			'title'    => 'Công ty Dịch vụ Bảo vệ<br>GFC Security',
			'subtitle' => 'Dịch vụ bảo vệ chuyên nghiệp, uy tín hàng đầu việt nam',
			'bg'       => gfc_up( '2025/10/banner-gfc-1-1.png' ),
			'slides'   => array(
				gfc_up( '2025/11/Cong-ty-gfc-security-1-1200x873.jpg' ),
				gfc_up( '2026/01/cong-ty-bao-ve-gfc-security-3-1200x856.jpg' ),
				gfc_up( '2026/01/cong-ty-bao-ve-gfc-security-1-1200x873.jpg' ),
				gfc_up( '2026/01/cong-ty-bao-ve-gfc-security-2-1200x873.jpg' ),
			),
			'features' => array(
				array( gfc_up( '2025/10/Frame.svg' ), 'Tiêu chuẩn chất lượng ISO 9001:2015' ),
				array( gfc_up( '2025/10/Frame-1.svg' ), 'Kiểm soát chất lượng nhân sự nghiêm ngặt' ),
				array( gfc_up( '2025/10/Frame-2.svg' ), 'Bảo hiểm trách nhiệm lên đến 25 tỷ' ),
				array( gfc_up( '2025/10/Frame-3.svg' ), 'Trang bị thiết bị & công nghệ hiện đại' ),
			),
			'cta_text' => 'Liên hệ ngay',
			'cta_url'  => home_url( '/lien-he' ),
		),

		'intro' => array(
			'paragraphs' => array(
				'Công ty CP Tập đoàn Bảo vệ GFC (hay còn gọi là Công ty Dịch vụ Bảo vệ GFC Security) là công ty bảo vệ uy tín LỚN NHẤT Việt Nam với hơn 31 năm kinh nghiệm (từ năm 1994) do Đại tá Đinh Hùng sáng lập. GFC Secuirty cung cấp các dịch vụ bảo vệ đa dạng như dịch vụ bảo vệ ngân hàng, nhà hàng - khách sạn, bệnh viện, văn phòng, dịch vụ bảo vệ sự kiện, áp tải hàng hoá và dịch vụ bảo vệ yếu nhân - VIP,... phục vụ mọi nhu cầu của khách hàng.',
				'Chúng tôi có trụ sở công ty bảo vệ tại TP. HCM, 2 chi nhánh tại Hà Nội, Đà Nẵng và hơn 63 văn phòng đại diện phủ khắp 34 tỉnh thành, cùng hơn 14.300 nhân viên (số lượng nhân viên nhiều nhất Việt Nam, theo số liệu tháng 4/2022).',
				'Uy tín của công ty dịch vụ bảo vệ GFC Security được bảo đảm thông qua chứng nhận ISO 9001:2015. Đây chính là thước đo tiêu chuẩn quốc tế về Hệ thống Quản lý Chất lượng cho doanh nghiệp. Ngoài ra, toàn bộ nhân sự bảo vệ của GFC đều trải qua các khoá huấn luyện nghiêm ngặt của Bộ Công an và công ty để thành thạo các kỹ năng từ cơ bản đến nâng cao như tự vệ, sử dụng CCHT, PCCC, đối phó tình huống khẩn cấp,...',
				'Bên cạnh đó, trang bị bảo hiểm đầy đủ điểm cũng là một điểm nổi bật của công ty bảo vệ GFC Security giúp khách hàng an tâm, bao gồm bảo hiểm trách nhiệm dân sự, bảo hiểm tai nạn, bảo hiểm cháy nổ,... Nhân viên của chúng tôi cũng được hưởng nhiều loại bảo hiểm từ công ty.',
				'Cuối cùng, chi phí là khách hàng phải chi trả cho dịch vụ bảo vệ của chúng tôi được tính trọn gói ở mức hợp lý nhất cho chất lượng dịch vụ hàng đầu. Và mức giá này luôn được công khai minh bạch ngay từ đầu để chắc chắn rằng khách hàng sẽ không phải chịu thêm bất cứ chi phí phát sinh ẩn nào.',
			),
			'btn_text' => 'Xem Hồ sơ năng lực',
			'btn_url'  => 'https://drive.google.com/file/d/1LSoDN_yA28wqBYLXKYUBuccjL46H5zPJ/view',
			'youtube'  => 'gvxXPp41DZo',
		),

		'stats' => array(
			array( 'Thành lập từ', 1994, '' ),
			array( 'Kinh nghiệm', 31, '+' ),
			array( 'Vốn điều lệ (tỷ)', 286, '' ),
			array( 'Chi nhánh', 63, '+' ),
			array( 'Khách hàng', 5721, '+' ),
			array( 'Nhân viên', 14300, '+' ),
		),

		'services_title' => 'Dịch vụ bảo vệ <span>GFC Security</span>',
		'services' => array(
			array( 'Dịch vụ bảo vệ toà nhà', '/dich-vu-bao-ve-toa-nha', '2025/10/1.png' ),
			array( 'Dịch vụ bảo vệ trường học', '/bao-ve-truong-hoc', '2025/11/dich-vu-bao-ve-truong-hoc-gfc-security.jpg' ),
			array( 'Dịch vụ bảo vệ bệnh viện', '/dich-vu-bao-ve-benh-vien', '2025/10/3.png' ),
			array( 'Dịch vụ bảo vệ ngân hàng', '/bao-ve-ngan-hang', '2025/10/4.png' ),
			array( 'Dịch vụ bảo vệ kho hàng', '/dich-vu-bao-ve-kho-hang', '2025/11/dich-vu-bao-ve-kho-hang.jpg' ),
			array( 'Dịch vụ bảo vệ nhà riêng', '/bao-ve-nha-rieng', '2025/11/dich-vu-bao-ve-nha-rieng-gfc-security.png' ),
			array( 'Dịch vụ bảo vệ công trường', '/bao-ve-cong-truong', '2025/10/7.png' ),
			array( 'Dịch vụ bảo vệ giữ xe', '/bang-gia-thue-bao-ve-giu-xe', '2025/10/8.png' ),
			array( 'Dịch vụ bảo vệ khu công nghiệp', '/bao-ve-khu-cong-nghiep', '2025/11/dich-vu-bao-ve-khu-cong-nghiep-gfc-security-1.jpg' ),
			array( 'Dịch vụ bảo vệ nhà hàng - khách sạn', '/bao-ve-nha-hang-khach-san', '2025/11/dich-vu-bao-ve-nha-hang-khach-san-gfc-security-1200x576.jpg' ),
		),

		'diff' => array(
			'title' => 'Điểm khác biệt của dịch vụ bảo vệ chuyên nghiệp GFC Security',
			'desc'  => 'Công ty dịch vụ bảo vệ GFC Security chú trọng trong việc đào tạo đội ngũ cân bộ nhân viên bài bản và chuyên sâu, luôn đảm bảo mang tới cho quý khách hàng một đội ngũ bảo vệ chuyên nghiệp – tâm huyết với nghề',
			'bg'    => gfc_up( '2025/10/Frame-18.png' ),
			'items' => array(
				array( 'trophy', 'TOP 1 TẠI VIỆT NAM', 'Công ty bảo vệ có quy mô nhân sự lớn và bề dày kinh nghiệm hàng đầu Việt Nam.' ),
				array( 'phone', 'ĐỘC QUYỀN APP BẢO VỆ TRÊN ĐIỆN THOẠI', 'Dễ dàng quản lý, theo dõi và đánh giá chất lượng dịch vụ mọi lúc, mọi nơi chỉ bằng điện thoại.' ),
				array( 'money', 'BẢO HIỂM TRÁCH NHIỆM 25 TỶ', 'Khách hàng của GFC Security được bảo hiểm lên đến 1 triệu Đô la Mỹ.' ),
				array( 'network', 'Hơn 14.300 nhân viên trên toàn quốc', 'Với mạng lưới nhân sự phân bổ khắp cả nước, dịch vụ bảo vệ chất lượng cao GFC Security tự hào đáp ứng nhanh chóng nhu cầu bảo vệ mọi miền Tổ quốc.' ),
				array( 'star', 'KHÁCH HÀNG LÀ SỐ 1', '100% nhân viên được đào tạo bài bản, chuyên nghiệp để mang lại dịch vụ bảo vệ tốt nhất.' ),
				array( 'guard', 'Nhân viên được đào tạo khắt khe', 'Toàn bộ nhân viên bảo vệ bắt buộc phải trải qua các khoá đào tạo nghiệp vụ và được cấp chứng chỉ tương ứng.' ),
			),
		),

		'awards_title' => 'Chứng nhận & giải thưởng của dịch vụ bảo vệ chuyên nghiệp GFC',
		'awards' => array(
			'2025/10/ANTT-351x500.jpg', '2025/10/Bao-hiem-1-357x500.jpg', '2025/10/Bao-hiem-2-357x500.jpg', '2025/10/Bao-hiem-357x500.jpg',
			'2025/10/Cup-1-500x469.jpg', '2025/10/Cup-2-485x500.png', '2025/10/Cup-3-500x473.png', '2025/10/Cup-4-copy-424x500.png',
			'2025/10/Cup-5-439x500.png', '2025/10/Giai-thuong-1-500x333.jpg', '2025/10/Giai-thuong-2-500x333.jpg', '2025/10/Giai-thuong-3-500x333.jpg',
			'2025/10/Giai-thuong-4-500x333.jpg', '2025/10/Giay-khen-1-500x397.jpg', '2025/10/Giay-khen-8-500x375.jpg', '2025/10/Giay-khen-81-500x375.jpg',
			'2025/10/Giay-khen-12-500x375.jpg', '2025/10/Giay-khen-13-500x397.jpg', '2025/10/Giay-khen-14-500x375.jpg', '2025/10/Giay-khen-15-500x370.jpg',
			'2025/10/Giay-khen-16-500x382.jpg', '2025/10/Giay-khen-17-500x375.jpg', '2025/10/Giay-khen-18-500x354.jpg', '2025/10/Giay-khen-19-500x375.jpg',
			'2025/10/Giay-khen-20-500x398.jpg', '2025/10/Giay-phep1-364x500.jpg', '2025/10/ISO-1-352x500.jpg', '2025/10/ISO-21-357x500.jpg', '2025/10/LU_-407x500.jpg',
		),

		'clients_title' => 'Khách hàng của công ty bảo vệ GFC Security',
		'clients_row1' => array(
			'2025/10/Frame-16.svg', '2025/10/Frame-1171277856.svg', '2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-2.svg',
			'2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-3.svg', '2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-4.svg',
			'2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-5.svg', '2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-6.svg',
			'2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-7.svg', '2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-8.svg',
			'2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-9.svg', '2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-10.svg',
			'2025/10/Logo-Bo-Cong-an-vector-01-e1632909148729-1-11.svg',
		),
		'clients_row2' => array(
			'2025/11/Vietnam_Airlines-Logo.wine_.png', '2025/11/logo-masan-group-compressed.jpg', '2025/11/Flamingo.png',
			'2025/11/Vinamilk_new_logo.svg.png', '2025/11/Nguyenkim_Logo.svg.png', '2025/11/1.vietcombank.jpg', '2025/11/doji.png',
			'2025/11/logo-hanwha.jpg', '2025/11/Hotel-nikko-saigon.png', '2025/11/aeon.jpg', '2025/11/intercontinental.png', '2025/11/logo-fpt-1.jpg',
		),

		'branches_title' => 'Hệ thống văn phòng đại diện &<br>Chi nhánh GFC Security trên cả nước',
		'branches_map'   => gfc_up( '2025/10/Frame-1171277853-2.png' ),
		'branches_count' => '63 văn phòng đại diện trên khắp tỉnh thành',

		'press_title' => 'Đài truyền hình và báo chí đưa tin về dịch vụ bảo vệ uy tín GFC Security',
		'press' => array(
			array( '2026/01/logo-24h-new.jpg', 'https://www.24h.com.vn/doanh-nghiep/ap-luc-an-ninh-tang-cao-dip-tet-nhieu-gia-dinh-tim-den-dich-vu-bao-ve-chuyen-nghiep-c849a1720354.html' ),
			array( '2026/01/bao-da-nang.png', 'https://baodanang.vn/cong-ty-bao-ve-da-nang-gfc-security-dia-chi-cung-cap-dich-vu-an-ninh-tin-cay-cho-moi-nha-3315181.html' ),
			array( '2026/01/bao-ha-tinh.png', 'https://baohatinh.vn/gfc-security-nhung-con-so-khang-dinh-vi-the-hang-dau-trong-nganh-bao-ve-viet-nam-post301306.html' ),
			array( '2026/01/bao-dong-nai.png', 'https://baodongnai.com.vn/doanh-nhan-doanh-nghiep/dich-vu/202512/gfc-security-don-vi-bao-ve-chuyen-nghiep-hang-dau-viet-nam-voi-he-thong-dich-vu-toan-dien-372188b/' ),
			array( '2026/01/bao-an-giang.jpg', 'https://baoangiang.com.vn/gfc-security-xay-dung-uy-tin-trong-linh-vuc-an-ninh-bao-ve-qua-ba-thap-ky-a469712.html' ),
			array( '2026/01/bao-thanh-hoa.png', 'https://baothanhhoa.vn/gfc-security-giai-phap-an-ninh-ben-vung-cho-doanh-nghiep-trong-thoi-dai-so-271151.htm' ),
			array( '2026/01/bao-quang-ninh.png', 'https://baoquangninh.vn/gfc-security-dap-ung-nhu-cau-bao-ve-dip-tet-voi-giai-phap-an-ninh-chuyen-nghiep-3388726.html' ),
			array( '2026/01/bao-phap-luat-tphcm.jpg', 'https://plo.vn/binh-duong-gfc-security-giai-phap-an-ninh-toan-dien-cho-thu-phu-cong-nghiep-post886595.html' ),
			array( '2025/10/1-2.png', '' ),
			array( '2025/10/2-2.png', '' ),
			array( '2025/10/3-2.png', '' ),
			array( '2025/10/4-2.png', '' ),
		),

		'feedback_title' => 'Feedback của khách hàng dành cho công ty bảo vệ chuyên nghiệp GFC',
		'feedback' => array(
			array( '2025/11/feedback-gfc-security-3-150x150.jpg', 'Thị Vắng Vì', 'Tuần trước công ty mình có ghé bên văn phòng cty GFC lầu 18 Vincom Center quận 1 để ký hợp đồng. Các bạn nhân viên văn phòng ở đây rất dễ thương và mến khách. Mình rất tin tưởng vào dịch vụ bên các bạn cung cấp. Hy vọng nhân viên bảo vệ cũng nhiệt tình như các bạn ở vp. Mong 2 cty hợp tác lâu dài và thành công. Tks all.' ),
			array( '2025/11/feedback-gfc-security-2-150x150.jpg', 'Đông Lý', 'Hệ thống rạp chiếu phim CJ Cinema (Tập đoàn CJ Hàn Quốc) bên mình cũng đang đối tác bên tập đoàn GFC ở các hạng mục Dịch vụ bảo vệ, dịch vụ vệ sinh, dịch vụ diệt côn trùng. Về dịch vụ bảo vệ thấy Nhân viên bảo vệ chuyên nghiệp, tác phong nghiêm túc.' ),
			array( '2025/11/feedback-gfc-security-1-1-150x150.jpg', 'Le Nhanh', 'Tôi hài lòng với thái độ phục vụ và chất lượng dịch vụ của công ty. Tuyệt vời hơn là công ty bảo vệ duy nhất có Bộ phận chăm sóc khách hàng rất bài bản.' ),
			array( '2025/11/feedback-gfc-security-4-150x150.jpg', 'Emm Thư', 'Công ty bảo vệ vệ sĩ chuyên nghiệp, chuyên phục vụ cho các tập đoàn, nhà máy tòa nhà nước ngoài và Việt Nam trên cả nước Việt Nam' ),
		),

		'blog_title'    => 'Chia sẻ kiến thức từ công ty bảo vệ uy tín GFC Security',
		'blog_category' => 'kien-thuc-nganh-bao-ve',
		'blog_slugs'    => array( 'top-15-cong-ty-dich-vu-bao-ve', 'chung-chi-nghiep-vu-bao-ve', 'bao-ve-tuan-tra-giam-sat', 'ca-truong-bao-ve' ),

		'faq_title' => 'Câu hỏi thường gặp về công ty bảo vệ và dịch vụ bảo vệ',
		'faq_image' => gfc_up( '2026/06/Cong-ty-dich-vu-bao-ve-1-scaled.jpg' ),
		'faq' => array(
			array( 'Chi phí thuê dịch vụ bảo vệ được tính như thế nào? Thường có khoảng phí phát sinh nào không?', 'Tuỳ theo nhu cầu cụ thể của khách hàng, công ty bảo vệ chuyên nghiệp uy tín GFC Security có cách tính chi phí khác nhau, chẳng hạn như theo giờ (thường cho các dịch vụ ngắn hạn như bảo vệ sự kiện, bảo vệ cá nhân, vệ sĩ,...) hoặc theo ca, theo tháng (đối với các dịch vụ lâu dài như bảo vệ cửa hàng, bảo vệ ngân hàng, bảo vệ bệnh viện,...). Chúng tôi cam kết mức giá trọn gói đã bao gồm lương, thưởng, bảo hiểm của nhân viên, công cụ hỗ trợ... để khách hàng an tâm không bị "đội chi phí" trong suốt thời gian sử dụng dịch vụ.<p><em>&gt;&gt;&gt; Tham khảo ngay <a href="' . home_url( '/gia-dich-vu-bao-ve' ) . '">bảng báo giá dịch vụ bảo vệ</a> GFC Security.</em></p>' ),
			array( 'Công ty có mua bảo hiểm trách nhiệm pháp lý/bảo hiểm tổn thất không?', 'Với vị thế là một trong những dịch vụ bảo vệ uy tín nhất, GFC Security đã liên kết với các đơn vị bảo hiểm uy tín, cam kết đền bù 100% giá trị thiệt hại theo hợp đồng nếu sự cố xảy ra do lỗi tắc trách của nhân viên bảo vệ. Điều này giúp khách hàng thoát khỏi nỗi lo đơn vị bảo vệ trốn tránh trách nhiệm trong nhiều trường hợp.' ),
			array( 'Trong trường hợp nhân viên bảo vệ đột xuất nghỉ ốm hoặc tự ý bỏ vị trí, công ty bảo vệ xử lý thế nào?', 'Thấu hiểu sự lo lắng về các tính huống bất ngờ, khi mục tiêu bị “bỏ trống” tạo sơ hở cho kẻ gian đột nhập, dịch vụ bảo vệ an ninh GFC Security đã xây dựng đội ngũ cơ động phản ứng nhanh trực chiến 24/7, sẵn sàng thay thế nhân sự mới trong vòng 30 - 60 phút để đảm bảo vị trí luôn có người canh gác. Nhờ đó chúng tôi luôn đảm bảo an ninh cho mục tiêu cần bảo vệ.' ),
			array( 'Quy trình tuyển dụng và đào tạo nhân viên bảo vệ của công ty bảo vệ chuyên nghiệp GFC Security nghiêm ngặt ra sao?', 'Công ty bảo vệ chất lượng cao GFC Security sở hữu quy trình tuyển dụng và đào tạo nhân viên bảo vệ kỹ lưỡng và chặt chẽ. Nhân sự phải có sơ yếu lý lịch rõ ràng, được xác nhận bởi địa phương, cùng với sức khỏe tốt và ngoại hình chỉn chu. Bên cạnh đó, công ty cũng thường xuyên tổ chức các buổi đào tạo và kiểm tra định kỳ để đảm bảo nhân viên bảo vệ luôn có tác phong đúng chuẩn mực và thành thạo các kỹ năng cần thiết như tự vệ, PCCC, sơ cấp cứu, giao tiếp với khách hàng,...<p><em>&gt;&gt;&gt;&gt; Xem chi tiết <a href="' . home_url( '/tieu-chuan-tuyen-chon-va-dao-tao-nhan-vien-bao-ve' ) . '">Tiêu chuẩn tuyển chọn và đào tạo nhân viên bảo vệ của GFC</a>.</em></p>' ),
			array( 'Nếu tôi không hài lòng với thái độ của một nhân viên bảo vệ, tôi có được đổi người không?', 'Khi sử dụng dịch vụ bảo vệ chuyên nghiệp TPHCM GFC Security, khách hàng hoàn toàn có quyền yêu cầu thay thế nhân sự bất cứ lúc nào nếu có lý do chính đáng và bằng chứng về việc nhân viên bảo vệ vi phạm tác phong, có thái độ không tốt, không đáp ứng được tiêu chuẩn nghiệp vụ,... hoàn toàn miễn phí.' ),
			array( 'Công ty bảo vệ chuyên nghiệp GFC Security có cung cấp và trang bị các công cụ hỗ trợ cho bảo vệ không?', 'Tùy theo nhu cầu và gói dịch vụ bảo vệ mà khách hàng lựa chọn, công ty bảo vệ dịch vụ GFC Security sẽ chủ động trang bị công cụ và thiết bị hỗ trợ tương ứng cho nhân viên bảo vệ, vệ sĩ (chi phí này đã bao gồm trong báo giá ban đầu, không phát sinh thêm).<br>- Với các dịch vụ thông thường, chúng tôi sẽ cung cấp các dụng cụ cơ bản như gậy cao su, đèn pin chuyên dụng, bộ đàm, sổ nhật ký tuần tra,...<br>- Đối với các dịch vụ có yêu cầu cao hơn sẽ được bổ sung các thiết bị hiện đại như máy tuần tra, áo giáp, dùi cui điện, bình xịt hơi cay, hệ thống cảnh báo thông minh, phần mềm quản lý bảo vệ,...' ),
			array( 'Công ty dịch vụ bảo vệ uy tín GFC Security có hỗ trợ khảo sát mục tiêu và lập phương án an ninh trước khi ký hợp đồng không?', 'Khảo sát mục tiêu và lập phương án an ninh riêng cho mục tiêu là quy trình bắt buộc và hoàn toàn miễn phí của GFC Security khi cung cấp dịch vụ bảo vệ. Đội ngũ kỹ thuật của chúng tôi sẽ đến thực địa để nắm bắt tình hình cụ thể, từ đó lên phương án bố trí sơ đồ an ninh và tư vấn các giải pháp bảo vệ phù hợp nhất.' ),
			array( 'Công ty bảo vệ 24/24H GFC Security quản lý và giám sát nhân viên bảo vệ tại mục tiêu bằng cách nào?', 'Dịch vụ bảo vệ uy tín tại TPHCM GFC Security triển khai ứng dụng điện thoại Smart Guard giúp khách hàng có thể kiểm tra công việc của nhân viên bảo vệ tại mục tiêu theo thời gian thực mọi lúc mọi nơi. Ngoài ra, mỗi đội bảo vệ tại mục tiêu đều có đội trưởng giám sát trực tiếp qua camera/máy tuần tra định vị GPS, theo dõi báo cáo hàng ngày và đội cơ động tuần tra đột xuất không báo trước để đảm bảo chất lượng dịch vụ.' ),
			array( 'Nhân viên bảo vệ có năng lực xử lý các tình huống khẩn cấp như cháy nổ, ẩu đả không?', '100% nhân viên an ninh của công ty bảo vệ chuyên nghiệp uy tín giá rẻ GFC Security đều có kỹ năng tốt để xử lý các tình huống khẩn cấp. Ngoài tiêu chuẩn tuyển dụng yêu cầu kỹ năng và kinh nghiệm ban đầu, các khóa huấn luyện định kỳ của chúng tôi đều giúp nhân viên bảo vệ nắm chắc các kỹ năng chữa cháy, sơ tán, khống chế đối tượng quá khích và phối hợp nhanh với công an địa phương,...' ),
			array( 'Hợp đồng dịch vụ bảo vệ tối thiểu là bao lâu? Có cung cấp dịch vụ ngắn hạn không?', 'Nếu bạn đang tìm dịch vụ bảo vệ có các gói linh hoạt, GFC Security sẽ là lựa chọn phù hợp. Chúng tôi sẵn sàng cung cấp cả dịch vụ bảo vệ dài hạn (theo năm, theo tháng cho các mục tiêu cố định) lẫn dịch vụ bảo vệ ngắn hạn (sự kiện, áp tải hàng hoá, vệ sĩ,... theo ngày, theo giờ) tùy theo nhu cầu thực tế của khách hàng.' ),
		),
	);
}

/** Văn phòng & chi nhánh (dùng khi chưa nhập mục "Chi nhánh" trong admin). */
function gfc_default_branches() {
	return array(
		array( 'Dịch vụ bảo vệ Trà Vinh', '17/7 Tô Thị Huỳnh, P. Trà Vinh, tỉnh Vĩnh Long' ),
		array( 'Công ty bảo vệ Long An', '24/8 Nguyễn Trung Trực, xã Bến Lức, tỉnh Tây Ninh (Long An cũ)' ),
		array( 'Dịch vụ bảo vệ Hậu Giang', '7 Đoàn Văn Chia, P. Ngã Bảy, TP. Cần Thơ' ),
		array( 'Công ty bảo vệ Đắk Nông', 'Xã Nam Dong, tỉnh Lâm Đồng' ),
		array( 'Dịch vụ bảo vệ Bình Phước', '86 Lê Lợi, P. Bình Phước, tỉnh Đồng Nai (Bình Phước cũ)' ),
		array( 'Công ty bảo vệ Bình Dương', 'Lô 5C25 , Đường DA2, P. Thới Hoà, TP. HCM (Bình Dương cũ)' ),
		array( 'Công ty bảo vệ Bến Tre', '197 Phan Đình Phùng, P. Phú Khương, tỉnh Vĩnh Long (Bến Tre cũ)' ),
		array( 'Dịch vụ bảo vệ Tuyên Quang', 'Đồng Lem, P. An Tường, tỉnh Tuyên Quang' ),
		array( 'Công ty bảo vệ Cao Bằng', 'Ngõ 95 Hoàng Như, P. Thục Phán, tỉnh Cao Bằng' ),
		array( 'Dịch vụ bảo vệ Lạng Sơn', '336 Chu Văn An, P. Đông Kinh, tỉnh Lạng Sơn' ),
		array( 'Công ty bảo vệ Bắc Kạn', 'Số nhà 297, tổ 4, P. Đức Xuân, tỉnh Thái Nguyên' ),
		array( 'Dịch vụ bảo vệ Hà Giang', 'Tổ 7, P. Hà Giang 2, tỉnh Tuyên Quang' ),
	);
}

/** Trụ sở và 2 chi nhánh chính. */
function gfc_offices() {
	return array(
		array( 'Trụ sở Thành phố Hồ Chí Minh', '103 Đào Duy Anh, Phường Đức Nhuận, Thành phố Hồ Chí Minh, Việt Nam', '(028) 44550 247' ),
		array( 'Chi nhánh Hà Nội', 'Tầng 12, Licogi 13 Tower, 164 Khuất Duy Tiến, phường Thanh Xuân, Hà Nội', '(024) 44550 247' ),
		array( 'Chi nhánh Đà Nẵng', '232 Đường 2/9, phường Hòa Cường, TP. Đà Nẵng', '(0236) 44550 247' ),
	);
}
