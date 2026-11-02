<?php
/**
 * Bỏ "/category/" khỏi đường dẫn danh mục để giữ đúng URL bản cũ (/tin-tuc/bao-ve-tphcm, /dich-vu-gfc).
 * Nếu đã có Rank Math thì để plugin xử lý theo cấu hình của nó.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

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
