<?php
/** Danh sách chi nhánh có ô chọn tỉnh/thành và tìm kiếm. */
if ( ! defined( 'ABSPATH' ) ) exit;
$branches = gfc_get_branches();
?>
<div class="gfc-branches__list js-branch-finder">
	<form class="gfc-bfinder" action="#" role="search">
		<select class="js-branch-select" aria-label="Chọn tỉnh/thành phố">
			<option value="">Chọn tỉnh/thành phố</option>
			<?php foreach ( $branches as $b ) : ?><option value="<?php echo esc_attr( $b['name'] ); ?>"><?php echo esc_html( $b['name'] ); ?></option><?php endforeach; ?>
		</select>
		<input class="js-branch-search" type="text" placeholder="Tìm kiếm chi nhánh" aria-label="Tìm kiếm chi nhánh">
	</form>
	<p class="gfc-branches__count"><?php echo esc_html( gfc_home_data()['branches_count'] ); ?></p>
	<ul>
		<?php foreach ( $branches as $b ) : ?>
			<li data-branch="<?php echo esc_attr( $b['name'] ); ?>">
				<span class="pin"><?php echo gfc_icon( 'pin' ); // phpcs:ignore ?></span>
				<div>
					<?php if ( $b['url'] ) : ?><a href="<?php echo esc_url( $b['url'] ); ?>"><strong><?php echo esc_html( $b['name'] ); ?></strong></a><?php else : ?><strong><?php echo esc_html( $b['name'] ); ?></strong><?php endif; ?>
					<span><?php echo esc_html( $b['address'] ); ?></span>
					<?php if ( $b['phone'] ) : ?><a href="<?php echo esc_attr( gfc_tel( $b['phone'] ) ); ?>"><?php echo esc_html( $b['phone'] ); ?></a><?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
