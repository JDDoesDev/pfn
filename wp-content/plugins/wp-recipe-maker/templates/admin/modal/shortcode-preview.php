<?php
/**
 * Template for the recipe shortcode preview.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/modal
 */

?>
<?php
$image = $recipe->image( array( 100, 100 ) );
if ( $image ) :
?>
	<span contentEditable="false" style="display: inline-block; float: left; margin: 0 10px 10px 0;"><?php echo wp_kses_post( $image ); ?></span>
<?php endif; // Image. ?>
<span contentEditable="false" style="display: inline-block; margin-bottom: 10px;"><?php echo esc_html( $recipe->name() ); ?></span>
<span contentEditable="false" style="display: block; margin-bottom: 10px;"><?php echo esc_html( strip_shortcodes( wp_strip_all_tags( $recipe->summary() ) ) ); ?></span>
<span contentEditable="false" style="display: block; clear: both; height: 1px; line-height: 1px;">&nbsp;</span>
