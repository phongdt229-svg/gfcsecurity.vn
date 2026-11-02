<?php
/**
 * Hiển thị theo markup + class của bản gốc: live-tpl/*.html chứa khung, {{token}} được thay bằng dữ liệu WordPress.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_tpl( $name, $vars = array() ) {
	$upload = wp_get_upload_dir();
	$map    = array(
		'{{UPLOADS}}' => untrailingslashit( $upload['baseurl'] ),
		'{{THEME}}'   => GFC_URL,
		'{{HOME}}'    => untrailingslashit( home_url() ),
		'{{UPLOADS}}/2025/10/GFCsecurity-banner-tach-nen-la-1-1.svg' => gfc_logo_url(),
	);
	$light = wp_get_attachment_image_url( (int) get_theme_mod( 'gfc_logo_light' ), 'medium' );
	if ( $light ) {
		$map['{{UPLOADS}}/2025/11/small-banner-logo.png'] = $light;
	}
	$map += gfc_info_tokens();
	foreach ( $vars as $k => $v ) {
		$map[ '{{' . $k . '}}' ] = (string) $v;
	}
	$html = strtr( file_get_contents( GFC_PATH . '/live-tpl/' . $name . '.html' ), $map ); // phpcs:ignore
	$alt  = get_post_meta( (int) get_theme_mod( 'custom_logo' ), '_wp_attachment_image_alt', true );
	if ( $alt && in_array( $name, array( 'header', 'footer' ), true ) ) {
		$html = preg_replace( '~(src="' . preg_quote( gfc_logo_url(), '~' ) . '"\s+alt=")[^"]*~', '${1}' . esc_attr( $alt ), $html );
	}
	return gfc_conditional( $html );
}

/** Thẻ bài viết: dùng trong vòng lặp. */
function gfc_card( $tpl ) {
	return gfc_tpl( $tpl, array(
		'u'  => esc_url( get_permalink() ),
		'i'  => esc_url( (string) get_the_post_thumbnail_url( null, 'full' ) ),
		't'  => esc_html( get_the_title() ),
		'e'  => esc_html( wp_strip_all_tags( get_the_excerpt() ) ),
		'dt' => esc_html( get_the_date( 'd/m/Y' ) ),
	) );
}

function gfc_the_content_html() {
	return apply_filters( 'the_content', get_the_content() ); // phpcs:ignore -- filter lõi WordPress
}

/** Đánh dấu mục menu của trang đang xem. */
function gfc_header_html() {
	$html = gfc_tpl( 'header' );
	$url  = untrailingslashit( home_url( strtok( wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), '?' ) ) );
	$base = wp_parse_url( home_url(), PHP_URL_PATH );
	if ( $base && 0 === strpos( (string) wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), $base ) ) {
		$url = untrailingslashit( home_url( substr( wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), strlen( $base ) ) ) );
	}
	$out = preg_replace(
		'~<li([^>]*?)class="([^"]*)"([^>]*)>(\s*<a[^>]*?href="' . preg_quote( $url, '~' ) . '/?")~',
		'<li$1class="$2 current-menu-item"$3>$4',
		$html
	);
	return null === $out ? $html : $out;
}

/** Phân trang theo đúng class bản gốc. */
function gfc_pagination() {
	global $wp_query;
	$total = (int) $wp_query->max_num_pages;
	if ( $total < 2 ) return '';
	$cur    = max( 1, (int) get_query_var( 'paged' ) );
	$arrows = json_decode( file_get_contents( GFC_PATH . '/live-tpl/arc-arrows.json' ), true ); // phpcs:ignore
	$nav    = trim( file_get_contents( GFC_PATH . '/live-tpl/arc-nav-class.txt' ) ); // phpcs:ignore
	$a_cls  = 'inline-flex size-8 lg:size-12 items-center justify-center rounded text-sm text-[#72787F] hover:bg-primary hover:text-white transition group';
	$n_cls  = 'inline-flex size-8 lg:size-12 items-center justify-center rounded text-xs lg:text-xl transition text-[#72787F] hover:bg-primary hover:text-white group';
	$arrow  = function ( $label, $page, $off ) use ( $arrows, $a_cls ) {
		if ( empty( $arrows[ $label ] ) ) return '';
		return '<a href="' . esc_url( get_pagenum_link( $page ) ) . '" class="' . $a_cls . ( $off ? ' pointer-events-none opacity-50' : '' ) . '" aria-label="' . esc_attr( $label ) . '">' . $arrows[ $label ] . '</a>';
	};
	$labels = array_keys( $arrows );
	$out    = '<nav class="' . esc_attr( $nav ) . '" role="navigation" aria-label="Pagination Navigation">';
	$out   .= $arrow( $labels[0], 1, 1 === $cur );
	if ( isset( $labels[3] ) ) $out .= $arrow( $labels[1], max( 1, $cur - 1 ), 1 === $cur );
	$prev = 0;
	for ( $i = 1; $i <= $total; $i++ ) {
		if ( 1 !== $i && $total !== $i && abs( $i - $cur ) > 2 ) continue;
		if ( $prev && $i - $prev > 1 ) $out .= '<span class="' . $n_cls . '">…</span>';
		$out .= $i === $cur
			? '<span aria-current="page" class="' . $n_cls . ' bg-primary text-white">' . $i . '</span>'
			: '<a class="' . $n_cls . '" href="' . esc_url( get_pagenum_link( $i ) ) . '">' . $i . '</a>';
		$prev = $i;
	}
	if ( isset( $labels[3] ) ) $out .= $arrow( $labels[2], min( $total, $cur + 1 ), $cur === $total );
	$out .= $arrow( end( $labels ), $total, $cur === $total );
	return $out . '</nav>';
}

