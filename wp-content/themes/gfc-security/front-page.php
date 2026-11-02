<?php
/** Trang chủ */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
echo gfc_tpl( 'home' ); // phpcs:ignore -- khung tĩnh của theme
get_footer();
