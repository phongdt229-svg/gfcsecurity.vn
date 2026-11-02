<?php
/** Form liên hệ dự phòng (dùng khi không có plugin Contact Form 7). */
if ( ! defined( 'ABSPATH' ) ) exit;
$sent = isset( $_GET['gfc_sent'] ) ? sanitize_key( wp_unslash( $_GET['gfc_sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
?>
<?php if ( 'ok' === $sent ) : ?>
	<p class="gfc-alert gfc-alert--ok">Cảm ơn bạn! Yêu cầu đã được gửi, GFC Security sẽ liên hệ lại sớm nhất.</p>
<?php elseif ( 'err' === $sent ) : ?>
	<p class="gfc-alert gfc-alert--err">Chưa gửi được. Vui lòng nhập họ tên và số điện thoại, hoặc gọi hotline <?php echo esc_html( gfc_opt( 'hotline1' ) ); ?>.</p>
<?php endif; ?>
<form class="gfc-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="gfc_contact">
	<?php wp_nonce_field( 'gfc_contact', 'gfc_contact_nonce' ); ?>
	<input type="text" name="gfc_website" value="" tabindex="-1" autocomplete="off" class="gfc-hp" aria-hidden="true">
	<label class="screen-reader-text" for="gfc-name">Họ và tên</label>
	<input id="gfc-name" type="text" name="gfc_name" placeholder="Họ và tên" required>
	<label class="screen-reader-text" for="gfc-phone">Số điện thoại</label>
	<input id="gfc-phone" type="tel" name="gfc_phone" placeholder="Số điện thoại" required>
	<label class="screen-reader-text" for="gfc-email">Email</label>
	<input id="gfc-email" type="email" name="gfc_email" placeholder="Email">
	<label class="screen-reader-text" for="gfc-msg">Nội dung</label>
	<textarea id="gfc-msg" name="gfc_message" rows="5" placeholder="Nội dung"></textarea>
	<button type="submit" class="gfc-btn gfc-btn--blue">Gửi yêu cầu</button>
</form>
