<?php
/**
 * Banner đầu trang: nền xanh với sọc chéo xanh lá bên trái, ảnh bên phải.
 * $args: title, desc, image
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$title = isset( $args['title'] ) ? $args['title'] : get_the_title();
$desc  = isset( $args['desc'] ) ? $args['desc'] : '';
$image = isset( $args['image'] ) ? $args['image'] : '';
?>
<section class="gfc-phero" style="background-image:url('<?php echo esc_url( gfc_up( '2025/10/Rectangle-1-2.png' ) ); ?>')">
	<?php if ( $image ) : ?>
		<div class="gfc-phero__media"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" fetchpriority="high"></div>
	<?php endif; ?>
	<div class="container gfc-phero__in">
		<div class="gfc-phero__text">
			<h1><?php echo esc_html( $title ); ?></h1>
			<?php if ( $desc ) : ?><p><?php echo esc_html( $desc ); ?></p><?php endif; ?>
		</div>
	</div>
</section>
