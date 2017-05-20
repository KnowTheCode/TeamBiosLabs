<?php
/**
 * Widget Handler
 *
 * @package     KnowTheCode\TeamBios\Support
 * @since       1.0.2
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GPL-2.0+
 */
namespace KnowTheCode\TeamBios\Widget;

add_action( 'widgets_init', __NAMESPACE__ . '\register_widgets' );
/**
 * Register widgets
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_widgets() {
	require( __DIR__ . '/TeamMemberBioWidget.php' );
	register_widget( __NAMESPACE__ . '\TeamMemberBioWidget' );
}
