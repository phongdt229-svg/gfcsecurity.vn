<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<article class="gfc-card">
	<a class="gfc-card__img" href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); } ?>
	</a>
	<h3 class="gfc-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="gfc-card__excerpt"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
	<span class="gfc-card__date"><?php echo gfc_icon( 'calendar' ); // phpcs:ignore ?> <?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span>
</article>
