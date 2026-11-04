<?php
/**
 * Yoast SEO chỉ đọc post_content nên không thấy chữ trong row Raw HTML và khung trang dịch vụ.
 * Đưa nội dung đang hiển thị vào phần phân tích của Yoast để điểm phản ánh đúng trang thật.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_seo_analysis_text( $post ) {
	$html = '';
	$rows = gfc_pe_rows( (int) get_option( 'page_on_front' ) === $post->ID ? gfc_home_visible_content( $post->post_content ) : $post->post_content );
	if ( $rows ) {
		$html = gfc_tpl_render( implode( "\n", $rows ), 'seo', array() );
	}
	if ( gfc_smeta( 'hero_title', $post->ID ) ) {
		$html .= '<h1>' . esc_html( gfc_smeta( 'hero_title', $post->ID ) ) . '</h1><p>' . esc_html( gfc_smeta( 'hero_desc', $post->ID ) ) . '</p>';
		foreach ( array( 'price', 'tasks', 'process', 'std' ) as $block ) {
			$html .= '<h2>' . esc_html( gfc_smeta( $block . '_title', $post->ID ) ) . '</h2><p>' . esc_html( gfc_smeta( $block . '_desc', $post->ID ) ) . '</p>';
		}
		$html .= wp_kses_post( gfc_smeta( 'price_html', $post->ID ) );
		foreach ( gfc_lines( gfc_smeta( 'tasks', $post->ID ) ) as $t ) {
			$html .= '<h3>' . esc_html( $t[0] ) . '</h3><p>' . esc_html( $t[1] ) . '</p>';
		}
	}
	$html = preg_replace( '~<(script|style|svg|template|noscript)\b.*?</\1>~si', '', $html );
	return null === $html ? '' : $html;
}

add_action( 'admin_print_footer_scripts', function () {
	$screen = get_current_screen();
	if ( ! defined( 'WPSEO_VERSION' ) || ! $screen || 'post' !== $screen->base ) return;
	$post = get_post();
	if ( ! $post ) return;
	$text = gfc_seo_analysis_text( $post );
	if ( '' === $text ) return;
	?>
	<script>
	jQuery(window).on('YoastSEO:ready', function () {
		var extra = <?php echo wp_json_encode( $text ); // phpcs:ignore -- JSON đã mã hoá ?>;
		YoastSEO.app.registerPlugin('gfcContent', { status: 'ready' });
		YoastSEO.app.registerModification('content', function (content) {
			return extra + content.replace(/\[vc_raw_html\][\s\S]*?\[\/vc_raw_html\]/g, '').replace(/\[\/?vc_[^\]]*\]/g, '');
		}, 'gfcContent', 5);
	});
	</script>
	<?php
} );
