<?php
/**
 * Trang Liên hệ (tự áp dụng cho trang có đường dẫn /lien-he).
 *
 * Template Name: Trang liên hệ GFC
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$hidden  = '<input type="hidden" name="action" value="gfc_contact">' . wp_nonce_field( 'gfc_contact', 'gfc_contact_nonce', true, false );
$hidden .= '<input type="text" name="gfc_website" value="" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px">';
$sent    = isset( $_GET['gfc_sent'] ) ? sanitize_key( $_GET['gfc_sent'] ) : ''; // phpcs:ignore
$msg     = '';
if ( 'ok' === $sent ) $msg = '<div class="wpcf7-response-output" style="display:block;border-color:#46b450">Cảm ơn bạn đã gửi yêu cầu. Chúng tôi sẽ phản hồi sớm nhất.</div>';
if ( 'err' === $sent ) $msg = '<div class="wpcf7-response-output" style="display:block;border-color:#dc3232">Chưa gửi được yêu cầu, vui lòng thử lại hoặc gọi hotline.</div>';
echo gfc_tpl( 'contact', array( // phpcs:ignore -- khung tĩnh của theme
	'ADMIN_POST'     => esc_url( admin_url( 'admin-post.php' ) ),
	'CONTACT_HIDDEN' => $hidden,
	'CONTACT_MSG'    => $msg,
) );
get_footer();
