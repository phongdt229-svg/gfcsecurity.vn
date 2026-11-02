<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main class="mt-16 lg:mt-30">
	<section class="container mx-auto px-4 py-10 lg:py-20 text-center">
		<h1 class="text-2xl lg:text-[40px] font-semibold font-sans uppercase">Không tìm thấy trang</h1>
		<p class="mt-4"><a class="text-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Về trang chủ</a></p>
	</section>
</main>
<?php
get_footer();
