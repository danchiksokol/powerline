<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

class SCI_Address_Widget extends WP_Widget {

	function __construct() {
		$params = array(
			'name' 			=> 'Simple Address Info',
			'description' 	=> __( 'Displays address information.' , 'simple-contact-info' ),
		);

		add_action( 'sci_updated_info', array( $this, 'delete_cache' ) );

		parent::__construct('SCI_Address_Widget', '', $params);
	}

	public function form( $instance ) {

		extract($instance);
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'simple-contact-info' ); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'title' ); ?>" 
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				value="<?php if( !empty( $title ) ) { echo esc_attr( $title ); } else { echo ''; } ?>"
				type="text" />
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

	public function display_elements() {
		$country 	= get_option( 'qs_contact_country' );
		$state 		= get_option( 'qs_contact_state' );
		$city		= get_option( 'qs_contact_city' );
		$street 	= get_option( 'qs_contact_street' );
		$zip 		= get_option( 'qs_contact_zip' ); 
		?>
			<div class="sci-address">
				<?php if ( !empty( $street ) ) : ?><p class="sci-address-street"><?php echo $street; ?></p><?php endif; ?>
				<?php if ( !empty( $city ) ) : ?><p class="sci-address-city"><?php echo $city; ?></p><?php endif; ?>
				<?php if ( !empty( $state ) ) : ?><p class="sci-address-state"><?php echo $state; ?></p><?php endif; ?>
				<?php if ( !empty( $country ) ) : ?><p class="sci-address-country"><?php echo $country; ?></p><?php endif; ?>
				<?php if ( !empty( $zip ) ) : ?><p class="sci-address-zip"><?php echo $zip; ?></p><?php endif; ?>
			</div>
		<?php
	}

	public function widget( $args, $instance ) {

		extract( $args );
		extract( $instance );
		
		$cached_code = get_transient( $this->id );

		// Check if code exist in cache.
		if( $cached_code === false ) {
			ob_start(); 
			$this->display_elements();
			$cached_code = ob_get_contents();
			ob_end_clean();

			set_transient( $this->id, $cached_code, DAY_IN_SECONDS ); // Add to cache for one day.
		}

		echo $before_widget;

		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		echo $cached_code; // html with widget

		echo $after_widget;
	}
}

// Load the widget on widgets_init
function sci_widget_address_init() {
	register_widget( 'SCI_Address_Widget' );
}
add_action( 'widgets_init', 'sci_widget_address_init' );