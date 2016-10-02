<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

class SCI_Info_Widget extends WP_Widget {

	function __construct() {
		$params = array(
			'name' 			=> 'Simple Contact Info',
			'description' 	=> __( 'Displays contact (phone, fax, email) information.', 'simple-contact-info' ),
		);

		add_action( 'sci_updated_info', array( $this, 'delete_cache' ) );

		parent::__construct( 'SCI_Info_Widget', '', $params );
	}

	public function form( $instance ) {
		extract( $instance ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'simple-contact-info' ); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'title' ); ?>" 
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				value="<?php if( !empty( $title ) ) { echo esc_attr( $title ); } else { echo ''; } ?>"
				type="text" />
		</p>
		<hr />
		<h4><?php _e( 'Show:', 'simple-contact-info' ); ?></h4>
		<p>
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_phone' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_phone' ); ?>" 
				<?php if ( isset( $show_phone ) && $show_phone == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_phone' ); ?>"> <?php _e( 'Phone number', 'simple-contact-info' ); ?></label>
			<br />
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_phone_label' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_phone_label' ); ?>" 
				<?php if ( isset( $show_phone_label ) && $show_phone_label == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_phone_label' ); ?>"> <?php _e( 'Phone label', 'simple-contact-info' ); ?></label>
		</p>
		<hr align="center" width="100px"/>
		<p>
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_mob_phone' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_mob_phone' ); ?>" 
				<?php if ( isset( $show_mob_phone ) && $show_mob_phone == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_mob_phone' ); ?>"> <?php _e( 'Mobile Phone number', 'simple-contact-info' ); ?></label>
			<br />
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_mob_phone_label' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_mob_phone_label' ); ?>" 
				<?php if ( isset( $show_mob_phone_label ) && $show_mob_phone_label == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_mob_phone_label' ); ?>"> <?php _e( 'Mobile Phone label', 'simple-contact-info' ); ?></label>
		</p>
		<hr align="center" width="100px"/>
		<p>
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_fax' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_fax' ); ?>" 
				<?php if ( isset( $show_fax ) && $show_fax == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_fax' ); ?>"> <?php _e( 'Fax number', 'simple-contact-info'); ?></label>
			<br />
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_fax_label' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_fax_label' ); ?>" 
				<?php if ( isset( $show_fax_label ) && $show_fax_label == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_fax_label' ); ?>"> <?php _e( 'Fax label', 'simple-contact-info'); ?></label>
		</p>
		<hr align="center" width="100px"/>
		<p>
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_email' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_email' ); ?>" 
				<?php if ( isset( $show_email ) && $show_email == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_email' ); ?>"> <?php _e( 'Email', 'simple-contact-info' ); ?></label>
			<br />
			<input 
				type="checkbox" 
				class="checkbox" 
				id="<?php echo $this->get_field_id( 'show_email_label' ); ?>" 
				name="<?php echo $this->get_field_name( 'show_email_label' ); ?>" 
				<?php if ( isset( $show_email_label ) && $show_email_label == 'on' ) { echo 'checked="checked"'; } ?>>
			<label for="<?php echo $this->get_field_id( 'show_email_label' ); ?>"> <?php _e( 'Email label', 'simple-contact-info' ); ?></label>
		</p>
		<?php
	}

	public function update( $instance, $old_instance ) {
		$this->delete_cache();

		return $instance;
	}

	public function delete_cache() {
		// delete cache with html
		delete_transient( $this->id );
	}

	public function display_elements( $instance ) { 
		extract( $instance );

		$phone 		= get_option( 'qs_contact_phone' );
		$mob_phone 	= get_option( 'qs_contact_mob_phone' );
		$fax 		= get_option( 'qs_contact_fax' );
		$email		= get_option( 'qs_contact_email' ); ?>
		<div class="sci-contact">
			<?php if ( !empty( $phone ) && ( isset( $show_phone ) && $show_phone == 'on' ) ) : ?>
				<p class="sci-address-phone">
					<?php if ( isset( $show_phone_label ) && $show_phone_label == 'on') : ?>
						<span><?php _e( 'Phone:', 'simple-contact-info'); ?> </span>
					<?php endif; ?>
					<?php echo $phone; ?>
				</p>
			<?php endif; ?>

			<?php if ( !empty( $mob_phone ) && ( isset( $show_mob_phone ) && $show_mob_phone == 'on' ) ) : ?>
				<p class="sci-address-mob-phone">
					<?php if ( isset( $show_mob_phone_label ) && $show_mob_phone_label == 'on') : ?>
						<span><?php _e( 'Mobile Phone:', 'simple-contact-info' ); ?> </span>
					<?php endif; ?>
					<?php echo $mob_phone; ?>
				</p>
			<?php endif; ?>

			<?php if ( !empty( $fax ) && ( isset( $show_fax ) && $show_fax == 'on' ) ) : ?>
				<p class="sci-address-fax">
					<?php if ( isset( $show_fax_label ) && $show_fax_label == 'on') : ?>
						<span><?php _e( 'Fax:', 'simple-contact-info' ); ?> </span>
					<?php endif; ?>
					<?php echo $fax; ?>
				</p>
			<?php endif; ?>

			<?php if ( !empty( $email ) && ( isset( $show_email ) && $show_email == 'on' ) ) : ?>
				<p class="sci-address-email">
					<?php if ( isset( $show_email_label ) && $show_email_label == 'on') : ?>
						<span><?php _e( 'Email:', 'simple-contact-info'); ?> </span>
					<?php endif; ?>
					<a href="mailto:<?php echo $email; ?>" rel="nofollow"><?php echo $email; ?></a>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}

	public function widget( $args, $instance ) {

		extract( $args );
		
		$cached_code = get_transient( $this->id );

		// Check if code exist in cache.
		if( $cached_code === false ) {
			ob_start(); 
			$this->display_elements( $instance );
			$cached_code = ob_get_contents();
			ob_end_clean();

			set_transient( $this->id, $cached_code, DAY_IN_SECONDS ); // Add to cache for one day.
		}

		extract( $instance );

		echo $before_widget;

		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		echo $cached_code; // html with widget

		echo $after_widget;
	}
}

// Load the widget on widgets_init
function sci_widget_info_init() {
	register_widget( 'SCI_Info_Widget' );
}
add_action( 'widgets_init', 'sci_widget_info_init' );