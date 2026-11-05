<?php
/**
 * Khung nội dung cho mẫu "Trang dịch vụ GFC":
 * Banner → Bảng giá → Lợi thế → Nhiệm vụ → Quy trình → Tiêu chuẩn → Nội dung bài viết.
 * Mỗi khối để trống sẽ tự ẩn.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GFC_SERVICE_TPL', 'page-templates/template-service.php' );

function gfc_service_fields() {
	return array(
		'hero_title'    => array( 'Banner — tiêu đề (trống = dùng tiêu đề bài)', 'text' ),
		'hero_desc'     => array( 'Banner — đoạn mô tả', 'textarea' ),
		'hero_image'    => array( 'Banner — ảnh bên phải, nên dùng 1200 × 860 px (trống = dùng Ảnh đại diện)', 'image' ),
		'price_title'   => array( 'Bảng giá — tiêu đề', 'text' ),
		'price_html'    => array( 'Bảng giá — nội dung HTML (có nội dung thì thay cho các ô bảng giá bên dưới)', 'html' ),
		'price_head'    => array( 'Bảng giá — tiêu đề 2 cột (cách nhau bằng |)', 'text' ),
		'price_rows'    => array( 'Bảng giá — mỗi dòng: Loại dịch vụ | Giá', 'textarea' ),
		'price_notes'   => array( 'Bảng giá — lưu ý (mỗi dòng một ý)', 'textarea' ),
		'extra_title'   => array( 'Dịch vụ con — tiêu đề', 'text' ),
		'extra_items'   => array( 'Dịch vụ con — mỗi dòng: Tên | URL | Ảnh', 'textarea' ),
		'adv_title'     => array( 'Lợi thế — tiêu đề', 'text' ),
		'adv_image'     => array( 'Lợi thế — ảnh infographic, nên rộng 1200 px', 'image' ),
		'adv_image_m'   => array( 'Lợi thế — ảnh infographic trên mobile, nên rộng 800 px', 'image' ),
		'tasks_title'   => array( 'Nhiệm vụ — tiêu đề', 'text' ),
		'tasks'         => array( 'Nhiệm vụ — mỗi dòng: Tiêu đề | Mô tả', 'textarea' ),
		'tasks_img1'    => array( 'Nhiệm vụ — ảnh lớn, nên dùng 900 × 1020 px', 'image' ),
		'tasks_img2'    => array( 'Nhiệm vụ — ảnh nhỏ, nên dùng 850 × 964 px', 'image' ),
		'process_title' => array( 'Quy trình — tiêu đề', 'text' ),
		'process_desc'  => array( 'Quy trình — mô tả', 'textarea' ),
		'process_image' => array( 'Quy trình — ảnh infographic, nên rộng 1200 px', 'image' ),
		'process_image_m' => array( 'Quy trình — ảnh infographic trên mobile, nên rộng 800 px', 'image' ),
		'std_title'     => array( 'Tiêu chuẩn — tiêu đề', 'text' ),
		'std_desc'      => array( 'Tiêu chuẩn — mô tả', 'textarea' ),
		'std_link_text' => array( 'Tiêu chuẩn — chữ liên kết', 'text' ),
		'std_link_url'  => array( 'Tiêu chuẩn — URL liên kết', 'text' ),
	);
}

function gfc_smeta( $key, $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return (string) get_post_meta( $post_id, '_gfc_' . $key, true );
}

/** Ảnh infographic: có ảnh mobile thì dùng <picture> để đổi theo màn hình. */
function gfc_infographic( $desktop, $mobile, $alt ) {
	$img = '<img class="gfc-infographic" src="' . esc_url( gfc_link( $desktop ) ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">';
	if ( $mobile ) {
		$img = '<picture><source media="(max-width: 1023px)" srcset="' . esc_url( gfc_link( $mobile ) ) . '">' . $img . '</picture>';
	}
	echo $img; // phpcs:ignore -- escaped above
}

/** Bài viết có dữ liệu khung dịch vụ thì dùng mẫu "Trang dịch vụ GFC" thay cho single.php. */
add_filter( 'single_template', function ( $template ) {
	if ( is_singular( 'post' ) && gfc_smeta( 'hero_title', get_queried_object_id() ) ) {
		return GFC_PATH . '/' . GFC_SERVICE_TPL;
	}
	return $template;
} );

/** Tách textarea "A | B" thành mảng */
function gfc_lines( $text, $cols = 2 ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) continue;
		$parts = array_map( 'trim', explode( '|', $line, $cols ) );
		$out[] = array_pad( $parts, $cols, '' );
	}
	return $out;
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'gfc_service_box', 'Nội dung trang dịch vụ (Banner, Bảng giá, Nhiệm vụ, Quy trình, Tiêu chuẩn)', 'gfc_service_box', array( 'page', 'post' ), 'normal', 'high' );
} );

