<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'teambios' ); ?>:</label>
	<input type="text" id="<?php esc_attr_e( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
</p>

<p>
	<label for="<?php esc_attr_e( $this->get_field_name( 'team_member' ) ); ?>"><?php _e( 'Select a team member to display', 'teambios' ); ?></label><br />
	<select name="<?php esc_attr_e( $this->get_field_name( 'team_member' ) ); ?>">
		<option value="0"><?php _e( 'Select a team member', 'teambios' ); ?></option>

		<?php foreach( $this->get_all_team_bios() as $team_member ) :
            d( $team_member );
            ?>
            <option value="<?php esc_attr_e( $team_member->ID ); ?>"<?php selected( $instance['team_member'], (int) $team_member->ID ); ?>><?php esc_html_e( $team_member->post_title ); ?></option>
		<?php endforeach; ?>
	</select>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php _e( 'Bio Image Size', 'teambios' ); ?>:</label>
	<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
		<?php foreach ( $this->get_image_sizes() as $label => $size ) : ?>
			<option value="<?php echo absint( $size ); ?>" <?php selected( $size, $instance['image_size'] ); ?>><?php printf( '%s (%spx)', $label, $size ); ?></option>
		<?php endforeach; ?>
	</select>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>"><?php _e( 'Bio Image Alignment', 'teambios' ); ?>:</label>
	<select id="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_alignment' ) ); ?>">
		<option value="">- <?php _e( 'None', 'teambios' ); ?> -</option>
		<option value="left" <?php selected( 'left', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'teambios' ); ?></option>
		<option value="right" <?php selected( 'right', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'teambios' ); ?></option>
	</select>
</p>

<fieldset>
	<legend><?php _e( 'Select which text you would like to use as the bio', 'teambio' ); ?></legend>
	<p>
		<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'bio_display' ) ); ?>" id="<?php esc_attr_e( $this->get_field_id( 'author_info' ) ); ?>_op11" value="bio" <?php checked( $instance['bio_display'], 'bio' ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'use_bio' ) ); ?>_opt1"><?php _e( 'Use Member Bio', 'teambios' ); ?></label><br />
		<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'bio_display' ) ); ?>" id="<?php esc_attr_e( $this->get_field_id( 'author_info' ) ); ?>_op12" value="custom" <?php checked( $instance['bio_display'], 'custom' ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'bio_display' ) ); ?>_opt2"><?php _e( 'Use Custom Text (below)', 'teambios' ); ?></label><br />

        <label for="<?php echo esc_attr( $this->get_field_id( 'bio_text' ) ); ?>" class="screen-reader-text"><?php _e( 'Custom Text Content', 'teambios' ); ?></label>
		<textarea id="<?php echo esc_attr( $this->get_field_id( 'bio_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bio_text' ) ); ?>" class="widefat" rows="6" cols="4"><?php echo htmlspecialchars( $instance['bio_text'] ); ?></textarea>
	</p>
</fieldset>