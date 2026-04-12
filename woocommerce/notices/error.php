<?php
/**
 * Rezon8 2025 Material — WooCommerce error notice.
 * @package rezon8-25-material
 */
defined( 'ABSPATH' ) || exit;
if ( ! $notices ) return;
?>
<?php foreach ( $notices as $notice ) : ?>
<div class="r8-notice r8-notice--error woocommerce-error" role="alert" style="background:#fff0f0;border-left:4px solid #b00020;padding:1rem 1.5rem;border-radius:8px;margin:1rem 0">
	<?php echo wp_kses_post( wc_kses_notice( $notice['notice'] ) ); ?>
</div>
<?php endforeach; ?>
