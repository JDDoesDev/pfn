<?php
/**
 * Santize recipe input fields.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Santize recipe input fields.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Recipe_Sanitizer {

	/**
	 * Sanitize recipe array.
	 *
	 * @since    1.0.0
	 * @param		 array $recipe Array containing all recipe input data.
	 */
	public static function sanitize( $recipe ) {
		$sanitized_recipe = array();

		// Text fields.
		$sanitized_recipe['name'] = isset( $recipe['name'] ) ? sanitize_text_field( $recipe['name'] ) : '';
		$sanitized_recipe['summary'] = isset( $recipe['summary'] ) ? wp_kses_post( $recipe['summary'] ) : '';
		$sanitized_recipe['author_name'] = isset( $recipe['author_name'] ) ? sanitize_text_field( $recipe['author_name'] ) : '';
		$sanitized_recipe['servings_unit'] = isset( $recipe['servings_unit'] ) ? sanitize_text_field( $recipe['servings_unit'] ) : '';
		$sanitized_recipe['notes'] = isset( $recipe['notes'] ) ? wp_kses_post( $recipe['notes'] ) : '';

		// Number fields.
		$sanitized_recipe['image_id'] = isset( $recipe['image_id'] ) ? intval( $recipe['image_id'] ) : 0;
		$sanitized_recipe['servings'] = isset( $recipe['servings'] ) ? intval( $recipe['servings'] ) : 0;
		$sanitized_recipe['prep_time'] = isset( $recipe['prep_time'] ) ? intval( $recipe['prep_time'] ) : 0;
		$sanitized_recipe['cook_time'] = isset( $recipe['cook_time'] ) ? intval( $recipe['cook_time'] ) : 0;
		$sanitized_recipe['total_time'] = isset( $recipe['total_time'] ) ? intval( $recipe['total_time'] ) : 0;

		// Limited options fields.
		$options = array( 'default', 'disabled', 'post_author', 'custom' );
		$sanitized_recipe['author_display'] = isset( $recipe['author_display'] ) && in_array( $recipe['author_display'], $options, true ) ? sanitize_key( $recipe['author_display'] ) : $options[0];

		// Recipe Tags.
		$sanitized_recipe['tags'] = array();
		$taxonomies = WPRM_Taxonomies::get_taxonomies();
		foreach ( $taxonomies as $taxonomy => $options ) {
			$key = substr( $taxonomy, 5 ); // Get rid of wprm_.
			$sanitized_recipe['tags'][ $key ] = isset( $recipe['tags'] ) && isset( $recipe['tags'][ $key ] ) && $recipe['tags'][ $key ] ? array_map( array( __CLASS__, 'sanitize_tags' ), $recipe['tags'][ $key ] ) : array();
		}

		// Recipe Ingredients.
		$sanitized_recipe['ingredients'] = array();

		if ( isset( $recipe['ingredients'] ) ) {
			foreach ( $recipe['ingredients'] as $ingredient_group ) {
				$sanitized_group = array(
					'ingredients' => array(),
					'name' => isset( $ingredient_group['name'] ) ? sanitize_text_field( $ingredient_group['name'] ) : '',
				);

				if ( isset( $ingredient_group['ingredients'] ) ) {
					foreach ( $ingredient_group['ingredients'] as $ingredient ) {
						if ( isset( $ingredient['raw'] ) && ! isset( $ingredient['name'] ) ) {
							$ingredient = WPRM_Recipe_Parser::parse_ingredient( $ingredient['raw'] );
						}

						$sanitized_ingredient = array(
							'amount' => isset( $ingredient['amount'] ) ? sanitize_text_field( $ingredient['amount'] ) : '',
							'unit' => isset( $ingredient['unit'] ) ? sanitize_text_field( $ingredient['unit'] ) : '',
							'name' => isset( $ingredient['name'] ) ? sanitize_text_field( $ingredient['name'] ) : '',
							'notes' => isset( $ingredient['notes'] ) ? sanitize_text_field( $ingredient['notes'] ) : '',
						);

						// Get ingredient ID from name.
						if ( $sanitized_ingredient['name'] ) {
							$term = term_exists( $sanitized_ingredient['name'], 'wprm_ingredient' ); // @codingStandardsIgnoreLine

							if ( 0 === $term || null === $term ) {
								$term = wp_insert_term( $sanitized_ingredient['name'], 'wprm_ingredient' );
							}

							if ( is_wp_error( $term ) ) {
								if ( isset( $term->error_data['term_exists'] ) ) {
									$term_id = $term->error_data['term_exists'];
								} else {
									$term_id = 0;
								}
							} else {
								$term_id = $term['term_id'];
							}

							$sanitized_ingredient['id'] = intval( $term_id );

							$sanitized_group['ingredients'][] = $sanitized_ingredient;
						}
					}
				}

				if ( count( $sanitized_group['ingredients'] ) > 0 ) {
						$sanitized_recipe['ingredients'][] = $sanitized_group;
				}
			}
		}

		// Recipe Instructions.
		$sanitized_recipe['instructions'] = array();

		if ( isset( $recipe['instructions'] ) ) {
			foreach ( $recipe['instructions'] as $instruction_group ) {
				$sanitized_group = array(
					'instructions' => array(),
					'name' => isset( $instruction_group['name'] ) ? sanitize_text_field( $instruction_group['name'] ) : '',
				);

				if ( isset( $instruction_group['instructions'] ) ) {
					foreach ( $instruction_group['instructions'] as $instruction ) {
						$sanitized_instruction = array(
							'text' => isset( $instruction['text'] ) ? wp_kses_post( $instruction['text'] ) : '',
							'image' => isset( $instruction['image'] ) ? intval( $instruction['image'] ) : 0,
						);

						if ( $sanitized_instruction['text'] || $sanitized_instruction['image'] ) {
							$sanitized_group['instructions'][] = $sanitized_instruction;
						}
					}
				}

				if ( count( $sanitized_group['instructions'] ) > 0 ) {
						$sanitized_recipe['instructions'][] = $sanitized_group;
				}
			}
		}

		// Recipe Nutrition.
		$sanitized_recipe['nutrition'] = array();

		if ( isset( $recipe['nutrition'] ) ) {
			$nutrition_fields = array(
				'serving_size',
				'calories',
				'carbohydrates',
				'protein',
				'fat',
				'saturated_fat',
				'polyunsaturated_fat',
				'monounsaturated_fat',
				'trans_fat',
				'cholesterol',
				'sodium',
				'potassium',
				'fiber',
				'sugar',
				'vitamin_a',
				'vitamin_c',
				'calcium',
				'iron',
			);

			foreach ( $nutrition_fields as $field ) {
				$sanitized_recipe['nutrition'][ $field ] = isset( $recipe['nutrition'][ $field ] ) && '' !== trim( $recipe['nutrition'][ $field ] ) ? floatval( str_replace( ',', '.', $recipe['nutrition'][ $field ] ) ) : false;
			}
		}

		// Other fields.
		$sanitized_recipe['import_source'] = isset( $recipe['import_source'] ) ? sanitize_text_field( $recipe['import_source'] ) : '';
		$sanitized_recipe['import_backup'] = isset( $recipe['import_backup'] ) ? $recipe['import_backup'] : array();

		return $sanitized_recipe;
	}

	/**
	 * Sanitize recipe tags.
	 *
	 * @since    1.0.0
	 * @param		 mixed $tag Tag ID or new tag name.
	 */
	public static function sanitize_tags( $tag ) {
		if ( is_numeric( $tag ) ) {
			return intval( $tag );
		} else {
			return sanitize_text_field( $tag );
		}
	}
}