function gfc_service_box( $post ) {
	wp_nonce_field( 'gfc_service_save', 'gfc_service_nonce' );
	echo '<style>.gfc-mb p{margin:0 0 14px}.gfc-mb label{font-weight:600;display:block;margin-bottom:4px}.gfc-mb .gfc-img{display:flex;gap:8px}.gfc-mb .gfc-img input{flex:1}.gfc-mb hr{margin:18px 0}</style><div class="gfc-mb">';
	echo '<p class="description">Với bài viết: điền "Banner — tiêu đề" thì bài hiển thị theo khung trang dịch vụ. Khối nào để trống sẽ tự ẩn. Bài viết chi tiết bên dưới cùng nhập ở trình soạn thảo như bình thường.</p>';
	foreach ( gfc_service_fields() as $key => $f ) {
		$val  = get_post_meta( $post->ID, '_gfc_' . $key, true );
		$name = 'gfc_s[' . $key . ']';
		if ( in_array( $key, array( 'price_title', 'adv_title', 'tasks_title', 'process_title', 'std_title' ), true ) ) echo '<hr>';
		echo '<p><label>' . esc_html( $f[0] ) . '</label>';
		if ( 'textarea' === $f[1] || 'html' === $f[1] ) {
			echo '<textarea class="widefat" rows="4" name="' . esc_attr( $name ) . '">' . esc_textarea( $val ) . '</textarea>';
		} elseif ( 'image' === $f[1] ) {
			echo '<span class="gfc-img"><input type="text" class="widefat" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '" placeholder="URL ảnh"><button type="button" class="button gfc-pick">Chọn ảnh</button></span>';
		} else {
			echo '<input type="text" class="widefat" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '">';
		}
		echo '</p>';
	}
	echo '</div>';
	?>
	<script>
	jQuery(function($){
		$(document).on('click','.gfc-pick',function(e){
			e.preventDefault(); var input=$(this).prev('input');
			var f=wp.media({title:'Chọn ảnh',multiple:false,library:{type:'image'}});
			f.on('select',function(){input.val(f.state().get('selection').first().toJSON().url);}); f.open();
		});
	});
	</script>
	<?php
}

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( 'post.php' === $hook || 'post-new.php' === $hook ) wp_enqueue_media();
} );

$gfc_save_service = function ( $post_id ) {
	if ( ! isset( $_POST['gfc_service_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gfc_service_nonce'] ) ), 'gfc_service_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	$in = isset( $_POST['gfc_s'] ) && is_array( $_POST['gfc_s'] ) ? wp_unslash( $_POST['gfc_s'] ) : array(); // phpcs:ignore -- sanitized per field below
	foreach ( gfc_service_fields() as $key => $f ) {
		$v = isset( $in[ $key ] ) ? $in[ $key ] : '';
		if ( 'image' === $f[1] || 'std_link_url' === $key ) {
			$v = ( 0 === strpos( trim( $v ), '/' ) ) ? sanitize_text_field( $v ) : esc_url_raw( $v );
		} elseif ( 'html' === $f[1] ) {
			$v = wp_kses_post( $v );
		} elseif ( 'textarea' === $f[1] ) {
			$v = sanitize_textarea_field( $v );
		} else {
			$v = sanitize_text_field( $v );
		}
		update_post_meta( $post_id, '_gfc_' . $key, $v );
	}
};
add_action( 'save_post_page', $gfc_save_service );
add_action( 'save_post_post', $gfc_save_service );

/**
 * Lần đầu kích hoạt theme: nếu có trang /bao-ve-ngan-hang và chưa có dữ liệu,
 * điền sẵn nội dung mẫu (giống trang hiện tại) và gán mẫu "Trang dịch vụ GFC".
 */
