<?php
/** Danh mục dịch vụ: các tab dịch vụ như bản gốc. */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
echo gfc_block( 'noi-dung-danh-muc-dich-vu', 'cat-services' ); // phpcs:ignore -- khung tĩnh của theme
get_footer();
