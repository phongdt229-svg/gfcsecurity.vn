<?php
/** Trang Giới thiệu (tự áp dụng cho trang có đường dẫn /gioi-thieu-gfc-security). */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
echo gfc_tpl( 'about' ); // phpcs:ignore -- khung tĩnh của theme
get_footer();
