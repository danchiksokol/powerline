<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

// ------------- Functions ------------- 

function sci_contact_info_help() {
	?>
	<div class="wrap">
		<div class="icon-sci-contact">
			<img src="<?php echo SCI_URL.'css/contact-info-icon.png'; ?>" alt="">
		</div>
		<h2><?php _e('Simple Help', "simple-contact-info"); ?></h2>
		<div class="tool-box">
			<h3 class="title"><?php _e('Social icons', "simple-contact-info"); ?></h3>
			<p><?php _e('If you want to display social icons, use widget', "simple-contact-info"); ?> <strong><?php _e('Simple Social Icons', "simple-contact-info"); ?></strong>.</p>
			<p><?php _e('You can select icons from existing icon packs or you can upload your images.', "simple-contact-info"); ?></p>
			<p><?php _e('If you want to get social link, use', "simple-contact-info"); ?> <code><?php echo htmlspecialchars("<?php echo (get_option('qs_contact_twitter')); ?>"); ?></code></p>
			<p><?php _e('To get url to selected social icon, use', "simple-contact-info"); ?> <code><?php echo htmlspecialchars("<?php echo (get_option('qs_contact_twitter_icon')); ?>"); ?></code></p>
			<p><?php _e('Or you can use shortcode', "simple-contact-info"); ?> <code>[sci_social]</code> <?php _e('or if you want vertical', "simple-contact-info"); ?> <code>[sci_social orientation="vertical"]</code></p>
		</div>
		<div class="tool-box">
			<h3 class="title"><?php _e('Google Map Widget', "simple-contact-info"); ?></h3>
			<p><?php _e('Just use widget', "simple-contact-info"); ?> <strong>Simple Google Map</strong></p>
			<p><?php _e('Widget display a Google Map based on the address that you entered in the settings.', "simple-contact-info"); ?></p>
			<p><?php _e('You can setup width, height, zoom and type of map(dynamic, static).', "simple-contact-info"); ?></p>
		</div>
		<div class="tool-box">
			<h3 class="title"><?php _e('Contact information', "simple-contact-info"); ?></h3>
			<p><?php _e('Just use widget', "simple-contact-info"); ?> <strong>Simple Contact Info</strong></p>
			<p><?php _e('If you want to get contact information, use', "simple-contact-info"); ?> <code><?php echo htmlspecialchars("<?php echo (get_option('qs_contact_phone')); ?>"); ?></code> <?php _e('etc', "simple-contact-info"); ?>.</p>
			<?php _e('List of options:', "simple-contact-info"); ?>
			<pre>
	qs_contact_phone
	qs_contact_fax
	qs_contact_email
	qs_contact_country
	qs_contact_state
	qs_contact_city
	qs_contact_street
	qs_contact_zip
			</pre>
		</div>
		<div class="tool-box">
			<h3 class="title"><?php _e('Support', "simple-contact-info"); ?></h3>
			<p><?php _e('To get support or if you find bug - just write me', "simple-contact-info"); ?> <a href="mailto:lehaqs@gmail.com" rel="nofollow">lehaqs@gmail.com</a></p>	
			<p><?php _e('Or you can find me on Facebook:', "simple-contact-info"); ?> <a href="http://www.facebook.com/LehaMotovilov" target="_blank">Facebook</a></p>
			<p><?php _e('Or you can find me on Vkontakte:', "simple-contact-info"); ?> <a href="http://vk.com/leha_motovilov" target="_blank">VK.com</a></p>
		</div>
	</div>
<?php }