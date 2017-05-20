<?php

/**
 * Team Member Bio Widget - displays the selected team member's bio.
 *
 * @package     KnowTheCode\TeamBios\Widget
 * @since       1.0.2
 * @author      hellofromTonya
 * @link        https://knowthecode.io
 * @license     GPL-2.0+
 */

namespace KnowTheCode\TeamBios\Widget;

use WP_Widget;

class TeamMemberBioWidget extends WP_Widget {

	protected $config = array();


	public function __construct() {

		$this->init_config();

		parent::__construct(
			$this->config['widget_id'],
			$this->config['widget_name'],
			$this->config['widget_ops'],
			$this->config['control_ops']
		);

	}


	/**
	 * Echo the widget content.
	 *
	 * @param array $args Display arguments including `before_title`, `after_title`,
	 *                        `before_widget`, and `after_widget`.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->config['defaults'] );

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance,
					$this->id_base ) . $args['after_title'];
		}

		$team_member = $this->get_bio( $instance['team_member'] );
		if ( ! $team_member ) {
			echo $args['after_widget'];

			return;
		}

		$image = $this->get_image( $instance, $team_member );

		$bio = $instance['bio_display'] == 'custom'
			? $instance['bio_text']
			: $team_member->post_content;

		$bio = do_shortcode( wpautop( $bio ) );

		include( $this->config['display_view'] );

		echo $args['after_widget'];
	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via `form()`.
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$new_instance = $this->filter_new_values( $new_instance );

		if ( $new_instance['bio_text'] ) {
			$new_instance['bio_text'] = current_user_can( 'unfiltered_html' )
				? $new_instance['bio_text']
				: wp_kses_post( $new_instance['bio_text'] );
		} else {
			$new_instance['bio_text'] = '';
		}

		return $new_instance;
	}

	/**
	 * Echo the settings update form.
	 *
	 * @param array $instance Current settings.
	 *
	 * @return void
	 */
	public function form( $instance ) {

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->config['defaults'] );

		$team_member_id = (int) $this->get_field_name( 'team_member' );

		include( $this->config['form_view'] );

	}

	/**************************
	 * Getters
	 *************************/

	protected function get_image_sizes() {
		return $this->config['image_sizes'];
	}

	protected function get_all_team_bios() {
		return get_posts( $this->config['get_team_members_args'] );
	}

	/**
	 * Get the bio.
	 *
	 * @since 1.0.0
	 *
	 * @param int $bio_id
	 *
	 * @return array|null|void|\WP_Post
	 */
	protected function get_bio( $bio_id ) {
		$bio_id = (int) $bio_id;

		if ( $bio_id < 1 ) {
			return;
		}

		return get_post( $bio_id );
	}

	protected function get_image( $instance, $team_member ) {
		$attributes = array(
			'class' => 'teambio--image align' . esc_attr( $instance['image_alignment'] ),
		);

		$size = (int) $instance['image_size'];

		return get_the_post_thumbnail(
			$team_member->ID,
			array( $size, $size ),
			$attributes
		);
	}

	/**************************
	 * Helpers
	 *************************/

	/**
	 * Filter the new values.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance
	 *
	 * @return array
	 */
	protected function filter_new_values( array $new_instance ) {
		foreach ( $new_instance as $key => $new_value ) {
			$filter = $this->config['default_filters'][ $key ];

			if ( ! is_callable( $filter ) ) {
				continue;
			}

			$new_instance[ $key ] = $filter( $new_value );
		}

		return $new_instance;
	}

	protected function init_config() {

		$id = 'team_member_bio';

		$this->config = array(
			'widget_id' => 'team_member_bio',

			'widget_name' => __( 'Team Member Bio', 'teambios' ),

			'widget_ops' => array(
				'classname'   => $id,
				'description' => __( 'Displays the selected team member\'s bio', 'teambios' ),
			),

			'control_ops' => array(
				'id_base' => $id,
				'width'   => 200,
				'height'  => 250,
			),

			'defaults' => array(
				'title'           => '',
				'image_alignment' => 'left',
				'team_member'     => 0,
				'image_size'      => '45',
				'bio_display'     => '',
				'bio_text'        => '',
			),

			'default_filters' => array(
				'title'           => 'strip_tags',
				'image_alignment' => 'strip_tags',
				'team_member'     => 'int_val',
				'image_size'      => 'int_val',
				'bio_display'     => 'strip_tags',
				'bio_text'        => '',
			),

			'get_team_members_args' => array(
				'posts_per_page' => - 1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'post_type'      => 'team-bios',
			),

			'image_sizes'  => array(
				__( 'Small', 'teambios' )       => 45,
				__( 'Medium', 'teambios' )      => 65,
				__( 'Large', 'teambios' )       => 85,
				__( 'Extra Large', 'teambios' ) => 125,
			),

			// Views
			'form_view'    => __DIR__ . '/views/bio-form.php',
			'display_view' => __DIR__ . '/views/team-member-bio.php',
		);
	}
}