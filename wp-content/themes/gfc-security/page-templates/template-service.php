<?php
/**
 * Template Name: Trang dịch vụ GFC
 * Template Post Type: page, post
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
	$title = gfc_smeta( 'hero_title' ) ? gfc_smeta( 'hero_title' ) : get_the_title();
	$img   = gfc_smeta( 'hero_image' );
	if ( ! $img && has_post_thumbnail() ) $img = get_the_post_thumbnail_url( null, 'full' );
	$h = esc_html( $title );
	echo '<main class="mt-16 lg:mt-30">';
	// phpcs:disable WordPress.Security.EscapeOutput -- đã escape từng giá trị
	echo gfc_tpl( 'svc-hero', array( 'hero_title' => $h, 'hero_desc' => esc_html( gfc_smeta( 'hero_desc' ) ), 'hero_image' => esc_url( $img ) ) );
	if ( gfc_smeta( 'price_html' ) ) {
		echo gfc_tpl( 'svc-price', array( 'hero_title' => $h, 'price_title' => esc_html( gfc_smeta( 'price_title' ) ), 'price_html' => wp_kses_post( gfc_smeta( 'price_html' ) ) ) );
	}
	$extra = gfc_lines( gfc_smeta( 'extra_items' ), 3 );
	if ( $extra ) {
		$items = '';
		foreach ( $extra as $e ) $items .= gfc_tpl( 'svc-extra-item', array( 't' => esc_html( $e[0] ), 'u' => esc_url( gfc_link( $e[1] ) ), 'i' => esc_url( gfc_link( $e[2] ) ) ) );
		echo gfc_tpl( 'svc-extra', array( 'extra_title' => esc_html( gfc_smeta( 'extra_title' ) ), 'extra_items' => $items ) );
	}
	if ( gfc_smeta( 'adv_image' ) ) {
		$dk = esc_url( gfc_link( gfc_smeta( 'adv_image' ) ) );
		echo gfc_tpl( 'svc-adv', array( 'adv_title' => esc_html( gfc_smeta( 'adv_title' ) ), 'adv_image' => $dk, 'adv_image_m' => gfc_smeta( 'adv_image_m' ) ? esc_url( gfc_link( gfc_smeta( 'adv_image_m' ) ) ) : $dk ) );
	}
	$tasks = gfc_lines( gfc_smeta( 'tasks' ) );
	if ( $tasks ) {
		$items = '';
		foreach ( $tasks as $t ) $items .= gfc_tpl( 'svc-task-item', array( 't' => esc_html( $t[0] ), 'd' => esc_html( $t[1] ) ) );
		echo gfc_tpl( 'svc-tasks', array( 'tasks_title' => esc_html( gfc_smeta( 'tasks_title' ) ), 'tasks_items' => $items, 'tasks_img1' => esc_url( gfc_link( gfc_smeta( 'tasks_img1' ) ) ), 'tasks_img2' => esc_url( gfc_link( gfc_smeta( 'tasks_img2' ) ) ) ) );
	}
	if ( gfc_smeta( 'process_title' ) ) {
		$dk = esc_url( gfc_link( gfc_smeta( 'process_image' ) ) );
		echo gfc_tpl( 'svc-process', array( 'process_title' => esc_html( gfc_smeta( 'process_title' ) ), 'process_desc' => esc_html( gfc_smeta( 'process_desc' ) ), 'process_image' => $dk, 'process_image_m' => gfc_smeta( 'process_image_m' ) ? esc_url( gfc_link( gfc_smeta( 'process_image_m' ) ) ) : $dk ) );
	}
	if ( gfc_smeta( 'std_title' ) ) {
		echo gfc_tpl( 'svc-std', array( 'std_title' => esc_html( gfc_smeta( 'std_title' ) ), 'std_desc' => esc_html( gfc_smeta( 'std_desc' ) ), 'std_link_url' => esc_url( gfc_link( gfc_smeta( 'std_link_url' ) ) ), 'std_link_text' => esc_html( gfc_smeta( 'std_link_text' ) ) ) );
	}
	if ( '' !== trim( get_the_content() ) ) {
		echo gfc_tpl( 'svc-content', array( 'content' => gfc_the_content_html() ) );
	}
	// phpcs:enable
	echo '</main>';
endwhile;
get_footer();