/* Danh sách tin 12 bài mỗi trang như bản gốc */
add_action( 'pre_get_posts', function ( $q ) {
	if ( ! is_admin() && $q->is_main_query() && ( $q->is_category() || $q->is_search() || $q->is_home() ) ) {
		$q->set( 'posts_per_page', 12 );
	}
} );

/* CSS/JS của bản gốc */
add_action( 'wp_enqueue_scripts', function () {
	$dir = GFC_URL . '/assets/live/';
	if ( is_singular( 'post' ) ) wp_enqueue_style( 'gfc-ez-toc', $dir . 'ez-toc.css', array(), GFC_VERSION );
	wp_enqueue_style( 'gfc-live', $dir . 'app.css', array(), GFC_VERSION );
	wp_enqueue_style( 'swiper', $dir . 'swiper-bundle.min.css', array(), '8.4.7' );
	if ( is_front_page() || is_page( 'gioi-thieu-gfc-security' ) ) wp_enqueue_style( 'gfc-branch', $dir . 'branch-finder.css', array(), GFC_VERSION );
	wp_add_inline_style( 'gfc-live', file_get_contents( GFC_PATH . '/live-tpl/head.css' ) ); // phpcs:ignore
	wp_enqueue_script( 'swiper', $dir . 'swiper-bundle.min.js', array(), '8.4.7', true );
	foreach ( array( 'wp-block-library', 'classic-theme-styles' ) as $h ) wp_dequeue_style( $h );
}, 20 );

/** Form liên hệ: Contact Form 7, nếu tắt plugin thì dùng form dự phòng của theme. */
function gfc_contact_form() {
	$cf7 = absint( gfc_opt( 'cf7_id' ) );
	if ( $cf7 && shortcode_exists( 'contact-form-7' ) ) {
		return do_shortcode( '[contact-form-7 id="' . $cf7 . '"]' );
	}
	ob_start();
	get_template_part( 'template-parts/contact-form' );
	return ob_get_clean();
}

/* Raw HTML của WPBakery giữ {{token}} để đường dẫn ảnh không phụ thuộc tên miền */
add_filter( 'the_content', function ( $content ) {
	if ( false === strpos( $content, '{{' ) ) return $content;
	$upload = wp_get_upload_dir();
	$map    = array(
		'{{UPLOADS}}' => untrailingslashit( $upload['baseurl'] ),
		'{{THEME}}'   => GFC_URL,
		'{{HOME}}'    => untrailingslashit( home_url() ),
	);
	if ( false !== strpos( $content, '{{CONTACT_FORM}}' ) ) {
		$map['{{CONTACT_FORM}}'] = gfc_contact_form();
	}
	return gfc_conditional( strtr( $content, $map + gfc_info_tokens() ) );
}, 99 );

/* WPBakery: dùng cho page và post; khung row không tạo khoảng cách thừa quanh section */
add_action( 'vc_before_init', function () {
	vc_set_default_editor_post_types( array( 'page', 'post' ) );
} );
add_action( 'wp_enqueue_scripts', function () {
	wp_add_inline_style( 'gfc-live', '.gfc-builder .vc_row,.gfc-builder .wpb_column,.gfc-builder .vc_column-inner,.gfc-builder .wpb_wrapper,.gfc-builder .wpb_raw_code{position:static}.gfc-builder .vc_row{margin-left:0;margin-right:0}.gfc-builder .vc_column_container{padding:0;float:none}.gfc-builder .vc_column_container>.vc_column-inner{padding:0;width:100%}.gfc-builder .wpb_content_element,.gfc-builder .wpb_raw_code{margin-bottom:0}.gfc-builder>br,.gfc-builder>p:empty{display:none}#site-logo img,footer .col-span-12>picture img{object-position:left center}aside img[src*="LongVan_logo"]{object-fit:contain}' );
}, 21 );

