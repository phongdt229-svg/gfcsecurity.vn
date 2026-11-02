<?php
/** Giao diện → Tuỳ biến → "Thông tin liên hệ GFC" */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_opt_defaults() {
	return array(
		'switchboard' => '1900 3014',
		'hotline1'    => '0778.247.113',
		'hotline2'    => '0328.898.113',
		'sidebar_hotline' => '08 12345 247',
		'email'       => 'BaoVe@gfcsecurity.vn',
		'tax'         => '0311748278',
		'zalo'        => 'https://zalo.me/0778247113',
		'facebook'    => 'https://www.facebook.com/baovegfc',
		'youtube'     => '',
		'profile_url' => 'https://drive.google.com/file/d/1LSoDN_yA28wqBYLXKYUBuccjL46H5zPJ/view',
		'hire_url'    => '/lien-he',
		'jobs_url'    => '/tin-tuc/tuyen-dung',
		'cf7_id'      => '6434',
		'map_query'   => 'Vincom Center, 72 Lê Thánh Tôn, Sài Gòn',
		'copyright'   => '© 2025 CÔNG TY CP TẬP ĐOÀN AN NINH BẢO VỆ GFC Inc. All Rights Reserved.',
	);
}

function gfc_opt( $key ) {
	$d = gfc_opt_defaults();
	$v = get_theme_mod( 'gfc_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	return is_string( $v ) ? $v : '';
}

/** URL tương đối (/lien-he) → tuyệt đối */
function gfc_link( $url ) {
	if ( '' === $url ) return '';
	return ( 0 === strpos( $url, '/' ) ) ? home_url( $url ) : $url;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'gfc_contact', array(
		'title'    => 'Thông tin liên hệ GFC',
		'priority' => 30,
	) );
	$labels = array(
		'switchboard' => 'Tổng đài toàn quốc',
		'hotline1'    => 'Hotline 24/7 (1)',
		'hotline2'    => 'Hotline 24/7 (2)',
		'sidebar_hotline' => 'Số điện thoại ở banner cột phải bài viết',
		'email'       => 'Email',
		'tax'         => 'Mã số thuế',
		'zalo'        => 'Link Zalo',
		'facebook'    => 'Link Facebook',
		'youtube'     => 'Link YouTube',
		'profile_url' => 'Link Hồ sơ năng lực',
		'hire_url'    => 'Link nút "Thuê bảo vệ"',
		'jobs_url'    => 'Link nút "Tìm việc bảo vệ"',
		'cf7_id'      => 'ID form Contact Form 7 (trang Liên hệ)',
		'map_query'   => 'Địa chỉ hiển thị bản đồ Google (trang Liên hệ)',
		'copyright'   => 'Dòng bản quyền chân trang',
	);
	foreach ( gfc_opt_defaults() as $key => $default ) {
		$wp_customize->add_setting( 'gfc_' . $key, array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'gfc_' . $key, array(
			'label'   => isset( $labels[ $key ] ) ? $labels[ $key ] : $key,
			'section' => 'gfc_contact',
			'type'    => 'text',
		) );
	}
} );
