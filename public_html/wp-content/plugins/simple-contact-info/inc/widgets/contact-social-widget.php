<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

class SCI_Social_Widget extends WP_Widget {

	function __construct() {
		$params = array(
			'name' 			=> 'Simple Social Icons',
			'description' 	=> __( 'Displays a social icons with links.', 'simple-contact-info' ),
		);

		if ( !get_option( 'qs_contact_show_sort' ) ) {
			update_option( 'qs_contact_show_sort', '' );
		}

		add_action( 'sci_updated_info', array( $this, 'delete_cache' ) );

		parent::__construct( 'SCI_Social_Widget', '', $params );
	}

	public function form( $instance ) {
		$array = array_merge(
			array( 'show_twitter', 'show_facebook', 'show_linkedin', 'show_google', 'show_youtube' ),
			sci_show_custom_options()
		);

		$sort = array();
		$diff = array();
		$sort = get_option( 'qs_contact_show_sort' );	

		if ( !empty( $sort ) ) {
			$sort = (Array) json_decode( $sort );
			$diff = array_diff( $array, $sort );
			$full = array_merge( $sort, $diff );
		} else {
			$full = $array;
		}
		
		extract( $instance );

		if ( !isset( $orientation ) ) {
			$orientation = '';
		}

		$options = array( 'horizontal', 'vertical' ); ?>
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
			<label for="<?php echo $this->get_field_id( 'orientation' ); ?>"><?php _e( 'Orientation', 'simple-contact-info' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'orientation' ); ?>" id="<?php echo $this->get_field_id( 'orientation' ); ?>">
			<option value=""><?php _e( 'Select orientation', 'simple-contact-info' ); ?></option>
				<?php foreach( $options as $option ) : 
					echo '<option value="' . esc_attr( $option ) . '" ' . ( $option == $orientation ? 'selected="Selected"' : '' ) .  '>'.  ucfirst( $option ) .'</option>'; 
				endforeach; ?>
			</select>
		</p>
		<hr>
		<h4><?php _e( 'Specify icons to be displayed on the site. You can change the order of these icons.', 'simple-contact-info' ); ?></h4>
		<div class="sci-sortable-social">
			<?php foreach ( $full as $social_name ) { ?>
				<p>
					<input type="checkbox" 
						class="checkbox" 
						id="<?php echo $this->get_field_id( $social_name ); ?>" 
						name="<?php echo $this->get_field_name( $social_name ); ?>" 
						<?php if ( isset( ${$social_name} ) ) { echo 'checked="checked"'; } ?>>
					<label for="<?php echo $this->get_field_id( $social_name ); ?>"> <?php echo ucfirst (str_replace( 'show_', '', $social_name ) ); ?></label>
				</p>
			<?php } ?>
		</div>
		<script>
			jQuery(document).ready(function($) {
				$(".sci-sortable-social").sortable({
					opacity: 0.7,
					cursor: 'move',
					tolerance: 'pointer'
				});
				$( ".sci-sortable-social" ).disableSelection();
			});
		</script>
		<style>
			.sci-sortable-social p {
				border: 1px solid #d3d3d3;
				background: -webkit-gradient(linear, 0 0, 0 100%, from(#fcfcfc), to(#dbdbdb));
				background: -moz-linear-gradient(top, #fcfcfc, #dbdbdb);
				-ms-filter: progid:DXImageTransform.Microsoft.gradient(startColorStr=#fcfcfc, endColorStr=#dbdbdb);
				filter: progid:DXImageTransform.Microsoft.gradient(startColorStr=#fcfcfc, endColorStr=#dbdbdb);
				display:block;
				overflow: hidden;
				padding: 5px 0 5px 10px !important;
			}
			.sci-sortable-social p input{
				float: left;
				width: 14px;
				margin-right: 10px;
			}
			.sci-sortable-social p label{
				float: left;
				width: 185px;
				display: block;
			}
		</style>
		<?php
	}

	public function update( $instance, $old_instance ) {
		$i = 1;
		$show = array();
		foreach ( $instance as $key => $value ) {
			if ( $key == 'title' || $key == 'orientation' ) {
				continue;
			}
			$show[$i] = $key;
			$i++;
		}
		update_option( 'qs_contact_show_sort', json_encode( $show ) );

		$this->delete_cache();

		return $instance;
	}

	public function get_elements() {
		$sort = array();
		$sci_widget = array();
		$sort = get_option( 'qs_contact_show_sort' );

		if ( !empty( $sort ) ) {
			$sort = json_decode( $sort );
			foreach ( $sort as $key => $value ) {
				$social = str_replace( 'show_', '', $value );
				$sci_widget[$key]['title'] = $social;
				if ( $social == 'twitter' || $social == 'facebook' || $social == 'youtube' || $social == 'google' || $social == 'linkedin' ) {
					$sci_widget[$key]['link'] = get_option( 'qs_contact_' . $social );
				} else {
					$sci_widget[$key]['link'] = get_option( 'qs_contact_custom_' . $social );
				}
				$sci_widget[$key]['icon'] = get_option( 'qs_contact_'.$social.'_icon' );
			}
		}

		return $sci_widget;
	}

	public function display_elements( $sci_widget, $orientation ) { ?>
		<div class="sci-social-icons">
			<ul class="sci-social-icons-<?php echo $orientation; ?>">
				<?php foreach ( $sci_widget as $key => $value ) : ?>
					<?php if (!empty($value['link'])) : ?>
						<li class="sci-social-<?php echo $value['title']; ?>">
							<a href="<?php echo esc_url( $value['link'] ); ?>" target="_blank" title="<?php echo ucfirst( $value['title'] ); ?>">
								<img src="<?php echo $value['icon']; ?>" alt="<?php echo ucfirst( $value['title'] ); ?>">
							</a>
						</li>
					<?php endif; ?>	
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}

	public function delete_cache() {
		// delete cache with html
		delete_transient( $this->id );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		
		$cached_code = get_transient( $this->id );

		// Check if code exist in cache.
		if( $cached_code === false ) {
			$sci_widget = $this->get_elements();
			
			ob_start(); 
			$this->display_elements( $sci_widget, $orientation );
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
function sci_widget_social_init() {
	register_widget( 'SCI_Social_Widget' );
}
add_action( 'widgets_init', 'sci_widget_social_init' );

function sci_widget_social_scripts_init(){
	wp_register_style( 'contact-info', SCI_URL . 'css/contact-info-frondend.css', array(), '1.0' );
	wp_enqueue_style( 'contact-info' );
}

if ( !is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'sci_widget_social_scripts_init' );	
}