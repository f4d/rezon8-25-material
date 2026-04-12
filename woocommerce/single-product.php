<?php
/**
 * Rezon8 2025 Material — WooCommerce single-product.php
 *
 * @package rezon8-25-material
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main r8-woo-single">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
