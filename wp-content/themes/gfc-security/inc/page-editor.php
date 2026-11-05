<?php
/**
 * Màn hình "Nội dung trang": sửa chữ, ảnh, link và thêm/xoá mục của các trang dựng bằng row Raw HTML WPBakery.
 * Chỉ thay đúng vị trí đang sửa trong HTML nên markup, class và giao diện giữ nguyên. Mỗi lần lưu tạo một bản Revision.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GFC_PE_RE_ROW', '~\[vc_raw_html\](.*?)\[/vc_raw_html\]~s' );

function gfc_pe_decode( $b64 ) {
	return rawurldecode( (string) base64_decode( $b64 ) ); // phpcs:ignore -- định dạng lưu của WPBakery
}

function gfc_pe_encode( $html ) {
	return base64_encode( rawurlencode( $html ) ); // phpcs:ignore -- định dạng lưu của WPBakery
}

function gfc_pe_rows( $content ) {
	preg_match_all( GFC_PE_RE_ROW, $content, $m );
	return array_map( 'gfc_pe_decode', $m[1] );
}

/** Dựng cây phần tử, giữ vị trí byte của từng thẻ. Bỏ qua script, style, svg, template, select. */
function gfc_pe_tree( $html ) {
	$root  = array( 'tag' => '', 'attr' => array( 0, 0 ), 'open' => 0, 'in' => 0, 'out' => strlen( $html ), 'kids' => array(), 'texts' => array() );
	$nodes = array( $root );
	$stack = array( 0 );
	$void  = array( 'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'source', 'track', 'wbr' );
	$skip  = array( 'script', 'style', 'svg', 'template', 'select', 'noscript' );
	$len   = strlen( $html );
	$pos   = 0;
	$text  = function ( $from, $to ) use ( &$nodes, &$stack ) {
		if ( $to > $from ) $nodes[ end( $stack ) ]['texts'][] = array( $from, $to );
	};
	while ( $pos < $len ) {
		$lt = strpos( $html, '<', $pos );
		if ( false === $lt ) {
			$text( $pos, $len );
			break;
		}
		if ( 0 === substr_compare( $html, '<!--', $lt, 4 ) ) {
			$text( $pos, $lt );
			$end = strpos( $html, '-->', $lt );
			$pos = false === $end ? $len : $end + 3;
			continue;
		}
		if ( ! preg_match( '~\G<(/?)([a-zA-Z][\w:-]*)((?:[^>"\']++|"[^"]*+"|\'[^\']*+\')*+)>~', $html, $t, PREG_OFFSET_CAPTURE, $lt ) ) {
			$text( $pos, $lt + 1 );
			$pos = $lt + 1;
			continue;
		}
		$text( $pos, $lt );
		$tag = strtolower( $t[2][0] );
		$end = $lt + strlen( $t[0][0] );
		if ( '/' === $t[1][0] ) {
			$depth = count( $stack ) - 1;
			while ( $depth > 0 && $nodes[ $stack[ $depth ] ]['tag'] !== $tag ) $depth--;
			if ( $depth > 0 ) {
				while ( count( $stack ) > $depth ) {
					$nodes[ array_pop( $stack ) ]['out'] = count( $stack ) === $depth ? $lt : $lt;
				}
				$nodes[ $stack[ $depth - 1 ] ]['kids'] = $nodes[ $stack[ $depth - 1 ] ]['kids'];
				$closed = end( $nodes[ $stack[ $depth - 1 ] ]['kids'] );
				$nodes[ $closed ]['end'] = $end;
			}
			$pos = $end;
			continue;
		}
		if ( in_array( $tag, $skip, true ) ) {
			$close = stripos( $html, '</' . $tag, $end );
			if ( false === $close ) {
				$pos = $len;
			} else {
				$gt  = strpos( $html, '>', $close );
				$pos = false === $gt ? $len : $gt + 1;
			}
			$idx = count( $nodes );
			$nodes[] = array( 'tag' => $tag, 'attr' => array( $t[3][1], $t[3][1] + strlen( $t[3][0] ) ), 'open' => $lt, 'in' => $end, 'out' => $pos, 'end' => $pos, 'kids' => array(), 'texts' => array(), 'atomic' => true );
			$nodes[ end( $stack ) ]['kids'][] = $idx;
			continue;
		}
		$idx = count( $nodes );
		$nodes[] = array( 'tag' => $tag, 'attr' => array( $t[3][1], $t[3][1] + strlen( $t[3][0] ) ), 'open' => $lt, 'in' => $end, 'out' => $end, 'end' => $end, 'kids' => array(), 'texts' => array() );
		$nodes[ end( $stack ) ]['kids'][] = $idx;
		if ( ! in_array( $tag, $void, true ) && '/' !== substr( $t[3][0], -1 ) ) $stack[] = $idx;
		$pos = $end;
	}
	while ( count( $stack ) > 1 ) {
		$i = array_pop( $stack );
		$nodes[ $i ]['out'] = $len;
		$nodes[ $i ]['end'] = $len;
	}
	return $nodes;
}

function gfc_pe_attr( $html, $n, $name ) {
	$a = substr( $html, $n['attr'][0], $n['attr'][1] - $n['attr'][0] );
	if ( ! preg_match( '~(?:^|\s)' . preg_quote( $name, '~' ) . '\s*=\s*"([^"]*)"~i', $a, $m, PREG_OFFSET_CAPTURE ) ) return null;
	return array( $m[1][0], $n['attr'][0] + $m[1][1], $n['attr'][0] + $m[1][1] + strlen( $m[1][0] ) );
}

function gfc_pe_has_text( $s ) {
	return (bool) preg_match( '~[\p{L}\p{N}+%]~u', html_entity_decode( wp_strip_all_tags( $s ) ) );
}

function gfc_pe_is_leaf( $nodes, $i, $html ) {
	static $inline = array( 'a', 'span', 'strong', 'b', 'em', 'i', 'u', 'br', 'sup', 'sub', 'small', 'mark', 'font', 'abbr' );
	foreach ( $nodes[ $i ]['kids'] as $k ) {
		if ( ! in_array( $nodes[ $k ]['tag'], $inline, true ) || ! gfc_pe_is_leaf( $nodes, $k, $html ) ) return false;
	}
	return true;
}

/** Nhóm lặp: con cùng thẻ, cùng class và có nội dung sửa được. Tab điều hướng (data-target="#...") không tính. */
function gfc_pe_is_group( $nodes, $i, $html ) {
	$kids = $nodes[ $i ]['kids'];
	if ( ! $kids || in_array( $nodes[ $i ]['tag'], array( 'picture', 'p', 'a', 'span' ), true ) ) return false;
	if ( count( $kids ) < 2 && null === gfc_pe_attr( $html, $nodes[ $i ], 'data-gfc-repeat' ) ) return false;
	$sig = null;
	foreach ( $kids as $k ) {
		$c = gfc_pe_attr( $html, $nodes[ $k ], 'class' );
		$s = $nodes[ $k ]['tag'] . '|' . trim( preg_replace( '~\b(active|first|last|current)\b|\s+~', ' ', $c ? $c[0] : '' ) );
		if ( null !== $sig && $s !== $sig ) return false;
		$sig = $s;
		if ( ! empty( $nodes[ $k ]['atomic'] ) || 'br' === $nodes[ $k ]['tag'] ) return false;
		$t = gfc_pe_attr( $html, $nodes[ $k ], 'data-target' );
		if ( $t && '#' === substr( $t[0], 0, 1 ) ) return false;
	}
	return gfc_pe_subtree_editable( $nodes, $kids[0], $html );
}

function gfc_pe_subtree_editable( $nodes, $i, $html ) {
	if ( 'img' === $nodes[ $i ]['tag'] ) return true;
	foreach ( $nodes[ $i ]['texts'] as $t ) {
		if ( gfc_pe_has_text( substr( $html, $t[0], $t[1] - $t[0] ) ) ) return true;
	}
	foreach ( $nodes[ $i ]['kids'] as $k ) {
		if ( gfc_pe_subtree_editable( $nodes, $k, $html ) ) return true;
	}
	return false;
}

function gfc_pe_ui_url( $v ) {
	$up = wp_get_upload_dir();
	return strtr( html_entity_decode( $v ), array( '{{UPLOADS}}' => untrailingslashit( $up['baseurl'] ), '{{HOME}}' => untrailingslashit( home_url() ) ) );
}

function gfc_pe_store_url( $v ) {
	$v = trim( $v );
	if ( '' === $v ) return '';
	$up   = untrailingslashit( wp_get_upload_dir()['baseurl'] );
	$home = untrailingslashit( home_url() );
	if ( 0 === strpos( $v, '/' ) && 0 !== strpos( $v, '//' ) ) $v = $home . $v;
	$v = esc_url_raw( $v );
	if ( 0 === strpos( $v, $up ) ) return '{{UPLOADS}}' . substr( $v, strlen( $up ) );
	if ( 0 === strpos( $v, $home ) ) return '{{HOME}}' . substr( $v, strlen( $home ) );
	return $v;
}

function gfc_pe_ui_text( $raw ) {
	$s = trim( preg_replace( '~\s+~u', ' ', $raw ) );
	$s = preg_replace( '~\s*<br\s*/?>\s*~i', "\n", $s );
	return preg_match( '~</?[a-z]~i', $s ) ? $s : html_entity_decode( $s, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
}

function gfc_pe_store_text( $v ) {
	$v = trim( str_replace( "\r", '', $v ) );
	if ( preg_match( '~</?[a-z]~i', $v ) ) {
		$a = array( 'href' => true, 'target' => true, 'rel' => true, 'title' => true );
		$v = wp_kses( $v, array( 'a' => $a, 'span' => array( 'class' => true, 'style' => true ), 'br' => array(), 'strong' => array(), 'b' => array(), 'em' => array(), 'i' => array(), 'u' => array(), 'sup' => array(), 'sub' => array(), 'small' => array(), 'mark' => array() ) );
	} else {
		$v = str_replace( array( '&', '<', '>' ), array( '&amp;', '&lt;', '&gt;' ), $v );
	}
	return str_replace( "\n", '<br>', $v );
}

/** Phân tích một row: danh sách trường phẳng và cây hiển thị (trường, nhóm lặp, mục). */
function gfc_pe_parse( $html ) {
	$nodes  = gfc_pe_tree( $html );
	$fields = array();
	$groups = array();
	$add    = function ( $kind, $tag, $from, $to, $value, $repeat ) use ( &$fields ) {
		$fields[] = array( 'kind' => $kind, 'tag' => $tag, 'ranges' => array( array( $from, $to ) ), 'value' => $value, 'repeat' => $repeat );
		return array( 'f' => count( $fields ) - 1 );
	};
	$walk   = function ( $i, $repeat ) use ( &$walk, &$nodes, &$groups, &$fields, $html, $add ) {
		$n   = $nodes[ $i ];
		$out = array();
		$tag = $n['tag'];
		if ( ! empty( $n['atomic'] ) ) {
			return $out;
		}
		if ( 'img' === $tag ) {
			$src = gfc_pe_attr( $html, $n, 'src' );
			/* Banner trang trí của hero không cho đổi ở đây: ảnh chính nằm trong danh sách slide */
			if ( $src && false !== strpos( $src[0], '2025/10/banner-gfc-1-1.png' ) ) return $out;
			if ( $src && '' !== $src[0] && false === strpos( $src[0], 'data:' ) ) $out[] = $add( 'image', 'img', $src[1], $src[2], gfc_pe_ui_url( $src[0] ), $repeat );
			$alt = gfc_pe_attr( $html, $n, 'alt' );
			if ( $alt && $src && '' !== $src[0] ) $out[] = $add( 'alt', 'img', $alt[1], $alt[2], html_entity_decode( $alt[0], ENT_QUOTES | ENT_HTML5, 'UTF-8' ), $repeat );
			return $out;
		}
		if ( 'iframe' === $tag ) {
			$src = gfc_pe_attr( $html, $n, 'src' );
			if ( $src && false === strpos( $src[0], '{{' ) && '' !== $src[0] ) $out[] = $add( 'embed', 'iframe', $src[1], $src[2], html_entity_decode( $src[0] ), $repeat );
			return $out;
		}
		$style = gfc_pe_attr( $html, $n, 'style' );
		if ( $style && preg_match( '~url\(\s*(?:&quot;|\'|)([^\'")&]+)~', $style[0], $u, PREG_OFFSET_CAPTURE ) && false === strpos( $u[1][0], 'data:' ) ) {
			$out[] = $add( 'image', 'bg', $style[1] + $u[1][1], $style[1] + $u[1][1] + strlen( $u[1][0] ), gfc_pe_ui_url( $u[1][0] ), $repeat );
		}
		if ( 'a' === $tag ) {
			$href = gfc_pe_attr( $html, $n, 'href' );
			if ( $href && '' !== $href[0] && '#' !== $href[0][0] && 0 === preg_match( '~\{\{(?!HOME|UPLOADS)~', $href[0] ) ) {
				$out[] = $add( 'url', 'a', $href[1], $href[2], gfc_pe_ui_url( $href[0] ), $repeat );
			}
		}
		$target = gfc_pe_attr( $html, $n, 'data-target' );
		if ( $target && ctype_digit( $target[0] ) ) {
			$out[] = $add( 'number', $tag, $target[1], $target[2], $target[0], $repeat );
			return $out;
		}
		$is_empty = ! $n['kids'] && ! gfc_pe_subtree_editable( $nodes, $i, $html );
		if ( 0 !== $i && gfc_pe_is_leaf( $nodes, $i, $html ) && ( gfc_pe_subtree_editable( $nodes, $i, $html ) || ( $is_empty && in_array( $tag, array( 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) && '' === trim( substr( $html, $n['in'], $n['out'] - $n['in'] ) ) ) ) ) {
			$cur = $i;
			while ( 1 === count( $nodes[ $cur ]['kids'] ) && 'br' !== $nodes[ $nodes[ $cur ]['kids'][0] ]['tag'] ) {
				$direct = '';
				foreach ( $nodes[ $cur ]['texts'] as $t ) $direct .= substr( $html, $t[0], $t[1] - $t[0] );
				if ( gfc_pe_has_text( $direct ) ) break;
				$cur = $nodes[ $cur ]['kids'][0];
				if ( 'a' === $nodes[ $cur ]['tag'] ) {
					$href = gfc_pe_attr( $html, $nodes[ $cur ], 'href' );
					if ( $href && '' !== $href[0] && '#' !== $href[0][0] && 0 === preg_match( '~\{\{(?!HOME|UPLOADS)~', $href[0] ) ) $out[] = $add( 'url', 'a', $href[1], $href[2], gfc_pe_ui_url( $href[0] ), $repeat );
				}
			}
			$c   = $nodes[ $cur ];
			$raw = substr( $html, $c['in'], $c['out'] - $c['in'] );
			if ( 0 === preg_match( '~\{\{(?!HOME|UPLOADS)~', $raw ) ) {
				$s     = strlen( $raw ) - strlen( ltrim( $raw ) );
				$e     = strlen( rtrim( $raw ) );
				$out[] = $add( 'text', $tag, $c['in'] + $s, $c['in'] + max( $s, $e ), gfc_pe_ui_text( $raw ), $repeat );
			}
			return $out;
		}
		foreach ( $n['texts'] as $t ) {
			$raw = substr( $html, $t[0], $t[1] - $t[0] );
			if ( ! gfc_pe_has_text( $raw ) || preg_match( '~\{\{(?!HOME|UPLOADS)~', $raw ) ) continue;
			$s     = strlen( $raw ) - strlen( ltrim( $raw ) );
			$e     = strlen( rtrim( $raw ) );
			$out[] = $add( 'text', 'span', $t[0] + $s, $t[0] + $e, gfc_pe_ui_text( $raw ), $repeat );
		}
		$is_group = gfc_pe_is_group( $nodes, $i, $html );
		if ( $is_group ) {
			$g        = count( $groups );
			$groups[] = array( 'node' => $i, 'items' => $n['kids'] );
			$items    = array();
			foreach ( $n['kids'] as $k ) $items[] = $walk( $k, true );
			$out[] = array( 'g' => $g, 'items' => $items );
			return $out;
		}
		foreach ( $n['kids'] as $k ) {
			$out = array_merge( $out, $walk( $k, $repeat ) );
		}
		return $out;
	};
	$tree = $walk( 0, false );

	/* Cùng nội dung ở bản desktop và mobile: gộp một ô, sửa một lần */
	$seen = array();
	$drop = array();
	foreach ( $fields as $i => $f ) {
		if ( $f['repeat'] || 'alt' === $f['kind'] ) continue;
		$key = $f['kind'] . '|' . $f['value'];
		if ( isset( $seen[ $key ] ) ) {
			$fields[ $seen[ $key ] ]['ranges'][] = $f['ranges'][0];
			$drop[ $i ] = true;
		} else {
			$seen[ $key ] = $i;
		}
	}
	return array( 'fields' => $fields, 'tree' => $tree, 'groups' => $groups, 'nodes' => $nodes, 'drop' => $drop );
}

/** Áp các thay đổi: $edits = [ chỉ số trường => giá trị mới ]. */
function gfc_pe_apply_edits( $html, $edits ) {
	$p      = gfc_pe_parse( $html );
	$splice = array();
	$sync   = array();
	foreach ( $edits as $i => $v ) {
		$i = (int) $i;
		if ( ! isset( $p['fields'][ $i ] ) || isset( $p['drop'][ $i ] ) ) continue;
		$f = $p['fields'][ $i ];
		$v = (string) $v;
		if ( $v === (string) $f['value'] ) continue;
		/* Ô bỏ trống sẽ không còn hiện lại trên màn hình này: chỉ thẻ p, h1-h6 và mô tả ảnh được để trống */
		$can_empty = 'alt' === $f['kind'] || ( 'text' === $f['kind'] && in_array( $f['tag'], array( 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) );
		if ( '' === trim( $v ) && ! $can_empty ) continue;
		$old = substr( $html, $f['ranges'][0][0], $f['ranges'][0][1] - $f['ranges'][0][0] );
		switch ( $f['kind'] ) {
			case 'text':
				$new = gfc_pe_store_text( $v );
				if ( strlen( $old ) > 2 && false === strpos( $old, '<' ) ) $sync[] = array( '(?:value|data-[\w-]+)', $old, $new );
				break;
			case 'image':
				$new = esc_attr( gfc_pe_store_url( $v ) );
				$sync[] = array( '(?:srcset|data-[\w-]+)', $old, $new );
				break;
			case 'url':
			case 'embed':
				$new = esc_attr( gfc_pe_store_url( $v ) );
				break;
			case 'number':
				$new = (string) absint( $v );
				break;
			default:
				$new = esc_attr( sanitize_text_field( $v ) );
		}
		foreach ( $f['ranges'] as $r ) $splice[] = array( $r[0], $r[1], $new );
	}
	usort( $splice, function ( $a, $b ) { return $b[0] - $a[0]; } );
	foreach ( $splice as $s ) {
		$html = substr_replace( $html, $s[2], $s[0], $s[1] - $s[0] );
	}
	foreach ( $sync as $s ) {
		$res  = preg_replace_callback(
			'~\b' . $s[0] . '="\s*' . preg_quote( $s[1], '~' ) . '\s*"~',
			function ( $m ) use ( $s ) {
				$name = substr( $m[0], 0, strpos( $m[0], '=' ) );
				return $name . '="' . esc_attr( wp_strip_all_tags( str_replace( '<br>', ' ', $s[2] ) ) ) . '"';
			},
			$html
		);
		$html = null === $res ? $html : $res;
	}
	return $html;
}

function gfc_pe_clear_alt( $piece ) {
	return preg_replace( '~(<img\b[^>]*?\salt=")[^"]*~i', '$1', $piece );
}

/** Thêm, xoá, đổi vị trí một mục trong nhóm lặp. */
function gfc_pe_apply_op( $html, $g, $item, $action, $urls = array() ) {
	$p = gfc_pe_parse( $html );
	if ( ! isset( $p['groups'][ $g ]['items'][ $item ] ) ) return $html;
	$grp   = $p['groups'][ $g ];
	$nodes = $p['nodes'];
	$cur   = $nodes[ $grp['items'][ $item ] ];
	$piece = substr( $html, $cur['open'], $cur['end'] - $cur['open'] );
	$count = count( $grp['items'] );
	if ( 'dup' === $action ) {
		return substr_replace( $html, "\n" . gfc_pe_clear_alt( $piece ), $cur['end'], 0 );
	}
	if ( 'add_images' === $action ) {
		$new = '';
		foreach ( $urls as $url ) {
			$new .= "\n" . preg_replace( '~(<img\b[^>]*?\ssrc=")[^"]*~i', '${1}' . str_replace( '$', '\\$', $url ), gfc_pe_clear_alt( $piece ), 1 );
		}
		return substr_replace( $html, $new, $cur['end'], 0 );
	}
	if ( 'remove' === $action && $count > 1 ) {
		$html = substr_replace( $html, '', $cur['open'], $cur['end'] - $cur['open'] );
		if ( 2 === $count ) {
			$parent = $nodes[ $grp['node'] ];
			if ( null === gfc_pe_attr( $html, $parent, 'data-gfc-repeat' ) ) {
				$html = substr_replace( $html, ' data-gfc-repeat="1"', $parent['attr'][0], 0 );
			}
		}
		return $html;
	}
	$other = 'up' === $action ? $item - 1 : ( 'down' === $action ? $item + 1 : -1 );
	if ( isset( $grp['items'][ $other ] ) ) {
		$a  = $nodes[ $grp['items'][ min( $item, $other ) ] ];
		$b  = $nodes[ $grp['items'][ max( $item, $other ) ] ];
		$pa = substr( $html, $a['open'], $a['end'] - $a['open'] );
		$pb = substr( $html, $b['open'], $b['end'] - $b['open'] );
		$html = substr_replace( $html, $pa, $b['open'], $b['end'] - $b['open'] );
		$html = substr_replace( $html, $pb, $a['open'], $a['end'] - $a['open'] );
	}
	return $html;
}

/* ---------- Lưu ---------- */
add_action( 'admin_post_gfc_pe_save', function () {
	$id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	check_admin_referer( 'gfc_pe_save_' . $id );
	if ( ! current_user_can( 'edit_post', $id ) || ! current_user_can( 'unfiltered_html' ) ) wp_die( 'Không có quyền sửa trang này.' ); // WPBakery gỡ row Raw HTML khi người lưu thiếu quyền này
	/* Hai lần lưu cùng lúc phải chạy lần lượt, lần sau sẽ bị chặn ở bước so hash. Khoá tự nhả khi kết thúc request */
	$GLOBALS['wpdb']->get_var( $GLOBALS['wpdb']->prepare( 'SELECT GET_LOCK(%s, 30)', 'gfc_pe_' . $id ) );
	wp_cache_delete( $id, 'posts' );
	$content = (string) get_post_field( 'post_content', $id, 'raw' );
	$back    = array( 'page' => 'gfc-page-editor', 'post' => $id );
	$open    = isset( $_POST['open'] ) ? sanitize_text_field( wp_unslash( $_POST['open'] ) ) : '';
	if ( '' !== $open ) $back['open'] = $open;
	$hash = isset( $_POST['hash'] ) ? sanitize_text_field( wp_unslash( $_POST['hash'] ) ) : '';
	if ( md5( $content ) !== $hash ) {
		wp_safe_redirect( add_query_arg( $back + array( 'msg' => 'stale' ), admin_url( 'admin.php' ) ) );
		exit;
	}
	$edits = json_decode( isset( $_POST['edits'] ) ? wp_unslash( $_POST['edits'] ) : '{}', true ); // phpcs:ignore -- từng giá trị được làm sạch theo loại trường
	$op    = json_decode( isset( $_POST['op'] ) ? wp_unslash( $_POST['op'] ) : '', true ); // phpcs:ignore
	$edits = is_array( $edits ) ? $edits : array();
	if ( is_array( $op ) && isset( $op['row'], $op['g'], $op['item'], $op['action'] ) ) {
		$moved = array( 'dup' => 1, 'down' => 1, 'up' => -1, 'remove' => -1, 'add_images' => isset( $op['urls'] ) && is_array( $op['urls'] ) ? count( $op['urls'] ) : 0 );
		$act   = (string) $op['action'];
		$back['focus'] = (int) $op['row'] . '-' . (int) $op['g'] . '-' . max( 0, (int) $op['item'] + ( isset( $moved[ $act ] ) ? $moved[ $act ] : 0 ) );
	}
	$index = 0;
	$new   = preg_replace_callback(
		GFC_PE_RE_ROW,
		function ( $m ) use ( &$index, $edits, $op ) {
			$r    = $index++;
			$html = gfc_pe_decode( $m[1] );
			$next = $html;
			if ( ! empty( $edits[ $r ] ) && is_array( $edits[ $r ] ) ) $next = gfc_pe_apply_edits( $next, $edits[ $r ] );
			if ( is_array( $op ) && isset( $op['row'], $op['g'], $op['item'], $op['action'] ) && (int) $op['row'] === $r ) {
				$urls = array();
				foreach ( isset( $op['urls'] ) && is_array( $op['urls'] ) ? $op['urls'] : array() as $u ) {
					if ( is_string( $u ) && '' !== trim( $u ) ) $urls[] = esc_attr( gfc_pe_store_url( $u ) );
				}
				$next = gfc_pe_apply_op( $next, (int) $op['g'], (int) $op['item'], (string) $op['action'], $urls );
			}
			return $next === $html ? $m[0] : '[vc_raw_html]' . gfc_pe_encode( $next ) . '[/vc_raw_html]';
		},
		$content
	);
	if ( null === $new || $new === $content ) {
		wp_safe_redirect( add_query_arg( $back + array( 'msg' => 'same' ), admin_url( 'admin.php' ) ) );
		exit;
	}
	$res = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ), true );
	clean_post_cache( $id );
	$ok = ! is_wp_error( $res ) && (string) get_post_field( 'post_content', $id, 'raw' ) === $new;
	if ( ! $ok ) $back['why'] = rawurlencode( is_wp_error( $res ) ? $res->get_error_message() : 'Nội dung bị một plugin hoặc bộ lọc thay đổi khi lưu.' );
	wp_safe_redirect( add_query_arg( $back + array( 'msg' => $ok ? 'saved' : 'error' ), admin_url( 'admin.php' ) ) );
	exit;
} );

/* ---------- Giao diện ---------- */
add_action( 'admin_menu', function () {
	add_menu_page( 'Nội dung trang', 'Nội dung trang', 'unfiltered_html', 'gfc-page-editor', 'gfc_pe_screen', 'dashicons-edit-page', 4 );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( 'toplevel_page_gfc-page-editor' === $hook ) wp_enqueue_media();
} );

add_filter( 'page_row_actions', function ( $actions, $post ) {
	if ( false !== strpos( $post->post_content, '[vc_raw_html]' ) ) {
		$actions = array( 'gfc_pe' => '<a href="' . esc_url( admin_url( 'admin.php?page=gfc-page-editor&post=' . $post->ID ) ) . '">Sửa nội dung</a>' ) + $actions;
	}
	return $actions;
}, 10, 2 );

function gfc_pe_pages() {
	global $wpdb;
	$ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type='page' AND post_status IN ('publish','private') AND post_content LIKE '%[vc\_raw\_html]%' ORDER BY ID=" . (int) get_option( 'page_on_front' ) . ' DESC, post_title' ); // phpcs:ignore
	return array_map( 'get_post', array_map( 'intval', $ids ) );
}

function gfc_pe_label( $f ) {
	$tag = $f['tag'];
	switch ( $f['kind'] ) {
		case 'image':
			return 'bg' === $tag ? 'Ảnh nền' : 'Ảnh';
		case 'alt':
			return 'Mô tả ảnh (SEO)';
		case 'url':
			return 'Link';
		case 'embed':
			return 'Link video / bản đồ nhúng';
		case 'number':
			return 'Con số';
	}
	if ( in_array( $tag, array( 'h1', 'h2' ), true ) ) return 'Tiêu đề';
	if ( in_array( $tag, array( 'h3', 'h4', 'h5', 'h6' ), true ) ) return 'Tiêu đề nhỏ';
	if ( 'a' === $tag ) return 'Chữ trên nút / link';
	return mb_strlen( $f['value'] ) > 70 ? 'Đoạn văn' : 'Chữ';
}

/** Tên và hướng dẫn dễ hiểu cho từng khối, nhận diện theo class vì tiêu đề có thể bị sửa. */
function gfc_pe_row_meta( $html ) {
	$map = array(
		'home-right-swiper'  => array( 'Banner đầu trang', 'Đổi ảnh lớn ở danh sách "Ảnh slide". Nên dùng ảnh ngang, rộng từ 1200px, người đứng giữa ảnh.', 'Ảnh slide' ),
		'home-counter-section' => array( 'Các con số nổi bật', 'Chỉ nhập số, không nhập dấu chấm hay dấu cộng.', 'Con số' ),
		'home-photo-gallery' => array( 'Các dịch vụ nổi bật', 'Sửa tên và link của từng dịch vụ.', 'Dịch vụ' ),
		'data-media-marquee' => array( 'Logo khách hàng', 'Bấm "Thêm ảnh" để thêm nhiều logo cùng lúc. Nên dùng ảnh nền trong suốt, rộng khoảng 400px.', 'Logo' ),
		'certifications-awards-swiper' => array( 'Chứng nhận và giải thưởng', 'Bấm "Thêm ảnh" để thêm nhiều ảnh cùng lúc.', 'Ảnh chứng nhận' ),
		'puramu-branch-finder' => array( 'Hệ thống văn phòng', 'Danh sách văn phòng sửa ở menu Chi nhánh.', 'Văn phòng' ),
		'television-and-newspapers-swiper' => array( 'Báo chí đưa tin', 'Bấm "Thêm ảnh" để thêm nhiều logo cùng lúc.', 'Logo báo chí' ),
		'customer-feedback'  => array( 'Đánh giá của khách hàng', '', 'Đánh giá' ),
		'faq-accordion'      => array( 'Câu hỏi thường gặp', 'Mở từng câu để sửa câu hỏi và câu trả lời.', 'Câu hỏi' ),
	);
	foreach ( $map as $marker => $m ) {
		if ( false !== strpos( $html, $marker ) ) return array( 'title' => $m[0], 'help' => $m[1], 'list' => $m[2], 'marker' => $marker );
	}
	if ( false !== strpos( $html, 'youtube.com/embed' ) ) return array( 'title' => 'Giới thiệu công ty và video', 'help' => 'Xuống dòng trong ô chữ sẽ thành xuống dòng trên trang.', 'list' => 'Mục', 'marker' => '' );
	return array( 'title' => '', 'help' => '', 'list' => 'Mục', 'marker' => '' );
}

function gfc_pe_item_thumb( $entries, $fields ) {
	foreach ( $entries as $e ) {
		if ( isset( $e['f'] ) && 'image' === $fields[ $e['f'] ]['kind'] ) return $fields[ $e['f'] ]['value'];
	}
	return '';
}

function gfc_pe_row_title( $parsed, $html, $i ) {
	$meta = gfc_pe_row_meta( $html );
	if ( '' !== $meta['title'] ) return $meta['title'];
	foreach ( $parsed['fields'] as $f ) {
		if ( 'text' === $f['kind'] && in_array( $f['tag'], array( 'h1', 'h2' ), true ) ) return wp_strip_all_tags( str_replace( "\n", ' ', $f['value'] ) );
	}
	foreach ( $parsed['fields'] as $f ) {
		if ( 'text' === $f['kind'] ) return wp_trim_words( wp_strip_all_tags( str_replace( "\n", ' ', $f['value'] ) ), 12, '…' );
	}
	return 'Khối ' . ( $i + 1 );
}

function gfc_pe_item_title( $entries, $fields ) {
	foreach ( $entries as $e ) {
		if ( isset( $e['f'] ) && in_array( $fields[ $e['f'] ]['kind'], array( 'text' ), true ) ) return wp_trim_words( wp_strip_all_tags( $fields[ $e['f'] ]['value'] ), 12, '…' );
		if ( isset( $e['g'] ) ) foreach ( $e['items'] as $it ) {
			$t = gfc_pe_item_title( $it, $fields );
			if ( '' !== $t ) return $t;
		}
	}
	foreach ( $entries as $e ) {
		if ( isset( $e['f'] ) && 'image' === $fields[ $e['f'] ]['kind'] ) return wp_basename( $fields[ $e['f'] ]['value'] );
	}
	return '';
}

function gfc_pe_render_entries( $entries, $r, $p ) {
	foreach ( $entries as $e ) {
		if ( isset( $e['f'] ) ) {
			if ( isset( $p['drop'][ $e['f'] ] ) ) continue;
			$f    = $p['fields'][ $e['f'] ];
			$name = 'data-r="' . $r . '" data-f="' . (int) $e['f'] . '"';
			$big  = 'h1' === $f['tag'] || 'h2' === $f['tag'];
			echo '<div class="gfc-pe-field' . ( 'alt' === $f['kind'] ? ' is-alt' : '' ) . ( $big ? ' is-heading' : '' ) . '"><label>' . esc_html( gfc_pe_label( $f ) ) . '</label>';
			if ( 'image' === $f['kind'] ) {
				$thumb = preg_match( '~\.(png|jpe?g|gif|webp|svg)$~i', $f['value'] ) ? $f['value'] : '';
				echo '<div class="gfc-pe-img"><img src="' . esc_url( $thumb ) . '" alt=""><input type="text" class="widefat gfc-pe-input" ' . $name . ' value="' . esc_attr( $f['value'] ) . '"><button type="button" class="button gfc-pe-pick">Đổi ảnh</button></div>'; // phpcs:ignore -- $name chỉ gồm số
			} elseif ( 'text' === $f['kind'] ) {
				$rows = min( 12, max( 1, (int) ceil( mb_strlen( $f['value'] ) / 90 ) + substr_count( $f['value'], "\n" ) ) );
				echo '<textarea class="widefat gfc-pe-input" rows="' . (int) $rows . '" ' . $name . '>' . esc_textarea( $f['value'] ) . '</textarea>'; // phpcs:ignore
			} else {
				echo '<input type="' . ( 'number' === $f['kind'] ? 'number' : 'text' ) . '" class="widefat gfc-pe-input" ' . $name . ' value="' . esc_attr( $f['value'] ) . '">'; // phpcs:ignore
			}
			echo '</div>';
			continue;
		}
		$count = count( $e['items'] );
		$first = isset( $e['items'][0] ) ? gfc_pe_item_thumb( $e['items'][0], $p['fields'] ) : '';
		$cls   = gfc_pe_attr( $p['html'], $p['nodes'][ $p['groups'][ $e['g'] ]['node'] ], 'class' );
		$cls   = $cls ? $cls[0] : '';
		$list  = false !== strpos( $cls, 'row-rtl' ) ? 'Logo hàng trên' : ( false !== strpos( $cls, 'row-ltr' ) ? 'Logo hàng dưới' : ( false !== strpos( $cls, 'swiper-wrapper' ) || false !== strpos( $cls, 'question-container' ) ? $p['meta']['list'] : 'Danh sách' ) );
		echo '<div class="gfc-pe-group"><div class="gfc-pe-group-head">' . esc_html( $list ) . ' <span class="gfc-pe-count">(' . (int) $count . ' mục)</span>';
		$only_img = '' !== $first;
		foreach ( isset( $e['items'][0] ) ? $e['items'][0] : array() as $sub ) {
			if ( ! isset( $sub['f'] ) || 'text' === $p['fields'][ $sub['f'] ]['kind'] ) $only_img = false;
		}
		if ( $only_img ) echo ' <button type="button" class="button button-small button-primary gfc-pe-add" data-r="' . $r . '" data-g="' . (int) $e['g'] . '" data-i="' . ( $count - 1 ) . '">+ Thêm ảnh</button>'; // phpcs:ignore -- chỉ gồm số
		echo '</div>';
		foreach ( $e['items'] as $n => $item ) {
			$attr = 'data-r="' . $r . '" data-g="' . (int) $e['g'] . '" data-i="' . (int) $n . '"';
			$thumb = gfc_pe_item_thumb( $item, $p['fields'] );
			echo '<details class="gfc-pe-item" id="gfc-pe-i-' . $r . '-' . (int) $e['g'] . '-' . (int) $n . '"><summary><span class="gfc-pe-num">' . ( $n + 1 ) . '</span>' . ( '' !== $thumb ? ' <img class="gfc-pe-mini" src="' . esc_url( $thumb ) . '" alt="">' : '' ) . ' ' . esc_html( gfc_pe_item_title( $item, $p['fields'] ) ) . '</summary><div class="gfc-pe-tools">'; // phpcs:ignore -- $r chỉ gồm số
			echo '<button type="button" class="button button-small gfc-pe-op" data-op="up" ' . $attr . ( 0 === $n ? ' disabled' : '' ) . '>↑ Lên</button> '; // phpcs:ignore
			echo '<button type="button" class="button button-small gfc-pe-op" data-op="down" ' . $attr . ( $count - 1 === $n ? ' disabled' : '' ) . '>↓ Xuống</button> '; // phpcs:ignore
			echo '<button type="button" class="button button-small gfc-pe-op" data-op="dup" ' . $attr . '>Nhân bản</button> '; // phpcs:ignore
			echo '<button type="button" class="button button-small button-link-delete gfc-pe-op" data-op="remove" ' . $attr . ( 1 === $count ? ' disabled' : '' ) . '>Xoá mục này</button>'; // phpcs:ignore
			echo '</div>';
			gfc_pe_render_entries( $item, $r, $p );
			echo '</details>';
		}
		echo '</div>';
	}
}

function gfc_pe_screen() {
	$pages = gfc_pe_pages();
	$id    = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : ( $pages ? $pages[0]->ID : 0 ); // phpcs:ignore -- chỉ đọc
	if ( ! $id || ! current_user_can( 'edit_post', $id ) ) wp_die( 'Không có trang để sửa.' );
	$content = (string) get_post_field( 'post_content', $id, 'raw' );
	$rows    = gfc_pe_rows( $content );
	$open    = isset( $_GET['open'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_GET['open'] ) ) ) : array(); // phpcs:ignore
	$msg     = isset( $_GET['msg'] ) ? sanitize_key( $_GET['msg'] ) : ''; // phpcs:ignore
	$notes   = array(
		'saved' => array( 'success', 'Đã lưu. Bản trước vẫn nằm trong Revision của trang nếu cần khôi phục.' ),
		'same'  => array( 'info', 'Không có thay đổi mới. Các nút Lên, Xuống, Nhân bản, Xoá đã tự lưu ngay khi bấm.' ),
		'stale' => array( 'warning', 'Trang vừa được lưu ở nơi khác nên thay đổi lần này chưa được lưu. Hãy kiểm tra lại rồi nhập lại.' ),
		'error' => array( 'error', 'Chưa lưu được. Hãy kiểm tra lại nội dung trang rồi thử lại.' . ( isset( $_GET['why'] ) ? ' Lý do: ' . sanitize_text_field( rawurldecode( wp_unslash( $_GET['why'] ) ) ) : '' ) ), // phpcs:ignore -- chỉ hiển thị
	);
	?>
	<div class="wrap gfc-pe">
		<h1>Nội dung trang</h1>
		<?php if ( isset( $notes[ $msg ] ) ) echo '<div class="notice notice-' . esc_attr( $notes[ $msg ][0] ) . ' is-dismissible"><p>' . esc_html( $notes[ $msg ][1] ) . '</p></div>'; ?>
		<nav class="nav-tab-wrapper">
			<?php foreach ( $pages as $pg ) : ?>
				<a class="nav-tab<?php echo $pg->ID === $id ? ' nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=gfc-page-editor&post=' . $pg->ID ) ); ?>"><?php echo esc_html( $pg->post_title ); ?></a>
			<?php endforeach; ?>
		</nav>
		<p class="description">Sửa chữ hoặc đổi ảnh xong thì bấm <strong>Lưu thay đổi</strong>. Các nút Thêm ảnh, Lên, Xuống, Nhân bản, Xoá sẽ lưu ngay khi bấm. Tên công ty, số điện thoại, địa chỉ văn phòng sửa ở <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=gfc_contact' ) ); ?>">Thông tin công ty</a>; danh sách chi nhánh sửa ở <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=gfc_branch' ) ); ?>">Chi nhánh</a>. Xem thêm <a href="<?php echo esc_url( admin_url( 'admin.php?page=gfc-guide#noi-dung' ) ); ?>">Hướng dẫn sử dụng</a>.</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="gfc-pe-form" autocomplete="off">
			<input type="hidden" name="action" value="gfc_pe_save">
			<input type="hidden" name="post_id" value="<?php echo (int) $id; ?>">
			<input type="hidden" name="hash" value="<?php echo esc_attr( md5( $content ) ); ?>">
			<input type="hidden" name="edits" value="">
			<input type="hidden" name="op" value="">
			<input type="hidden" name="open" value="">
			<?php wp_nonce_field( 'gfc_pe_save_' . $id ); ?>
			<?php
			foreach ( $rows as $r => $html ) {
				$p = gfc_pe_parse( $html );
				if ( ! $p['fields'] ) continue;
				$p['html'] = $html;
				$p['meta'] = gfc_pe_row_meta( $html );
				$off = (int) get_option( 'page_on_front' ) === $id && in_array( $p['meta']['marker'], gfc_home_hidden_markers(), true );
				echo '<details class="gfc-pe-row" data-row="' . (int) $r . '"' . ( in_array( (string) $r, $open, true ) ? ' open' : '' ) . '><summary>' . esc_html( gfc_pe_row_title( $p, $html, $r ) ) . ( $off ? ' <span class="gfc-pe-off">Đang ẩn trên trang</span>' : '' ) . '</summary><div class="gfc-pe-body">';
				if ( '' !== $p['meta']['help'] ) echo '<p class="gfc-pe-help">' . esc_html( $p['meta']['help'] ) . '</p>';
				gfc_pe_render_entries( $p['tree'], $r, $p );
				echo '</div></details>';
			}
			?>
			<div class="gfc-pe-bar">
				<button type="submit" class="button button-primary button-large">Lưu thay đổi</button>
				<a class="button button-large" target="_blank" rel="noopener" href="<?php echo esc_url( 'private' === get_post_status( $id ) ? home_url( '/dich-vu-gfc' ) : get_permalink( $id ) ); ?>">Xem trang</a>
				<?php $revs = wp_get_post_revisions( $id, array( 'posts_per_page' => 1 ) ); ?>
				<?php if ( $revs ) : ?>
					<a class="button-link" href="<?php echo esc_url( get_edit_post_link( key( $revs ) ) ); ?>">Khôi phục bản trước</a>
				<?php endif; ?>
				<span class="gfc-pe-dirty" hidden>Có thay đổi chưa lưu</span>
			</div>
		</form>
	</div>
	<style>
	.gfc-pe .description{margin:14px 0}
	.gfc-pe-row{background:#fff;border:1px solid #dcdcde;margin-bottom:8px}
	.gfc-pe-row>summary{cursor:pointer;padding:12px 16px;font-size:14px;font-weight:600}
	.gfc-pe-body{padding:4px 16px 16px;border-top:1px solid #f0f0f1}
	.gfc-pe-field{margin:12px 0}
	.gfc-pe-field>label{display:block;font-weight:600;margin-bottom:4px}
	.gfc-pe-field.is-alt>label{font-weight:400;color:#646970}
	.gfc-pe-field.is-heading textarea{font-size:15px;font-weight:600}
	.gfc-pe-img{display:flex;gap:8px;align-items:center}
	.gfc-pe-img img{width:120px;height:80px;object-fit:contain;background:#f0f0f1;border:1px solid #dcdcde;flex:none}
	.gfc-pe-img input{display:none}
	.gfc-pe-help{margin:12px 0 0;padding:8px 12px;background:#f0f6fc;border-left:3px solid #72aee6}
	.gfc-pe-off{margin-left:8px;padding:2px 8px;border-radius:10px;background:#f0f0f1;color:#50575e;font-size:12px;font-weight:400}
	.gfc-pe-count{font-weight:400;color:#646970}
	.gfc-pe-add{margin-left:8px!important}
	.gfc-pe-mini{width:44px;height:28px;object-fit:contain;background:#f0f0f1;vertical-align:middle;margin:0 4px}
	.gfc-pe-item.is-focus{outline:2px solid #2271b1}
	.gfc-pe-group{margin:14px 0;border-left:3px solid #2271b1;padding-left:12px}
	.gfc-pe-group-head{font-weight:600;margin-bottom:6px}
	.gfc-pe-item{border:1px solid #e0e0e0;margin-bottom:4px;background:#fafafa}
	.gfc-pe-item>summary{cursor:pointer;padding:7px 10px}
	.gfc-pe-item[open]{background:#fff;padding:0 10px 8px}
	.gfc-pe-item[open]>summary{margin:0 -10px;background:#f6f7f7}
	.gfc-pe-num{display:inline-block;min-width:20px;color:#646970}
	.gfc-pe-tools{margin-top:8px}
	.gfc-pe-bar{position:sticky;bottom:0;background:#f0f0f1;padding:12px 0;display:flex;gap:12px;align-items:center;flex-wrap:wrap;z-index:5}
	.gfc-pe-dirty{color:#b32d2e;font-weight:600}
	.gfc-pe.is-sending .button{pointer-events:none;opacity:.5}
	.gfc-pe.is-sending .gfc-pe-dirty{color:#1d2327}
	</style>
	<script>
	jQuery(function ($) {
		var form = $('#gfc-pe-form');
		var dirty = false;
		var sending = false;
		form.find('[name=op]').val('');
		function changed(el) { return el.value !== el.defaultValue; }
		function collect() {
			var out = {};
			form.find('.gfc-pe-input').each(function () {
				if (!changed(this)) return;
				var r = this.getAttribute('data-r');
				(out[r] = out[r] || {})[this.getAttribute('data-f')] = this.value;
			});
			return out;
		}
		function openRows() {
			return form.find('.gfc-pe-row[open]').map(function () { return this.getAttribute('data-row'); }).get().join(',');
		}
		form.on('input', '.gfc-pe-input', function () {
			dirty = Object.keys(collect()).length > 0;
			$('.gfc-pe-dirty').prop('hidden', !dirty);
		});
		/* Mỗi lần chỉ gửi một yêu cầu: bấm tiếp khi chưa xong sẽ làm hai lần lưu chồng nhau */
		form.on('submit', function (e) {
			if (sending) { e.preventDefault(); return; }
			sending = true;
			form.find('[name=edits]').val(JSON.stringify(collect()));
			form.find('[name=open]').val(openRows());
			dirty = false;
			$('.gfc-pe').addClass('is-sending');
			$('.gfc-pe-dirty').text('Đang lưu, vui lòng chờ…').prop('hidden', false);
		});
		form.on('click', '.gfc-pe-op', function () {
			var b = this, op = b.getAttribute('data-op');
			if (sending) return;
			if (op === 'remove' && !window.confirm('Xoá mục này khỏi trang?')) return;
			form.find('[name=op]').val(JSON.stringify({ row: +b.getAttribute('data-r'), g: +b.getAttribute('data-g'), item: +b.getAttribute('data-i'), action: op }));
			form.trigger('submit');
		});
		/* Quay lại bằng nút Back: tải lại để lấy nội dung và hash mới nhất */
		window.addEventListener('pageshow', function (e) {
			if (e.persisted) window.location.reload();
		});
		form.on('click', '.gfc-pe-add', function () {
			var b = this;
			if (sending) return;
			var frame = wp.media({ title: 'Chọn một hoặc nhiều ảnh', multiple: 'add', library: { type: 'image' }, button: { text: 'Thêm vào danh sách' } });
			frame.on('select', function () {
				var urls = frame.state().get('selection').map(function (a) { return a.toJSON().url; });
				if (!urls.length) return;
				form.find('[name=op]').val(JSON.stringify({ row: +b.getAttribute('data-r'), g: +b.getAttribute('data-g'), item: +b.getAttribute('data-i'), action: 'add_images', urls: urls }));
				form.trigger('submit');
			});
			frame.open();
		});
		var focus = new URLSearchParams(window.location.search).get('focus');
		if (focus) {
			var item = document.getElementById('gfc-pe-i-' + focus);
			if (item) {
				item.open = true;
				item.classList.add('is-focus');
				item.scrollIntoView({ block: 'center' });
			}
		}
		form.on('click', '.gfc-pe-pick', function () {
			var input = $(this).prev('input'), img = $(this).siblings('img');
			var frame = wp.media({ title: 'Chọn ảnh', multiple: false, library: { type: 'image' } });
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				input.val(url).trigger('input');
				img.attr('src', url);
			});
			frame.open();
		});
		window.addEventListener('beforeunload', function (e) {
			if (dirty) { e.preventDefault(); e.returnValue = ''; }
		});
	});
	</script>
	<?php
}
