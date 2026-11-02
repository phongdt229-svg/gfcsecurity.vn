<?php
/** Bộ icon SVG nội tuyến (stroke = currentColor). */
if ( ! defined( 'ABSPATH' ) ) exit;

function gfc_icon( $name, $class = '' ) {
	$p = array(
		'trophy'   => '<path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4Z"/><path d="M17 5h3v2a3 3 0 0 1-3 3M7 5H4v2a3 3 0 0 0 3 3"/>',
		'phone'    => '<rect x="6" y="2" width="12" height="20" rx="2"/><path d="M11 18h2"/><path d="m9.5 10 2 2 3.5-4"/>',
		'money'    => '<circle cx="12" cy="10" r="6"/><path d="M14 8h-3a1.5 1.5 0 0 0 0 3h2a1.5 1.5 0 0 1 0 3h-3M12 6.5v1.5M12 14v1.5"/><path d="M3 20c2-1.5 4-2 6-2h6c2 0 4 .5 6 2"/>',
		'network'  => '<circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="17" r="2.5"/><circle cx="19" cy="17" r="2.5"/><path d="M12 7.5V12M12 12l-5 3M12 12l5 3"/>',
		'star'     => '<path d="m12 3 2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 16.4 6.8 19.1l1-5.8L3.5 9.2l5.9-.9L12 3Z"/>',
		'guard'    => '<path d="M12 3 4 6v6c0 4.5 3.4 8.3 8 9 4.6-.7 8-4.5 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
		'pin'      => '<path d="M12 22s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"/><circle cx="12" cy="10" r="2.5"/>',
		'call'     => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2Z"/>',
		'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'clock24'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'chevron'  => '<path d="m6 9 6 6 6-6"/>',
		'prev'     => '<path d="m15 18-6-6 6-6"/>',
		'next'     => '<path d="m9 18 6-6-6-6"/>',
		'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/>',
		'job'      => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 13h18"/>',
		'headset'  => '<path d="M4 15v-3a8 8 0 0 1 16 0v3"/><rect x="2" y="14" width="5" height="6" rx="1.5"/><rect x="17" y="14" width="5" height="6" rx="1.5"/>',
		'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
		'menu'     => '<path d="M4 6h16M4 12h16M4 18h16"/>',
		'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
		'shield'   => '<path d="M12 3 4 6v6c0 4.5 3.4 8.3 8 9 4.6-.7 8-4.5 8-9V6l-8-3Z"/>',
		'play'     => '<path d="M8 5v14l11-7L8 5Z"/>',
	);
	if ( ! isset( $p[ $name ] ) ) return '';
	$fill = ( 'play' === $name ) ? 'currentColor' : 'none';
	return '<svg class="gfc-ic ' . esc_attr( $class ) . '" viewBox="0 0 24 24" width="24" height="24" fill="' . $fill . '" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p[ $name ] . '</svg>';
}
