<?php
/** Giao diện → Tuỳ biến → "Thông tin công ty" (footer, trang Liên hệ, nút liên hệ nổi, cột phải bài viết). */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_opt_defaults() {
	return array(
		'company_name'    => 'CÔNG TY CỔ PHẦN DỊCH VỤ BẢO VỆ LONG VÂN',
		'tax'             => '0309390411',
		'email'           => 'duckhienbp@gmail.com',
		'switchboard'     => '0903.665.955',
		'hotline1'        => '0903.665.955',
		'hotline2'        => '',
		'hire_phone'      => '0903665955',
		'jobs_phone'      => '0903665955',
		'sidebar_hotline' => '0903.665.955',
		'office1_name'    => 'Trụ sở TP Hồ Chí Minh',
		'office1_address' => '103 Đào Duy Anh, Phường Đức Nhuận, Thành phố Hồ Chí Minh, Việt Nam',
		'office1_phone'   => '0903.665.955',
		'office2_name'    => 'Chi nhánh Hà Nội',
		'office2_address' => 'Tầng 12, Licogi 13 Tower, 164 Khuất Duy Tiến, phường Thanh Xuân, Hà Nội',
		'office2_phone'   => '0903.665.955',
		'office3_name'    => 'Chi nhánh Đà Nẵng',
		'office3_address' => '232 Đường 2/9, phường Hòa Cường, TP. Đà Nẵng',
		'office3_phone'   => '0903.665.955',
		'zalo'            => 'https://zalo.me/0903665955',
		'facebook'        => '',
		'youtube'         => '',
		'profile_url'     => '',
		'copyright'       => '© 2025 CÔNG TY CỔ PHẦN DỊCH VỤ BẢO VỆ LONG VÂN. All Rights Reserved.',
		'show_badges'     => '',
		'show_ecosystem'  => '',
		'cf7_id'          => '6434',
	);
}

function gfc_opt( $key ) {
	$d = gfc_opt_defaults();
	$v = get_theme_mod( 'gfc_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	return is_scalar( $v ) ? (string) $v : '';
}

/** URL tương đối (/lien-he) → tuyệt đối */
function gfc_link( $url ) {
	if ( '' === $url ) return '';
	return ( 0 === strpos( $url, '/' ) ) ? home_url( $url ) : $url;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'gfc_contact', array(
		'title'       => 'Thông tin công ty',
		'description' => 'Hiển thị ở footer, trang Liên hệ, nút liên hệ nổi và cột phải bài viết. Để trống một ô thì dòng đó tự ẩn.',
		'priority'    => 30,
	) );
	$labels = array(
		'company_name'    => 'Tên công ty',
		'tax'             => 'Mã số thuế',
		'email'           => 'Email',
		'switchboard'     => 'Tổng đài toàn quốc',
		'hotline1'        => 'Hotline 24/7 (1)',
		'hotline2'        => 'Hotline 24/7 (2)',
		'hire_phone'      => 'Số của nút "Thuê bảo vệ"',
		'jobs_phone'      => 'Số của nút "Tìm việc bảo vệ"',
		'sidebar_hotline' => 'Số trên banner cột phải bài viết',
		'office1_name'    => 'Trụ sở — tên',
		'office1_address' => 'Trụ sở — địa chỉ',
		'office1_phone'   => 'Trụ sở — điện thoại',
		'office2_name'    => 'Chi nhánh 2 — tên',
		'office2_address' => 'Chi nhánh 2 — địa chỉ (trống = ẩn chi nhánh)',
		'office2_phone'   => 'Chi nhánh 2 — điện thoại',
		'office3_name'    => 'Chi nhánh 3 — tên',
		'office3_address' => 'Chi nhánh 3 — địa chỉ (trống = ẩn chi nhánh)',
		'office3_phone'   => 'Chi nhánh 3 — điện thoại',
		'zalo'            => 'Link Zalo',
		'facebook'        => 'Link Facebook',
		'youtube'         => 'Link YouTube',
		'profile_url'     => 'Link Hồ sơ năng lực (trống = ẩn nút trên trang chủ)',
		'copyright'       => 'Dòng bản quyền chân trang',
		'show_badges'     => 'Hiện huy hiệu DMCA và Bộ Công Thương ở footer',
		'show_ecosystem'  => 'Hiện khối "Hệ sinh thái" và "Thành viên của" ở footer',
		'cf7_id'          => 'ID form Contact Form 7 (trang Liên hệ)',
	);
	foreach ( gfc_opt_defaults() as $key => $default ) {
		$is_check = 0 === strpos( $key, 'show_' );
		$wp_customize->add_setting( 'gfc_' . $key, array(
			'default'           => $default,
			'sanitize_callback' => $is_check ? function ( $v ) { return $v ? '1' : ''; } : 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'gfc_' . $key, array(
			'label'   => isset( $labels[ $key ] ) ? $labels[ $key ] : $key,
			'section' => 'gfc_contact',
			'type'    => $is_check ? 'checkbox' : 'text',
		) );
	}
} );

/* Lối tắt trong menu admin */
add_action( 'admin_menu', function () {
	add_menu_page( 'Thông tin công ty', 'Thông tin công ty', 'edit_theme_options', 'customize.php?autofocus%5Bsection%5D=gfc_contact', '', 'dashicons-building', 3 );
} );
