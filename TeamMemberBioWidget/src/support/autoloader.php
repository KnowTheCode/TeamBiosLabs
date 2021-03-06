<?php
/**
 * File autoloader functionality
 *
 * @package     KnowTheCode\TeamBios\Support
 * @since       1.0.2
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GNU General Public License 2.0+
 */
namespace KnowTheCode\TeamBios\Support;

/**
 * Load all of the plugin's files.
 *
 * @since 1.0.2
 *
 * @param string $src_root_dir Root directory for the source files
 *
 * @return void
 */
function autoload_files( $src_root_dir ) {

	$filenames = array(
		'custom/post-type',
		'custom/taxonomy',

		'widget/handler',
	);

	foreach ( $filenames as $filename ) {
		include_once( $src_root_dir . $filename . '.php' );
	}
}
