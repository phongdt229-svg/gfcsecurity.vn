<?php
/**
 * Menu mặc định (giống website hiện tại) — dùng khi chưa gán menu trong Giao diện → Menu.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_default_menu() {
	return array(
		array( 'Về GFC Security', '/gioi-thieu-gfc-security' ),
		array( 'Dịch vụ', '/dich-vu-gfc', array(
			array( 'Bảo vệ mục tiêu cố định', '/bao-ve-muc-tieu-co-dinh', array(
				array( 'Bảo vệ trường học', '/bao-ve-truong-hoc' ),
				array( 'Bảo vệ khu công nghiệp', '/bao-ve-khu-cong-nghiep' ),
				array( 'Bảo vệ nhà máy – xí nghiệp', '/dich-vu-bao-ve-nha-may' ),
				array( 'Bảo vệ công trường', '/bao-ve-cong-truong' ),
				array( 'Bảo vệ giữ xe', '/bang-gia-thue-bao-ve-giu-xe' ),
				array( 'Bảo vệ ngân hàng', '/bao-ve-ngan-hang' ),
				array( 'Bảo vệ công ty – văn phòng', '/dich-vu-bao-ve-cong-ty-van-phong' ),
				array( 'Bảo vệ chung cư', '/bao-ve-toa-nha-chung-cu' ),
				array( 'Bảo vệ nhà hàng – khách sạn', '/bao-ve-nha-hang-khach-san' ),
				array( 'Bảo vệ kho hàng', '/dich-vu-bao-ve-kho-hang' ),
			) ),
			array( 'Bảo vệ mục tiêu di động', '/bao-ve-muc-tieu-di-dong', array(
				array( 'Vệ sĩ cá nhân', '/dich-vu-ve-si-ca-nhan' ),
				array( 'Bảo vệ yếu nhân – nhân vật VIP', '/bao-ve-yeu-nhan-nhan-vat-vip' ),
				array( 'Bảo vệ áp tải hàng hoá', '/bao-ve-ap-tai-hang-hoa' ),
			) ),
			array( 'Bảo vệ sự kiện – hội nghị', '/bao-ve-su-kien-event' ),
			array( 'Bảng giá thuê bảo vệ', '/gia-dich-vu-bao-ve' ),
		) ),
		array( 'Tin tức', '/tin-tuc', array(
			array( 'Bảo vệ TPHCM', '/tin-tuc/bao-ve-tphcm' ),
			array( 'Bảo vệ miền Nam', '/tin-tuc/bao-ve-mien-nam' ),
			array( 'Bảo vệ miền Trung', '/tin-tuc/bao-ve-mien-trung' ),
			array( 'Bảo vệ miền Bắc', '/tin-tuc/bao-ve-mien-bac' ),
			array( 'Kiến thức ngành bảo vệ', '/tin-tuc/kien-thuc-nganh-bao-ve' ),
		) ),
		array( 'Tuyển dụng', '#', array(
			array( 'Tin tuyển dụng', '/tin-tuc/tuyen-dung' ),
			array( 'Quyền lợi và chế độ đãi ngộ', '/quyen-loi-va-che-do-dai-ngo' ),
			array( 'Câu hỏi thường gặp', '/cau-hoi-thuong-gap' ),
		) ),
		array( 'Liên hệ', '/lien-he' ),
		array( 'Hồ sơ năng lực', '/ho-so-nang-luc' ),
	);
}

function gfc_footer_services_default() {
	return array(
		array( 'Bảo vệ nhà máy - xí nghiệp', '/dich-vu-bao-ve-nha-may' ),
		array( 'Bảo vệ chung cư', '/bao-ve-toa-nha-chung-cu' ),
		array( 'Bảo vệ công ty - văn phòng', '/dich-vu-bao-ve-cong-ty-van-phong' ),
		array( 'Bảo vệ nhà hàng - khách sạn', '/bao-ve-nha-hang-khach-san' ),
		array( 'Bảo vệ trường học', '/bao-ve-truong-hoc' ),
		array( 'Bảo vệ ngân hàng', '/bao-ve-ngan-hang' ),
		array( 'Bảo vệ siêu thị - trung tâm thương mại', '/bao-ve-sieu-thi-trung-tam-thuong-mai' ),
		array( 'Bảo vệ khu công nghiệp', '/bao-ve-khu-cong-nghiep' ),
		array( 'Bảo vệ nhà riêng', '/bao-ve-nha-rieng' ),
		array( 'Bảo vệ công trường', '/bao-ve-cong-truong' ),
		array( 'Bảo vệ giữ xe', '/bang-gia-thue-bao-ve-giu-xe' ),
		array( 'Bảo vệ yếu nhân - nhân vật VIP', '/bao-ve-yeu-nhan-nhan-vat-vip' ),
		array( 'Vệ sĩ cá nhân', '/dich-vu-ve-si-ca-nhan' ),
		array( 'Bảo vệ áp tải hàng hoá', '/bao-ve-ap-tai-hang-hoa' ),
		array( 'Bảo vệ sự kiện - event', '/bao-ve-su-kien-event' ),
	);
}

function gfc_sidebar_services_default() {
	return array(
		array( 'Bảo vệ nhà máy - xí nghiệp', '/dich-vu-bao-ve-nha-may' ),
		array( 'Bảo vệ chung cư', '/bao-ve-toa-nha-chung-cu' ),
		array( 'Bảo vệ công ty - văn phòng', '/dich-vu-bao-ve-cong-ty-van-phong' ),
		array( 'Bảo vệ nhà hàng - khách sạn', '/bao-ve-nha-hang-khach-san' ),
		array( 'Bảo vệ trường học', '/bao-ve-truong-hoc' ),
		array( 'Bảo vệ bệnh viện', '/dich-vu-bao-ve-benh-vien' ),
		array( 'Bảo vệ ngân hàng', '/bao-ve-ngan-hang' ),
		array( 'Bảo vệ siêu thị - trung tâm thương mại', '/bao-ve-sieu-thi-trung-tam-thuong-mai' ),
		array( 'Bảo vệ kho hàng', '/dich-vu-bao-ve-kho-hang' ),
		array( 'Bảo vệ cửa hàng - quán xá - siêu thị mini', '/bao-ve-cua-hang' ),
		array( 'Bảo vệ khu công nghiệp', '/bao-ve-khu-cong-nghiep' ),
		array( 'Bảo vệ toà nhà', '/dich-vu-bao-ve-toa-nha' ),
		array( 'Bảo vệ nhà riêng', '/bao-ve-nha-rieng' ),
		array( 'Bảo vệ công trường', '/bao-ve-cong-truong' ),
		array( 'Bảo vệ giữ xe', '/bang-gia-thue-bao-ve-giu-xe' ),
		array( 'Bảo vệ yếu nhân - nhân vật VIP', '/bao-ve-yeu-nhan-nhan-vat-vip' ),
		array( 'Vệ sĩ cá nhân', '/dich-vu-ve-si-ca-nhan' ),
		array( 'Bảo vệ áp tải hàng hoá', '/bao-ve-ap-tai-hang-hoa' ),
		array( 'Bảo vệ sự kiện - hội nghị', '/bao-ve-su-kien-event' ),
	);
}

function gfc_footer_support_default() {
	return array(
		array( 'Giới thiệu', '/gioi-thieu-gfc-security' ),
		array( 'Tin tức', '/tin-tuc' ),
		array( 'Liên hệ', '/lien-he' ),
		array( 'Tuyển dụng', '/tin-tuc/tuyen-dung' ),
		array( 'Chính sách bảo mật thông tin', '/chinh-sach-bao-mat' ),
	);
}

/** Render cây menu mặc định */
function gfc_render_menu_items( $items, $depth = 0 ) {
	$html = '';
	foreach ( $items as $it ) {
		$has = ! empty( $it[2] );
		$html .= '<li class="menu-item' . ( $has ? ' menu-item-has-children' : '' ) . '">';
		$html .= '<a href="' . esc_url( gfc_link( $it[1] ) ) . '">' . esc_html( $it[0] ) . '</a>';
		if ( $has ) {
			$html .= '<button class="sub-toggle" type="button" aria-label="Mở menu con">' . gfc_icon( 'chevron' ) . '</button>';
			$html .= '<ul class="sub-menu">' . gfc_render_menu_items( $it[2], $depth + 1 ) . '</ul>';
		}
		$html .= '</li>';
	}
	return $html;
}

function gfc_primary_menu() {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'gfc-menu',
			'depth'          => 3,
			'walker'         => new GFC_Menu_Walker(),
		) );
		return;
	}
	echo '<ul class="gfc-menu">' . gfc_render_menu_items( gfc_default_menu() ) . '</ul>'; // phpcs:ignore -- escaped inside
}

function gfc_simple_menu( $location, $defaults ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu( array( 'theme_location' => $location, 'container' => false, 'menu_class' => 'gfc-flinks', 'depth' => 1 ) );
		return;
	}
	echo '<ul class="gfc-flinks">';
	foreach ( $defaults as $it ) {
		echo '<li><a href="' . esc_url( gfc_link( $it[1] ) ) . '">' . esc_html( $it[0] ) . '</a></li>';
	}
	echo '</ul>';
}

/** Walker thêm nút mở menu con cho mobile */
class GFC_Menu_Walker extends Walker_Nav_Menu {
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<button class="sub-toggle" type="button" aria-label="Mở menu con">' . gfc_icon( 'chevron' ) . '</button><ul class="sub-menu">';
	}
}
