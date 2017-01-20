<?php
/**
 * Custom Post Type functionality
 *
 * @package     KnowTheCode\TeamBios\Custom
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
namespace KnowTheCode\TeamBios\Custom;

add_action( 'init', __NAMESPACE__ . '\register_custom_post_type' );
/**
 * Register the custom post type.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_custom_post_type() {

	$labels = array(
		'name'               => _x( 'Team Bios', 'post type general name', 'teambios' ),
		'singular_name'      => _x( 'Team Bio', 'post type singular name', 'teambios' ),
		'menu_name'          => _x( 'Team Bios', 'admin menu', 'teambios' ),
		'name_admin_bar'     => _x( 'Team Bio', 'add new on admin bar', 'teambios' ),
		'add_new'            => _x( 'Add New Team Bio', 'team-bios', 'teambios' ),
		'add_new_item'       => __( 'Add New Team Bio', 'teambios' ),
		'new_item'           => __( 'New Team Bio', 'teambios' ),
		'edit_item'          => __( 'Edit Team Bio', 'teambios' ),
		'view_item'          => __( 'View Team Bio', 'teambios' ),
		'all_items'          => __( 'All Team Bios', 'teambios' ),
		'search_items'       => __( 'Search Team Bios', 'teambios' ),
		'parent_item_colon'  => __( 'Parent Team Bios:', 'teambios' ),
		'not_found'          => __( 'No team bios found.', 'teambios' ),
		'not_found_in_trash' => __( 'No team bios found in Trash.', 'teambios' ),

		'featured_image'        => __( 'Profile Image', 'teambios' ),
		'set_featured_image'    => __( 'Set Profile Image', 'teambios' ),
		'remove_featured_image' => __( 'Remove Profile Image', 'teambios' ),
		'use_featured_image'    => __( 'Use Profile Image', 'teambios' ),
	);

	$features = get_all_post_type_features( 'post', array(
		'excerpt',
		'comments',
		'trackbacks',
		'custom-fields',
	) );

	$args = array(
		'label'        => __( 'Team Bios', 'teambios' ),
		'labels'       => $labels,
		'public'       => true,
		'supports'     => $features,
		'menu_icon'    => 'dashicons-admin-users',
		'hierarchical' => false,
		'has_archive'  => true,
	);

	register_post_type( 'team-bios', $args );
}

/**
 * Get all the post type features for the given post type.
 *
 * @since 1.0.0
 *
 * @param string $post_type Given post type
 * @param array $exclude_features Array of features to exclude
 *
 * @return array
 */
function get_all_post_type_features( $post_type = 'post', $exclude_features = array() ) {
	$configured_features = get_all_post_type_supports( $post_type );

	if ( ! $exclude_features ) {
		return array_keys( $configured_features );
	}

	$features = array();

	foreach ( $configured_features as $feature => $value ) {
		if ( in_array( $feature, $exclude_features ) ) {
			continue;
		}

		$features[] = $feature;
	}

	return $features;
}