/** Giá trị từ "Thông tin công ty" dùng trong live-tpl và row WPBakery. */
function gfc_info_tokens() {
	$tel = function ( $v ) {
		return 'tel:' . preg_replace( '/[^0-9+]/', '', $v );
	};
	$map = array();
	foreach ( array_keys( gfc_opt_defaults() ) as $k ) {
		$map[ '{{' . $k . '}}' ] = esc_html( gfc_opt( $k ) );
	}
	foreach ( array( 'facebook', 'zalo', 'youtube', 'profile_url' ) as $k ) {
		$map[ '{{' . $k . '}}' ] = esc_url( gfc_opt( $k ) );
	}
	foreach ( array( 'switchboard', 'hotline1', 'hotline2', 'hire_phone', 'jobs_phone', 'sidebar_hotline', 'office1_phone', 'office2_phone', 'office3_phone' ) as $k ) {
		$map[ '{{tel_' . $k . '}}' ] = esc_attr( $tel( gfc_opt( $k ) ) );
	}
	foreach ( array( 1, 2, 3 ) as $i ) {
		$map[ '{{office' . $i . '_map}}' ] = esc_url( 'https://www.google.com/maps?q=' . rawurlencode( gfc_opt( 'office' . $i . '_address' ) ) . '&output=embed' );
	}
	$map['{{digits_hotline1}}']       = esc_html( preg_replace( '/[^0-9]/', '', gfc_opt( 'hotline1' ) ) );
	$map['{{spaced_hotline1}}']       = esc_html( str_replace( '.', ' ', gfc_opt( 'hotline1' ) ) );
	$map['{{json_office1_address}}']  = trim( wp_json_encode( gfc_opt( 'office1_address' ) ), '"' );
	$map['{{menu_services}}']         = gfc_footer_links( 'footer_services', gfc_footer_services_default() );
	$map['{{menu_support}}']          = gfc_footer_links( 'footer_support', gfc_footer_support_default() );
	return $map;
}

/** Bỏ các khối <!--if:khoa-->...<!--/if:khoa--> khi ô tương ứng để trống. */
function gfc_conditional( $html ) {
	if ( false === strpos( $html, '<!--if:' ) ) return $html;
	$out = preg_replace_callback(
		'~<!--if:(\w+)-->(.*?)<!--/if:\1-->~s',
		function ( $m ) {
			return '' === gfc_opt( $m[1] ) ? '' : $m[2];
		},
		$html
	);
	return null === $out ? $html : $out;
}

/** Link footer: lấy từ Giao diện → Menu, chưa gán menu thì dùng danh sách mặc định. */
function gfc_footer_links( $location, $defaults ) {
	$cls   = 'text-sm lg:text-base 2xl:text-lg hover:text-primary transition-all duration-300';
	$links = array();
	$locs  = get_nav_menu_locations();
	$items = ! empty( $locs[ $location ] ) ? wp_get_nav_menu_items( $locs[ $location ] ) : false;
	if ( $items ) {
		foreach ( $items as $it ) {
			if ( ! $it->menu_item_parent ) $links[] = array( $it->title, $it->url );
		}
	} else {
		foreach ( $defaults as $it ) {
			$links[] = array( $it[0], gfc_link( $it[1] ) );
		}
	}
	$html = '';
	foreach ( $links as $l ) {
		$html .= '<a href="' . esc_url( $l[1] ) . '" class="' . $cls . '">' . esc_html( $l[0] ) . '</a>';
	}
	return $html;
}

/** Số điện thoại cũ in sẵn trong nội dung đi theo Hotline trong "Thông tin công ty". */
function gfc_swap_hotline( $text ) {
	$now = gfc_opt( 'hotline1' );
	if ( '' === $now || '' === (string) $text ) return $text;
	$digits = preg_replace( '/[^0-9]/', '', $now );
	$out    = preg_replace_callback(
		'~(?<![0-9])(?:0778[ .-]?247[ .-]?113|0328[ .-]?898[ .-]?113|1900[ .-]?3014|08[ .-]?12345[ .-]?247|\(?0(?:28|24|236)\)?[ .-]?4455[ .-]?0?[ .-]?0?[ .-]?247)(?![0-9])~',
		function ( $m ) use ( $now, $digits ) {
			return ctype_digit( $m[0] ) ? $digits : $now;
		},
		$text
	);
	if ( null === $out ) return $text;
	$num = preg_quote( $now, '~' );
	$sep = '\s*(?:–|—|-|/|,|&#8211;|&ndash;|hoặc)\s*';
	$one = preg_replace( '~(' . $num . ')(?:' . $sep . $num . ')+~u', '$1', $out );
	$out = null === $one ? $out : $one;
	$lnk = '<a\b[^>]*href="tel:' . preg_quote( $digits, '~' ) . '"[^>]*>[^<]*</a>';
	$two = preg_replace( '~(' . $lnk . ')(?:' . $sep . $lnk . ')+~u', '$1', $out );
	return null === $two ? $out : $two;
}

add_filter( 'the_content', function ( $content ) {
	return gfc_swap_hotline( $content );
}, 98 );
add_filter( 'get_the_excerpt', 'gfc_swap_hotline' );
