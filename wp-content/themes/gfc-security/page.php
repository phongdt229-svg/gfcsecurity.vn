<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
	echo '<main class="mt-16 lg:mt-30">';
	echo gfc_tpl( 'page', array( // phpcs:ignore -- đã escape từng giá trị
		'title'   => esc_html( get_the_title() ),
		'date'    => esc_html( get_the_date( 'd/m/Y' ) ),
		'content' => gfc_the_content_html(),
	) );
	echo '</main>';
endwhile;
get_footer();
