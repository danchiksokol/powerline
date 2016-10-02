<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

// ------------- Functions -------------
function sci_contact_info_admin() {

	$hidden_field_name = 'contact_info';

	if (!empty($_POST) && ($_POST[$hidden_field_name] == 'Y')) {

		// Social links
		$twitter    = !empty($_POST['twitter']) ? trim(strip_tags($_POST['twitter'])) : '';
		$facebook 	= !empty($_POST['facebook']) ? trim(strip_tags($_POST['facebook'])) : '';
		$youtube 	= !empty($_POST['youtube']) ? trim(strip_tags($_POST['youtube'])) : '';
		$google 	= !empty($_POST['google']) ? trim(strip_tags($_POST['google'])) : '';
		$linkedin 	= !empty($_POST['linkedin']) ? trim(strip_tags($_POST['linkedin'])) : '';

		// Contact info
		$phone 		= !empty($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : '';
		$mob_phone 	= !empty($_POST['mob_phone']) ? trim(strip_tags($_POST['mob_phone'])) : '';
		$fax 		= !empty($_POST['fax']) ? trim(strip_tags($_POST['fax'])) : '';
		$email 		= !empty($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';

		// Address
		$country 	= !empty($_POST['country']) ? trim(strip_tags($_POST['country'])) : '';
		$state 		= !empty($_POST['state']) ? trim(strip_tags($_POST['state'])) : '';
		$city 		= !empty($_POST['city']) ? trim(strip_tags($_POST['city'])) : '';
		$street 	= !empty($_POST['street']) ? trim(strip_tags($_POST['street'])) : '';
		$zip 		= !empty($_POST['zip']) ? trim(strip_tags($_POST['zip'])) : '';

		// Custom social links
		if (!empty($_POST['customOpt'])) {
			foreach ($_POST['customOpt'] as $key => $value) {
				update_option($key,	trim(strip_tags($value)));
			}
		}

		// Social links
		update_option('qs_contact_twitter',	$twitter);
		update_option('qs_contact_facebook', $facebook);
		update_option('qs_contact_youtube', $youtube);
		update_option('qs_contact_google', $google);
		update_option('qs_contact_linkedin', $linkedin);

		// Contact info
		update_option('qs_contact_phone', $phone);
		update_option('qs_contact_mob_phone', $mob_phone);
		update_option('qs_contact_fax', $fax);
		update_option('qs_contact_email', $email);

		// Address
		update_option('qs_contact_country', $country);
		update_option('qs_contact_state', $state);
		update_option('qs_contact_city', $city); 
		update_option('qs_contact_street', $street);
		update_option('qs_contact_zip', $zip); 

		add_action('admin_notices', 'sci_updated_notice');
		$msg = __('Information successfully updated.', 'simple-contact-info');
		sci_updated_notice($msg);

		do_action( 'sci_updated_info' ); // clear widgets cache
	} 
	$customSocial = sci_get_options();
	?>
	<div class="wrap">
		<div class="icon-sci-contact">
			<img src="<?php echo SCI_URL . 'css/contact-info-icon.png'; ?>" alt="">
		</div>
		<h2><?php _e("Simple Contact Information", "simple-contact-info"); ?></h2>
		<form name="contactForm" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<h3><?php _e("Social links", "simple-contact-info"); ?></h3>

			<span class="description"><?php _e("This information is used by", "simple-contact-info"); ?> <strong><?php _e("Simple Social Icons", "simple-contact-info"); ?></strong></span>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="twitter"><?php _e("Twitter", "simple-contact-info"); ?></label></th>
						<td>
							<input id="twitter" name="twitter" class="regular-text" type="text" value="<?php echo get_option('qs_contact_twitter'); ?>" />
							<span class="description"><?php _e("Link to Twitter page. (example \"https://twitter.com/lehamotovilov\")", "simple-contact-info"); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="facebook"><?php _e("Facebook", "simple-contact-info"); ?></label></th>
						<td>
							<input id="facebook" name="facebook" class="regular-text" type="text" value="<?php echo get_option('qs_contact_facebook'); ?>" />
							<span class="description"><?php _e("Link to Facebook page. (example \"http://www.facebook.com/LehaMotovilov\")", "simple-contact-info"); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="youtube"><?php _e("YouTube", "simple-contact-info"); ?></label></th>
						<td>
							<input id="youtube" name="youtube" class="regular-text" type="text" value="<?php echo get_option('qs_contact_youtube'); ?>" />
							<span class="description"><?php _e("Link to YouTube page. (example \"http://www.youtube.com/user/AlekseyMotovilov\")", "simple-contact-info"); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="google"><?php _e("Google+", "simple-contact-info"); ?></label></th>
						<td>
							<input id="google" name="google" class="regular-text" type="text" value="<?php echo get_option('qs_contact_google'); ?>" />
						</td>
					</tr>
					<tr>
						<th><label for="linkedin"><?php _e("LinkedIn", "simple-contact-info"); ?></label></th>
						<td>
							<input id="linkedin" name="linkedin" class="regular-text" type="text" value="<?php echo get_option('qs_contact_linkedin'); ?>" />
						</td>
					</tr>
					<?php if (!empty($customSocial)) : ?>
						<?php foreach ($customSocial as $social) : ?>
							<tr>
								<th><label for="customOpt[<?php echo $social->option_name; ?>]"><?php echo ucfirst(str_replace('qs_contact_custom_', '', $social->option_name)); ?></label></th>
								<td>
									<input id="customOpt[<?php echo $social->option_name; ?>]" name="customOpt[<?php echo $social->option_name; ?>]" class="regular-text" type="text" value="<?php echo get_option($social->option_name); ?>" />
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			<h3><?php _e("Contact info", "simple-contact-info"); ?></h3>
			<span class="description"><?php _e("This information is used by", "simple-contact-info"); ?> <strong><?php _e("Simple Contact Info", "simple-contact-info"); ?></strong></span>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="phone"><?php _e("Phone number", "simple-contact-info"); ?></label></th>
						<td><input id="phone" name="phone" class="regular-text" type="text" value="<?php echo get_option('qs_contact_phone'); ?>" /></td>
					</tr>					
					<tr>
						<th><label for="mob_phone"><?php _e("Mobile phone number", "simple-contact-info"); ?></label></th>
						<td><input id="mob_phone" name="mob_phone" class="regular-text" type="text" value="<?php echo get_option('qs_contact_mob_phone'); ?>" /></td>
					</tr>
					<tr>
						<th><label for="fax"><?php _e("FAX", "simple-contact-info"); ?></label></th>
						<td><input id="fax" name="fax" class="regular-text" type="text" value="<?php echo get_option('qs_contact_fax'); ?>" /></td>
					</tr>
					<tr>
						<th><label for="email"><?php _e("Email address", "simple-contact-info"); ?></label></th>
						<td><input id="email" name="email" class="regular-text" type="text" value="<?php echo get_option('qs_contact_email'); ?>" /></td>
					</tr>
				</tbody>
			</table>
			<h3><?php _e("Address", "simple-contact-info"); ?></h3>
			<span class="description"><?php _e("This information is used by", "simple-contact-info"); ?> <strong><?php _e("Simple Google Map, Simple Address Info", "simple-contact-info"); ?></strong></span>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="country"><?php _e("Country", "simple-contact-info"); ?></label></th>
						<td><input id="country" name="country" class="regular-text" type="text" value="<?php echo get_option('qs_contact_country'); ?>" /></td>
					</tr>
					<tr>
						<th><label for="state"><?php _e("State", "simple-contact-info"); ?></label></th>
						<td><input id="state" name="state" class="regular-text" type="text" value="<?php echo get_option('qs_contact_state'); ?>" /></td>
					</tr>
					<tr>
						<th><label for="city"><?php _e("City", "simple-contact-info"); ?></label></th>
						<td><input id="city" name="city" class="regular-text" type="text" value="<?php echo get_option('qs_contact_city'); ?>" /></td>
					</tr>
					<tr>
						<th><label for="street"><?php _e("Street", "simple-contact-info"); ?></label></th>
						<td><input id="street" name="street" class="regular-text" type="text" value="<?php echo get_option('qs_contact_street'); ?>" /></td>
					</tr>
					<tr>
						<th><label for="zip"><?php _e("Zip code", "simple-contact-info"); ?></label></th>
						<td><input id="zip" name="zip" class="regular-text" type="text" value="<?php echo get_option('qs_contact_zip'); ?>" /></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
				<input id="submit" class="button button-primary" type="submit" value="<?php _e('Update info', "simple-contact-info"); ?>" name="submit" />
			</p>
		</form>
	</div>
<?php }