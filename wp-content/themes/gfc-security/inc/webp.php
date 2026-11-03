<?php
/**
 * Bản WebP nằm cạnh ảnh gốc (anh.jpg.webp), không đổi URL và không sửa ảnh gốc.
 * wp-content/uploads/.htaccess trả bản này khi trình duyệt hỗ trợ.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/** Tạo bản WebP. Trả về số byte, hoặc 0 nếu bỏ qua vì không nhẹ hơn hay không đọc được ảnh. */
function gfc_webp_make( $path, $max_width = 1920 ) {
	$ext = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
	if ( ! in_array( $ext, array( 'jpg', 'jpeg', 'png' ), true ) || ! is_file( $path ) || ! function_exists( 'imagewebp' ) ) return 0;
	$size = filesize( $path );
	$info = @getimagesize( $path );
	if ( $size < 10240 || ! $info || $info[0] * $info[1] > 40000000 ) return 0;
	$im = 'png' === $ext ? @imagecreatefrompng( $path ) : @imagecreatefromjpeg( $path );
	if ( ! $im ) return 0;
	if ( 'png' === $ext ) {
		imagepalettetotruecolor( $im );
		imagealphablending( $im, false );
		imagesavealpha( $im, true );
	} elseif ( function_exists( 'exif_read_data' ) ) {
		$exif  = @exif_read_data( $path );
		$angle = array( 3 => 180, 6 => -90, 8 => 90 );
		$turn  = isset( $exif['Orientation'], $angle[ $exif['Orientation'] ] ) ? $angle[ $exif['Orientation'] ] : 0;
		if ( $turn ) {
			$rotated = imagerotate( $im, $turn, 0 );
			if ( $rotated ) {
				imagedestroy( $im );
				$im = $rotated;
			}
		}
	}
	if ( imagesx( $im ) > $max_width ) {
		$small = imagescale( $im, $max_width, -1, IMG_BICUBIC );
		if ( $small ) {
			imagedestroy( $im );
			$im = $small;
			imagealphablending( $im, false );
			imagesavealpha( $im, true );
		}
	}
	$out = $path . '.webp';
	$tmp = $out . '.tmp';
	$ok  = imagewebp( $im, $tmp, 'png' === $ext ? 85 : 80 );
	imagedestroy( $im );
	if ( ! $ok || ! is_file( $tmp ) || filesize( $tmp ) < 100 || filesize( $tmp ) > $size * 0.95 ) {
		@unlink( $tmp );
		return 0;
	}
	$bytes = filesize( $tmp );
	rename( $tmp, $out );
	return $bytes;
}

/* Ảnh tải lên sau này cũng có bản WebP */
add_filter( 'wp_generate_attachment_metadata', function ( $meta ) {
	if ( empty( $meta['file'] ) ) return $meta;
	$dir  = wp_get_upload_dir();
	$full = trailingslashit( $dir['basedir'] ) . $meta['file'];
	gfc_webp_make( $full );
	foreach ( isset( $meta['sizes'] ) ? $meta['sizes'] : array() as $s ) {
		gfc_webp_make( trailingslashit( dirname( $full ) ) . $s['file'] );
	}
	return $meta;
} );

/* Xoá ảnh trong Thư viện thì xoá luôn bản WebP */
add_filter( 'wp_delete_file', function ( $file ) {
	if ( is_string( $file ) && is_file( $file . '.webp' ) ) @unlink( $file . '.webp' );
	return $file;
} );
