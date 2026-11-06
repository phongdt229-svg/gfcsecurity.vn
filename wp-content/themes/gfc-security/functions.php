<?php
/**
 * GFC Security theme
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GFC_VERSION', '1.2.9' );
/* Màu thương hiệu theo logo Long Vân (#C4985A), sẫm hơn để chữ đủ tương phản trên nền trắng */
define( 'GFC_COLOR_PRIMARY', '#96702f' );
define( 'GFC_COLOR_ACCENT', '#c9a055' );
define( 'GFC_COLOR_TINT', '#f8f2e8' );
define( 'GFC_PATH', get_template_directory() );
define( 'GFC_URL', get_template_directory_uri() );

/** URL ảnh trong thư viện Media hiện có (wp-content/uploads/...). */
function gfc_up( $path ) {
	$up = wp_get_upload_dir();
	return trailingslashit( $up['baseurl'] ) . ltrim( $path, '/' );
}

require GFC_PATH . '/inc/data.php';
require GFC_PATH . '/inc/icons.php';
require GFC_PATH . '/inc/customizer.php';
require GFC_PATH . '/inc/branches.php';
require GFC_PATH . '/inc/service-meta.php';
require GFC_PATH . '/inc/menu-fallback.php';
require GFC_PATH . '/inc/contact.php';
require GFC_PATH . '/inc/category-base.php';
require GFC_PATH . '/inc/live.php';
require GFC_PATH . '/inc/page-editor.php';
require GFC_PATH . '/inc/admin-guide.php';
require GFC_PATH . '/inc/webp.php';
require GFC_PATH . '/inc/seo.php';

/* ---------- Setup ---------- */
add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'gfc-security', GFC_PATH . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	register_nav_menus( array(
		'primary' => 'Menu chính',
		'footer_services' => 'Footer — Dịch vụ',
		'footer_support'  => 'Footer — Hỗ trợ khách hàng',
	) );
} );

/* CSS/JS: xem inc/live.php */

/* ---------- Helpers ---------- */

/** Logo: ưu tiên logo trong Tuỳ biến, nếu chưa có dùng logo Long Vân trong theme. */
function gfc_logo_url() {
	$id = get_theme_mod( 'custom_logo' );
	if ( $id ) {
		$src = wp_get_attachment_image_url( $id, 'full' );
		if ( $src ) return $src;
	}
	return GFC_URL . '/assets/img/logo-long-van.png';
}

/** Số điện thoại → href tel: */
function gfc_tel( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/** Breadcrumb đơn giản (Rank Math / Yoast nếu có thì dùng của plugin). */
function gfc_breadcrumb( $title = null ) {
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		echo '<div class="gfc-breadcrumb">';
		rank_math_the_breadcrumbs();
		echo '</div>';
		return;
	}
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<div class="gfc-breadcrumb">', '</div>' );
		return;
	}
	echo '<div class="gfc-breadcrumb"><a href="' . esc_url( home_url( '/' ) ) . '">Trang chủ</a> <span class="sep">›</span> <span>' . esc_html( null === $title ? get_the_title() : $title ) . '</span></div>';
}

/* Bỏ đoạn "[…]" mặc định trong excerpt */
add_filter( 'excerpt_more', function () { return '…'; } );
add_filter( 'excerpt_length', function () { return 80; } );
