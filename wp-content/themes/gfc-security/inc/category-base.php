<?php
/**
 * Bỏ "/category/" khỏi đường dẫn danh mục để giữ đúng URL bản cũ (/tin-tuc/bao-ve-tphcm, /dich-vu-gfc).
 * Nếu đã có Rank Math thì để plugin xử lý theo cấu hình của nó.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Chuyên mục dịch vụ. Slug đã đổi từ dich-vu-gfc sang dich-vu-long-van khi đổi thương hiệu, nhận cả hai. */
function gfc_service_cat() {
	foreach ( array( 'dich-vu-long-van', 'dich-vu-gfc' ) as $slug ) {
		$cat = get_category_by_slug( $slug );
		if ( $cat ) return $cat;
	}
	return null;
}

/* Template category-dich-vu-gfc.php chỉ tự áp cho slug cũ: đổi slug thì trang rơi về danh sách tin, ảnh đầu trang sửa trong "Nội dung trang" không hiện */
add_filter( 'category_template', function ( $template ) {
	$cat = gfc_service_cat();
	return $cat && is_category( $cat->term_id ) ? GFC_PATH . '/category-dich-vu-gfc.php' : $template;
} );

if ( ! class_exists( 'RankMath' ) ) {
	add_filter( 'category_link', function ( $link ) {
		return str_replace( '/category/', '/', $link );
	} );

	add_filter( 'category_rewrite_rules', function () {
		$rules = array();
		foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
			$path = trim( get_category_parents( $cat->term_id, false, '/', true ), '/' );
			$rules[ '(' . $path . ')/page/?([0-9]{1,})/?$' ] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
			$rules[ '(' . $path . ')/?$' ]                   = 'index.php?category_name=$matches[1]';
		}
		return $rules;
	} );

	foreach ( array( 'created_category', 'edited_category', 'delete_category' ) as $gfc_hook ) {
		add_action( $gfc_hook, function () {
			flush_rewrite_rules( false );
		} );
	}
}
