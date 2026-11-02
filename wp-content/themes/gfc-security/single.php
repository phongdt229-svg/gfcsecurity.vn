<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
	echo '<main class="mt-16 lg:mt-30">';
	echo gfc_tpl( 'art-main', array( // phpcs:ignore -- đã escape từng giá trị
		'post_class' => esc_attr( implode( ' ', get_post_class() ) ),
		'title'      => esc_html( get_the_title() ),
		'date'       => esc_html( get_the_date( 'd/m/Y' ) ),
		'content'    => gfc_the_content_html(),
	) );
	$rel = new WP_Query( array( 'posts_per_page' => 6, 'post__not_in' => array( get_the_ID() ), 'ignore_sticky_posts' => true ) );
	if ( $rel->have_posts() ) {
		$items = '';
		while ( $rel->have_posts() ) { $rel->the_post(); $items .= gfc_card( 'art-rel-item' ); }
		wp_reset_postdata();
		echo gfc_tpl( 'art-related', array( 'items' => $items ) ); // phpcs:ignore
	}
	echo '</main>';
endwhile;
get_footer();
