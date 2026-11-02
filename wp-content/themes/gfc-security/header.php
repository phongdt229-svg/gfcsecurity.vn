<?php if ( ! defined( 'ABSPATH' ) ) exit; ?><!doctype html>
<html <?php language_attributes(); ?> style="container-type: scroll-state; container-name: scroller; scroll-behavior: smooth;" class="transition-all scroll-smooth">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'relative' ); ?>>
<?php wp_body_open(); ?>
<?php echo gfc_header_html(); // phpcs:ignore -- khung tĩnh của theme ?>