add_action( 'after_switch_theme', function () {
	$page = get_page_by_path( 'bao-ve-ngan-hang' );
	if ( ! $page || get_post_meta( $page->ID, '_gfc_hero_desc', true ) ) return;
	$sample = array(
		'hero_desc'     => 'Dịch vụ bảo vệ ngân hàng GFC Security được triển khai theo quy chuẩn an ninh nghiêm ngặt, hướng tới mục tiêu bảo vệ tuyệt đối con người, tài sản và mọi hoạt động giao dịch. Đội ngũ bảo vệ được huấn luyện chuyên sâu, phối hợp cùng hệ thống giám sát 24/7, giúp duy trì môi trường ngân hàng an toàn, ổn định và đáng tin cậy cho khách hàng lẫn nhân viên.',
		'hero_image'    => gfc_up( '2025/11/dich-vu-bao-ve-ngan-hang-banner.jpg' ),
		'price_title'   => 'Bảng giá dịch vụ bảo vệ ngân hàng',
		'price_head'    => 'Loại dịch vụ | Bảng giá (VNĐ)',
		'price_rows'    => "Theo giờ (1 vị trí/1 người) | 25.000 – 50.000\nTheo tháng 24/24 (1 vị trí/2 bảo vệ chia ca) | 17.000.000 – 25.000.000",
		'price_notes'   => "Bảng giá trên đã gồm VAT theo quy định của nhà nước\nBảng giá chưa bao gồm chi phí cho các ngày Lễ, Tết\nChi phí có thể thay đổi theo yêu cầu cụ thể của quý khách, vui lòng liên hệ trực tiếp với GFC Security theo hotline 0778247113 để có bảng giá chính xác nhất",
		'adv_title'     => 'Lợi thế vượt trội của dịch vụ bảo vệ ngân hàng GFC Security',
		'adv_image'     => gfc_up( '2025/11/loi-the-d.svg' ),
		'tasks_title'   => 'Nhiệm vụ của nhân viên bảo vệ ngân hàng GFC Security',
		'tasks'         => "Duy trì an ninh toàn diện | Duy trì trật tự, bảo đảm an toàn tuyệt đối cho nhân viên, khách hàng và tài sản trong toàn khu vực ngân hàng, đặc biệt là quầy giao dịch, khu vực két sắt, ATM,...\nKiểm soát ra vào nghiêm ngặt | Kiểm soát người và phương tiện ra vào, ngăn chặn các hành vi xâm nhập, quấy rối hoặc gây mất an ninh.\nPhát hiện và xử lý đối tượng khả nghi | Nhận diện sớm các đối tượng khả nghi giả dạng khách hàng và phản ứng nhanh với các tình huống móc túi, trộm cắp trong sảnh giao dịch hoặc cướp ngân hàng\nHỗ trợ khách rút tiền an toàn | Chú ý quan sát và hỗ trợ khách hàng thực hiện giao dịch rút tiền lớn, bảo vệ an toàn khi họ di chuyển ra xe.\nQuản lý khu vực gửi xe | Hướng dẫn, trông giữ và dắt xe cho khách hàng, đảm bảo khu vực đỗ xe trật tự, an toàn và thuận tiện cho việc ra vào.\nỨng phó khẩn cấp và phối hợp nghiệp vụ | Ứng phó nhanh với các tình huống khẩn cấp và phối hợp kịp thời với lực lượng phản ứng nhanh để bảo vệ an toàn tuyệt đối cho người và tài sản.",
		'tasks_img1'    => gfc_up( '2025/10/dich-vu-bao-ve-gfc-security-2.jpg' ),
		'tasks_img2'    => gfc_up( '2025/10/dich-vu-bao-ve-gfc-security-1.jpg' ),
		'process_title' => 'Quy trình triển khai dịch vụ bảo vệ ngân hàng GFC Security',
		'process_desc'  => 'Quy trình triển khai dịch vụ bảo vệ GFC Security được thiết kế để xây dựng một hệ thống an ninh khép kín, tối ưu hóa sự an toàn cho tài sản và mọi người.',
		'process_image' => gfc_up( '2025/11/quy-trinh-d.svg' ),
		'std_title'     => 'Tiêu chuẩn tuyển chọn và đào tạo nhân viên bảo vệ ngân hàng',
		'std_desc'      => 'GFC Security chú trọng ngay từ khâu tuyển dụng và đào tạo bài bản để đảm bảo đội ngũ nhân lực có thể phục vụ khách hàng tốt nhất.',
		'std_link_text' => 'Xem chi tiết về tiêu chuẩn tuyển chọn và đào tạo của chúng tôi',
		'std_link_url'  => '/tieu-chuan-tuyen-chon-va-dao-tao-nhan-vien-bao-ve',
	);
	foreach ( $sample as $k => $v ) update_post_meta( $page->ID, '_gfc_' . $k, $v );
	update_post_meta( $page->ID, '_wp_page_template', GFC_SERVICE_TPL );
} );

/* Ảnh đại diện bài viết, trang: nhắc kích thước ngay trong ô chọn ảnh */
add_filter( 'admin_post_thumbnail_html', function ( $html ) {
	return $html . '<p class="description">Nên dùng ảnh 1200 × 675 px.</p>';
} );
add_action( 'enqueue_block_editor_assets', function () {
	wp_register_script( 'gfc-thumb-hint', false, array( 'wp-hooks', 'wp-element' ), GFC_VERSION, true );
	wp_enqueue_script( 'gfc-thumb-hint' );
	wp_add_inline_script( 'gfc-thumb-hint', "wp.hooks.addFilter('editor.PostFeaturedImage','gfc/thumb-hint',function(Orig){return function(p){var e=wp.element.createElement;return e(wp.element.Fragment,null,e(Orig,p),e('p',{className:'description gfc-thumb-hint'},'Nên dùng ảnh 1200 × 675 px.'))}});" );
} );
