<?php
/** Xử lý form liên hệ dự phòng → gửi email về địa chỉ trong Tuỳ biến. */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/lien-he' );
	$back = remove_query_arg( 'gfc_sent', $back );

	if ( ! isset( $_POST['gfc_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gfc_contact_nonce'] ) ), 'gfc_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'gfc_sent', 'err', $back ) );
		exit;
	}
	// Bẫy spam: ô ẩn phải trống
	if ( ! empty( $_POST['gfc_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'gfc_sent', 'ok', $back ) );
		exit;
	}
	$name  = isset( $_POST['gfc_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gfc_name'] ) ) : '';
	$phone = isset( $_POST['gfc_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['gfc_phone'] ) ) : '';
	$email = isset( $_POST['gfc_email'] ) ? sanitize_email( wp_unslash( $_POST['gfc_email'] ) ) : '';
	$msg   = isset( $_POST['gfc_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gfc_message'] ) ) : '';

	if ( '' === $name || '' === $phone ) {
		wp_safe_redirect( add_query_arg( 'gfc_sent', 'err', $back ) );
		exit;
	}

	$to      = is_email( gfc_opt( 'email' ) ) ? gfc_opt( 'email' ) : get_option( 'admin_email' );
	$subject = '[Website] Yêu cầu liên hệ từ ' . $name;
	$body    = "Họ tên: {$name}\nSĐT: {$phone}\nEmail: {$email}\n\nNội dung:\n{$msg}\n";
	$headers = array();
	if ( $email ) $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

	$ok = wp_mail( $to, $subject, $body, $headers );
	wp_safe_redirect( add_query_arg( 'gfc_sent', $ok ? 'ok' : 'err', $back ) );
	exit;
}
add_action( 'admin_post_gfc_contact', 'gfc_handle_contact' );
add_action( 'admin_post_nopriv_gfc_contact', 'gfc_handle_contact' );
