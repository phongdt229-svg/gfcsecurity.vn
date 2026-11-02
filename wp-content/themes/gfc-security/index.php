<?php
/** Danh sách bài viết / danh mục tin tức / tìm kiếm */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
if ( is_search() ) {
	$title = 'Kết quả tìm kiếm: ' . get_search_query();
} elseif ( is_archive() ) {
	$title = single_term_title( '', false );
} else {
	$title = 'Tin tức';
}
$items = '';
while ( have_posts() ) { the_post(); $items .= gfc_card( 'arc-item' ); }
$body = gfc_tpl( 'arc-body', array( 'items' => $items ? $items : '<p>Chưa có bài viết.</p>', 'pagination' => gfc_pagination() ) );
if ( is_category() ) {
	$url  = untrailingslashit( get_category_link( get_queried_object_id() ) );
	$body = preg_replace( '~<a href="' . preg_quote( $url, '~' ) . '" class="([^"]*)"~', '<a href="' . $url . '" class="$1 active"', $body, 1 );
}
echo '<main class="mt-16 lg:mt-30">';
echo gfc_tpl( 'arc-hero', array( 'title' => esc_html( $title ) ) ); // phpcs:ignore
echo $body; // phpcs:ignore -- đã escape từng giá trị
echo '</main>';
get_footer();
