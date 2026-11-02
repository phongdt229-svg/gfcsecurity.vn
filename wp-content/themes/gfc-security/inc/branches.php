<?php
/** Mục "Chi nhánh" — quản lý 63 văn phòng đại diện trong admin. */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'gfc_branch', array(
		'labels' => array(
			'name'          => 'Chi nhánh',
			'singular_name' => 'Chi nhánh',
			'add_new'       => 'Thêm chi nhánh',
			'add_new_item'  => 'Thêm chi nhánh mới',
			'edit_item'     => 'Sửa chi nhánh',
			'all_items'     => 'Tất cả chi nhánh',
		),
		'public'        => false,
		'show_ui'       => true,
		'menu_icon'     => 'dashicons-location',
		'menu_position' => 25,
		'supports'      => array( 'title', 'page-attributes' ),
	) );
} );

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'gfc_branch_info', 'Thông tin chi nhánh', 'gfc_branch_box', 'gfc_branch', 'normal', 'high' );
} );

function gfc_branch_box( $post ) {
	wp_nonce_field( 'gfc_branch_save', 'gfc_branch_nonce' );
	$fields = array(
		'gfc_address' => 'Địa chỉ',
		'gfc_phone'   => 'Số điện thoại (không bắt buộc)',
		'gfc_url'     => 'Link trang dịch vụ tỉnh (không bắt buộc)',
	);
	foreach ( $fields as $k => $label ) {
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" class="widefat" id="%1$s" name="%1$s" value="%3$s"></p>',
			esc_attr( $k ), esc_html( $label ), esc_attr( get_post_meta( $post->ID, $k, true ) )
		);
	}
	echo '<p class="description">Tên chi nhánh = Tiêu đề. Thứ tự hiển thị chỉnh ở ô "Thứ tự" bên phải.</p>';
}

add_action( 'save_post_gfc_branch', function ( $post_id ) {
	if ( ! isset( $_POST['gfc_branch_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gfc_branch_nonce'] ) ), 'gfc_branch_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	update_post_meta( $post_id, 'gfc_address', isset( $_POST['gfc_address'] ) ? sanitize_text_field( wp_unslash( $_POST['gfc_address'] ) ) : '' );
	update_post_meta( $post_id, 'gfc_phone', isset( $_POST['gfc_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['gfc_phone'] ) ) : '' );
	update_post_meta( $post_id, 'gfc_url', isset( $_POST['gfc_url'] ) ? esc_url_raw( wp_unslash( $_POST['gfc_url'] ) ) : '' );
} );

/** Danh sách chi nhánh: lấy từ admin, nếu trống thì dùng danh sách mặc định. */
function gfc_get_branches() {
	$q = get_posts( array(
		'post_type'      => 'gfc_branch',
		'posts_per_page' => 200,
		'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		'post_status'    => 'publish',
	) );
	if ( ! $q ) {
		return array_map( function ( $b ) {
			return array( 'name' => $b[0], 'address' => $b[1], 'phone' => '', 'url' => '' );
		}, gfc_default_branches() );
	}
	$out = array();
	foreach ( $q as $p ) {
		$out[] = array(
			'name'    => get_the_title( $p ),
			'address' => get_post_meta( $p->ID, 'gfc_address', true ),
			'phone'   => get_post_meta( $p->ID, 'gfc_phone', true ),
			'url'     => get_post_meta( $p->ID, 'gfc_url', true ),
		);
	}
	return $out;
}

/** Tạo sẵn các chi nhánh mặc định lần đầu kích hoạt theme (chỉ khi mục còn trống). */
add_action( 'after_switch_theme', function () {
	if ( get_posts( array( 'post_type' => 'gfc_branch', 'posts_per_page' => 1, 'post_status' => 'any' ) ) ) return;
	$i = 0;
	foreach ( gfc_default_branches() as $b ) {
		$id = wp_insert_post( array(
			'post_type'   => 'gfc_branch',
			'post_title'  => $b[0],
			'post_status' => 'publish',
			'menu_order'  => $i++,
		) );
		if ( $id && ! is_wp_error( $id ) ) update_post_meta( $id, 'gfc_address', $b[1] );
	}
} );
