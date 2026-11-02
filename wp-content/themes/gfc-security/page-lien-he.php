<?php
/**
 * Trang Liên hệ: sửa bằng WPBakery trong trang "Liên hệ". {{CONTACT_FORM}} là vị trí form Contact Form 7.
 *
 * Template Name: Trang liên hệ
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
if ( '' !== trim( (string) get_post_field( 'post_content', get_queried_object_id() ) ) ) {
	while ( have_posts() ) : the_post();
		echo '<main class="mt-16 lg:mt-30 gfc-builder">';
		the_content();
		echo '</main>';
	endwhile;
} else {
	echo gfc_tpl( 'contact', array( 'CONTACT_FORM' => gfc_contact_form() ) ); // phpcs:ignore -- khung tĩnh của theme
}
get_footer();
