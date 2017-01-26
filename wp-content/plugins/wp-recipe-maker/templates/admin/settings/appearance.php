<?php
/**
 * Template for the appearance settings sub page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/settings
 */

?>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="wprm_settings_appearance">
	<?php wp_nonce_field( 'wprm_settings', 'wprm_settings', false ); ?>
	<h2 class="title"><?php esc_html_e( 'Recipe Fields', 'wp-recipe-maker' ); ?></h2>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Recipe Image', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="recipe_image_use_featured">
						<?php $checked = WPRM_Settings::get( 'recipe_image_use_featured' ) ? ' checked="checked"' : ''; ?>
						<input name="recipe_image_use_featured" type="checkbox" id="recipe_image_use_featured"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Use featured image of parent post if no recipe image is set', 'wp-recipe-maker' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="recipe_author_display_default"><?php esc_html_e( 'Default for Author', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<select id="recipe_author_display_default" name="recipe_author_display_default">
						<?php
						$options = array(
							'disabled' => __( "Don't show", 'wp-recipe-maker' ),
							'post_author' => __( 'Name of post author', 'wp-recipe-maker' ),
							'custom' => __( 'Custom author name', 'wp-recipe-maker' ),
						);

						$setting = WPRM_Settings::get( 'recipe_author_display_default' );
						foreach ( $options as $option => $label ) {
							$selected = $setting === $option ? ' selected="selected"' : '';
							echo '<option value="' . esc_attr( $option ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Nutrition Label', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="show_nutrition_label">
						<?php $checked = WPRM_Settings::get( 'show_nutrition_label' ) ? ' checked="checked"' : ''; ?>
						<input name="show_nutrition_label" type="checkbox" id="show_nutrition_label"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Display in recipe template', 'wp-recipe-maker' ); ?>
					</label>
					<p class="description">
						<?php if ( ! WPRM_Addons::is_active( 'premium' ) ) : ?>
						<?php esc_html_e( 'Only available in', 'wp-recipe-maker' ); ?> <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/" target="_blank">WP Recipe Maker Premium</a>.
						<?php else : ?>
						<?php esc_html_e( 'Display the nutrition label at its default location in the recipe template.', 'wp-recipe-maker' ); ?>
						<?php endif; ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<h2 class="title"><?php esc_html_e( 'Recipe Template Options', 'wp-recipe-maker' ); ?></h2>
	<p>
		<?php esc_html_e( 'Note: not all options will affect every recipe template.', 'wp-recipe-maker' ); ?>
	</p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="template_color_background"><?php esc_html_e( 'Background Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_background" type="text" id="template_color_background" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_background' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_background' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_border"><?php esc_html_e( 'Border Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_border" type="text" id="template_color_border" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_border' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_border' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_text"><?php esc_html_e( 'Text Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_text" type="text" id="template_color_text" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_text' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_text' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_link"><?php esc_html_e( 'Link Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_link" type="text" id="template_color_link" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_link' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_link' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_header"><?php esc_html_e( 'Header Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_header" type="text" id="template_color_header" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_header' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_header' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_icon"><?php esc_html_e( 'Icon Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_icon" type="text" id="template_color_icon" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_icon' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_icon' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_accent"><?php esc_html_e( 'Accent Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_accent" type="text" id="template_color_accent" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_accent' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_accent' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_accent_text"><?php esc_html_e( 'Accent Text Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_accent_text" type="text" id="template_color_accent_text" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_accent_text' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_accent_text' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_accent2"><?php esc_html_e( 'Accent 2 Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_accent2" type="text" id="template_color_accent2" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_accent2' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_accent2' ) ); ?>" class="wprm-color">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="template_color_accent2_text"><?php esc_html_e( 'Accent 2 Text Color', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="template_color_accent2_text" type="text" id="template_color_accent2_text" value="<?php echo esc_attr( WPRM_Settings::get( 'template_color_accent2_text' ) ); ?>" data-default-color="<?php echo esc_attr( WPRM_Settings::get_default( 'template_color_accent2_text' ) ); ?>" class="wprm-color">
				</td>
			</tr>
		</tbody>
	</table>
	<h2 class="title"><?php esc_html_e( 'Recipe Template', 'wp-recipe-maker' ); ?></h2>
	<p>
		<?php esc_html_e( 'Change the look of recipes on your website.', 'wp-recipe-maker' ); ?>
	</p>
	<?php
	$templates = WPRM_Template_Manager::get_templates();
	?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="default_recipe_template"><?php esc_html_e( 'Default Recipe Template', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<select id="default_recipe_template" name="default_recipe_template">
						<?php
						$setting = WPRM_Settings::get( 'default_recipe_template' );
						foreach ( $templates as $template ) {
							$selected = $setting === $template['slug'] ? ' selected="selected"' : '';
							echo '<option value="' . esc_attr( $template['slug'] ) . '"' . esc_attr( $selected ) . '>' . esc_html( $template['name'] ) . '</option>';
						}
						?>
					</select>
					<p class="description" id="tagline-default_recipe_template">
						<?php esc_html_e( 'The default template to use for recipes on your website.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="default_print_template"><?php esc_html_e( 'Default Print Template', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<select id="default_print_template" name="default_print_template">
						<?php
						$setting = WPRM_Settings::get( 'default_print_template' );
						foreach ( $templates as $template ) {
							$selected = $setting === $template['slug'] ? ' selected="selected"' : '';
							echo '<option value="' . esc_attr( $template['slug'] ) . '"' . esc_attr( $selected ) . '>' . esc_html( $template['name'] ) . '</option>';
						}
						?>
					</select>
					<p class="description" id="tagline-default_print_template">
						<?php esc_html_e( 'The default template to use when printing a recipe.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="print_credit"><?php esc_html_e( 'Print Credit', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<textarea name="print_credit" rows="2" cols="50" id="print_credit" class="large-text code"><?php echo esc_html( WPRM_Settings::get( 'print_credit' ) ); ?></textarea>
					<p class="description" id="tagline-print_credit">
						<?php esc_html_e( 'Optional text to show at the bottom of the print page.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<?php if ( ! WPRM_Addons::is_active( 'premium' ) ) : ?>
			<tr>
				<th scope="row">
					<label>Want more templates?</label>
				</th>
				<td>
					<p class="description">
						Get <a href="http://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/" target="_blank">WP Recipe Maker Premium</a> for Premium templates and more!
					</p>
				</td>
			</tr>
			<?php endif; // Premium not active. ?>
			<tr>
				<td colspan="2" class="template-preview-container">
					<?php
					foreach ( $templates as $template ) {
						echo '<div class="template-preview">';
						echo '<div class="template-name">' . esc_html( $template['name'] ) . '</div>';
						if ( $template['screenshot'] ) {
							$image_url = $template['url'] . '/' . $template['slug'] . '.' . $template['screenshot'];
							echo '<img src="' . esc_url( $image_url ) . '" class="template-screenshot" width="250" />';
						} else {
							echo '<div class="template-no-screenshot">' . esc_html__( 'No Screenshot', 'wp-recipe-maker' ) . '</div>';
						}
						echo '</div>';
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php submit_button( __( 'Save Changes', 'wp-recipe-maker' ) ); ?>
</form>
