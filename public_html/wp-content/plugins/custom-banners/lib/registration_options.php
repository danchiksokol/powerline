<h3>Pro Registration</h3>			
<?php if(isValidCBKey()): ?>	
<p class="plugin_is_registered">Your plugin is succesfully registered and activated. Thank you!</p>
<?php else: ?>
<p class="plugin_is_not_registered">Custom Banners Pro is not activated. You will not be able to use the Pro features until you activate the plugin. <br /><br /><a class="button" href="http://goldplugins.com/our-plugins/custom-banners/upgrade-to-custom-banners-pro/?utm_campaign=registration&utm_source=custom_banners_settings" target="_blank">Click Here To Upgrade To Pro</a> <br /> <br /><em>You'll unlock powerful new features including advanced styling options and JavaScript transitions for your slideshows.</em></p>
<p>Please enter your email address and API key to activate Custom Banners Pro. </p>
<?php endif; ?>	
<?php if(!isValidMSCBKey()): ?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="custom_banners_registered_name">Email Address</label></th>
		<td><input type="text" name="custom_banners_registered_name" id="custom_banners_registered_name" value="<?php echo get_option('custom_banners_registered_name'); ?>"  style="width: 250px" />
		<p class="description">This is the e-mail address that you used when you purchased the plugin.</p>
		</td>
	</tr>
</table>

<table class="form-table" style="display: none;">
	<tr valign="top">
		<th scope="row"><label for="custom_banners_registered_url">Website Address</label></th>
		<td><input type="text" name="custom_banners_registered_url" id="custom_banners_registered_url" value="<?php echo get_option('custom_banners_registered_url'); ?>"  style="width: 250px" />
		<p class="description">This is the Website Address that you used when you purchased the plugin.</p>
		</td>
	</tr>
</table>
	
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="custom_banners_registered_key">API Key</label></th>
		<td><input type="text" name="custom_banners_registered_key" id="custom_banners_registered_key" value="<?php echo get_option('custom_banners_registered_key'); ?>"  style="width: 250px" />
		<p class="description">This is the API Key that you received after purchasing the plugin.</p>
		</td>
	</tr>
</table>
<p class="description">Please Note: Submitting your API Key will call home to our servers to confirm your key, before unlocking the Pro features.</p>

<?php endif; ?>