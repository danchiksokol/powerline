<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

class SCI_GoogleMaps_Widget extends WP_Widget {

	function __construct() {
		$params = array(
			'name' 			=> 'Simple Google Map',
			'description' 	=> __( 'Displays a Google Map based on the address that you entered in the settings.', 'simple-contact-info' ),
		);

		add_action( 'sci_updated_info', array( $this, 'delete_cache' ) );

		parent::__construct( 'SCI_GoogleMaps_Widget', '', $params );
	}

	public function form( $instance ) {
		extract($instance);

		if ( !isset( $type ) ) {
			$type = '';
		}
		if ( !isset( $maptype ) ) {
			$maptype = '';
		}

		$type_options = array( 'dynamic', 'static' );
		$map_type_options = array( 'roadmap', 'satellite', 'hybrid', 'terrain' );
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
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type', 'simple-contact-info' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>">
			<option value=""><?php _e( 'Select type', 'simple-contact-info' ); ?></option>
				<?php foreach( $type_options as $option ) : 
					echo '<option value="' . esc_attr( $option ) . '" ' . ( $option == $type ? 'selected="Selected"' : '' ) . '>' . ucfirst( $option ) . '</option>'; 
				endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'maptype' ); ?>"><?php _e( 'MapType', 'simple-contact-info' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'maptype' ); ?>" id="<?php echo $this->get_field_id( 'maptype' ); ?>">
			<option value=""><?php _e( 'Select MapType', 'simple-contact-info' ); ?></option>
				<?php foreach( $map_type_options as $option ) : 
					echo '<option value="' . esc_attr( $option ) . '" ' . ( $option == $maptype ? 'selected="Selected"' : '' ) . '>' . ucfirst( $option ) .'</option>'; 
				endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', 'simple-contact-info' ); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'width' ); ?>" 
				id="<?php echo $this->get_field_id( 'width' ); ?>"
				value="<?php if( !empty( $width ) ) { echo esc_attr( $width ); } else { echo ''; } ?>"
				type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height', 'simple-contact-info' ); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'height' ); ?>" 
				id="<?php echo $this->get_field_id( 'height' ); ?>"
				value="<?php if( !empty( $height ) ) { echo esc_attr( $height ); } else { echo ''; } ?>"
				type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'zoom' ); ?>"><?php _e("Zoom", 'simple-contact-info'); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'zoom' ); ?>" 
				id="<?php echo $this->get_field_id( 'zoom' ); ?>"
				value="<?php if( !empty( $zoom ) ) { echo esc_attr( $zoom ); } else { echo ''; } ?>"
				type="text" />
		</p>
		<hr />
		<p>
			<label for="<?php echo $this->get_field_id( 'latitude' ); ?>"><?php _e( 'Latitude', 'simple-contact-info' ); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'latitude' ); ?>" 
				id="<?php echo $this->get_field_id( 'latitude' ); ?>"
				value="<?php if( !empty( $latitude ) ) { echo esc_attr( $latitude ); } else { echo ''; } ?>"
				type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'longitude' ); ?>"><?php _e( 'Longitude', 'simple-contact-info' ); ?>:</label>
			<input 
				class="wadfat"
				name="<?php echo $this->get_field_name( 'longitude' ); ?>" 
				id="<?php echo $this->get_field_id( 'longitude' ); ?>"
				value="<?php if( !empty( $longitude ) ) { echo esc_attr( $longitude ); } else { echo ''; } ?>"
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

	public function display_elements( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$country 	= get_option( 'qs_contact_country' );
		$state 		= get_option( 'qs_contact_state' );
		$city		= get_option( 'qs_contact_city' );
		$street 	= get_option( 'qs_contact_street' );
		$zip 		= get_option( 'qs_contact_zip' );

		if ( !empty( $latitude ) && !empty( $longitude ) ) {
			$address = $latitude . ',' . $longitude;
		} else {
			$address = $country . ' ' . $state . ' ' . $city . ' ' . $street; 
		}

		if ( empty( $address ) && ( empty( $latitude ) && empty( $longitude ) ) ) {
			return;
		}

		if ( empty( $type ) ) {
			$type = 'dynamic';
		}

		if ( empty( $maptype ) ) {
			$maptype = 'roadmap';
		}

		if ( empty( $zoom ) ) {
			$zoom = 15;
		}

		if ( empty( $width ) ) {
			$width = 250;
		}

		if ( empty( $height ) ) {
			$height = 250;
		}

		if ( $type == 'static' ) {
			$address = str_replace( ' ', '+', $address );
		}

		?>
		<div class="sci-google-widget">
			<?php if ( $type == 'dynamic' ) { ?>
				<script>
					var sci_google_zoom 	= "<?php echo $zoom; ?>";
					var sci_google_address 	= "<?php echo $address; ?>";
					var sci_google_maptype	= "<?php echo $maptype; ?>";
				</script>
				<div id="sci-google-map" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
					<!-- map here -->
				</div>
			<?php } elseif( $type == 'static' ) { ?>
				<img src="http://maps.googleapis.com/maps/api/staticmap?
				center=<?php echo $address; ?>&amp;
				zoom=<?php echo $zoom; ?>&amp;
				size=<?php echo $width; ?>x<?php echo $height; ?>&amp;
				maptype=<?php echo $maptype; ?>&amp;
				markers=color:red%7Clabel:S%7C<?php echo $address; ?>&amp;
				sensor=false">
			<?php } ?>
		</div>
		<?php
	}

	public function widget( $args, $instance ) {
		$cached_code = get_transient( $this->id );
		$cached_code = false;

		// Check if code exist in cache.
		if( $cached_code === false ) {
			ob_start(); 
			$this->display_elements( $args, $instance );
			$cached_code = ob_get_contents();
			ob_end_clean();

			set_transient( $this->id, $cached_code, DAY_IN_SECONDS ); // Add to cache for one day.
		}

		extract( $args );
		extract( $instance );

		if ( empty( $type ) ) {
			$type = 'dynamic';
		}

		if ( $type == 'dynamic' ) {
			wp_enqueue_style( 'google-style', '//code.google.com/apis/maps/documentation/javascript/examples/default.css', array(), null ); 

			wp_register_script( 'googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=false', array(), '1.0' );
			wp_enqueue_script( 'googleapis' );

			wp_register_script( 'sci-googlemap', SCI_URL.'js/contact-info-googlemap.js', array(), '1.0' );
			wp_enqueue_script( 'sci-googlemap' );
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
function sci_widget_googlemap_init() {
	register_widget( 'SCI_GoogleMaps_Widget' );
}
add_action( 'widgets_init', 'sci_widget_googlemap_init' );