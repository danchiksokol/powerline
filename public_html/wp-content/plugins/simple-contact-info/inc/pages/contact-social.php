<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

// ------------- Functions ------------- 

function sci_read_dir($path){
	$files = array();
	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$files[] = $file;
			}
		}
		closedir($handle);
	}

	return $files;
}

function sci_get_images($custom = false) {
	if ($custom) {
		$path = sci_get_files_path('', $custom);
	} else {
		$path = sci_get_files_path();
	}

	$folders = sci_read_dir($path);

	$images = array();
	if (!empty($folders)) {
		foreach ($folders as $folder) {
			if ($custom) {
				$path = sci_get_files_path($folder.'/', $custom).$folder;
			} else {
				$path = sci_get_files_path($folder.'/');
			}
			$images[$folder] = sci_read_dir($path);
			if (empty($images[$folder])) {
				unset($images[$folder]);
			}
		}
	}

	return $images;
}

function sci_get_files_path($folder = '', $custom = false) {
	if ($custom) {
		$upload_dir = wp_upload_dir();
		$path = $upload_dir['basedir'].'/sci-custom-icons/';
	} else {
		$path = SCI_DIR."icons/".$folder;
	}

	return $path;
}

function sci_get_dropdown() {
	$path 		= sci_get_files_path();
	$folders 	= sci_read_dir($path);

	$select = '<select name="folder" id="folder">';
	
	// Add custom social networks to dropdown
	$customSocial = sci_get_options();
	if (!empty($customSocial)) {
		foreach ($customSocial as $social) {
			$name = str_replace('qs_contact_custom_', '', $social->option_name);
			$select .= '<option value="'.$name.'" >'.ucfirst($name).'</option>';
		}
	}

	foreach ($folders as $folder) {
		$select .= '<option value="'.$folder.'" >'.ucfirst($folder).'</option>';
	}

	$select .= '</select>';

	return $select;
}

function sci_check_custom_path() {
	$upload_dir = wp_upload_dir();
	$path = $upload_dir['basedir'].'/sci-custom-icons/';

	if (!file_exists($path) || !is_dir($path)) {
		return false;
	}
	return true;
}

function sci_filter_upload_dir($params) {
	$folder = $_POST['folder'];
	$params['path'] = $params['basedir'].'/sci-custom-icons/'.$folder;
	$params['url'] = $params['baseurl'].'/sci-custom-icons/'.$folder;

	return $params;
}

function sci_contact_info_social() {
	$hidden_field_select = 'contact_info_icons_select';
	$hidden_field_upload = 'contact_info_icons_upload';

	// Submit form select
	if (isset($_POST[$hidden_field_select]) && ($_POST[$hidden_field_select] == 'Y')) {
		foreach ($_POST['icons'] as $key => $value) {
			update_option("qs_contact_".$key."_icon", $value);
		}
		add_action( 'admin_notices', 'sci_updated_notice' );
		$msg = __('Settings succesfully updated.', 'simple-contact-info');
		sci_updated_notice($msg);
	}

	// Submit form upload
	if (isset($_POST[$hidden_field_upload]) && ($_POST[$hidden_field_upload] == 'Y')) {
		if (!empty($_FILES['img']['tmp_name']) && !empty($_POST['folder'])) {
			if (!function_exists('wp_handle_upload')) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			add_filter('upload_dir', 'sci_filter_upload_dir');
			
			$file = wp_handle_upload($_FILES['img'], array('test_form' => false));

			add_action( 'admin_notices', 'sci_updated_notice' );
			if (isset($file['error'])) {
				sci_updated_notice($file['error'], $error);
			} else {
				sci_updated_notice('Image succesfully uploaded.');
			}
		}
	}

	$images = sci_get_images();
	if (sci_check_custom_path()) {
		$imagesCustom = sci_get_images(true); // true - for custom icons
	}
	$dropdown = sci_get_dropdown();
	?>
	<div class="wrap">
		<div class="icon-sci-contact">
			<img src="<?php echo SCI_URL.'css/contact-info-icon.png'; ?>" alt="">
		</div>
		<h2><?php _e('Simple Setup Social Icons', "simple-contact-info"); ?></h2>
		<form id="contactSocialForm" name="contactSocialForm" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<h3><?php _e('Select from the existing icons', "simple-contact-info"); ?></h3>
			<table class="form-table">
				<tbody>
					<?php foreach ($images as $key => $images) : ?>
					<tr>
						<th><label for="<?php echo $key; ?>"><?php _e(ucfirst($key)); ?></label></th>
						<td>
							<ul class="sci-social-icons">
								<?php foreach ($images as $image) : ?>
									<li>
										<?php $uniqId = uniqid(); ?>
										<?php $selected = get_option('qs_contact_'.$key.'_icon'); ?>
										<label for="<?php echo $uniqId; ?>">
											<img src="<?php echo SCI_URL.'icons/'.$key.'/'.$image; ?>" alt="<?php echo ucfirst($key); ?>">
										</label>
										<input type="radio"
											id="<?php echo $uniqId; ?>"
											name="icons[<?php echo $key; ?>]" 
											value="<?php echo SCI_URL.'icons/'.$key.'/'.$image; ?>" 
											<?php if ($selected == SCI_URL.'icons/'.$key.'/'.$image) { echo 'checked="checked"'; }?> />
									</li>
								<?php endforeach; ?>
							</ul>
						</td>
						</tr>
					<?php endforeach; ?>
					<?php if (!empty($imagesCustom)) : ?>
						<tr>
							<th><h3><?php _e('Custom icons.', "simple-contact-info"); ?></h3></th>
						</tr>
						<?php foreach ($imagesCustom as $key => $images) : ?>
						<?php if (!empty($images)) : ?>
							<tr>
								<th><label for="<?php echo $key; ?>"><?php _e(ucfirst($key)); ?></label></th>
								<td>
									<ul class="sci-social-icons">
									<?php $uploads_dir = wp_upload_dir(); ?>
									<?php if ($images !== null) : ?>
										<?php foreach ($images as $image) : ?>
											<li>
												<?php $uniqId = uniqid(); ?>
												<?php $selected = get_option('qs_contact_'.$key.'_icon'); ?>
												<label for="<?php echo $uniqId; ?>">
													<div></div>
													<img src="<?php echo $uploads_dir['baseurl'].'/sci-custom-icons/'.$key.'/'.$image; ?>" alt="<?php echo ucfirst($key); ?>">
												</label>
												<a class="sci-delete remove" href="javascript:void(0);"><?php _e('Delete', "simple-contact-info"); ?></a>
												<input type="hidden" class="sci-hidden" name="toDelete[]" value="">
												<input type="radio"
													class="sci-radio"
													id="<?php echo $uniqId; ?>" 
													name="icons[<?php echo $key; ?>]" 
													value="<?php echo $uploads_dir['baseurl'].'/sci-custom-icons/'.$key.'/'.$image; ?>" 
													<?php if ($selected == $uploads_dir['baseurl'].'/sci-custom-icons/'.$key.'/'.$image) { echo 'checked="checked"'; }?> />
											</li>
										<?php endforeach; ?>
									<?php endif; ?>
									</ul>
								</td>
							</tr>
						<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			<p class="submit">
				<input type="hidden" name="<?php echo $hidden_field_select; ?>" value="Y">
				<input id="submit" class="button button-primary" type="submit" value="<?php _e('Update', 'simple-contact-info'); ?>" name="submit" />
			</p>
		</form>
		<hr />
		<form name="contactSocialUploadForm" enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<h3><?php _e('Upload your custom icon', "simple-contact-info"); ?></h3>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="img"><?php _e('Select jpeg, jpg, png file.', "simple-contact-info"); ?></label></th>
						<td><input type="file" id="img" name="img" accept="image/jpeg,image/png,image/jpg" /></td>
					</tr>                   
					<tr>
						<th><label for="folder"><?php _e('Select icons category.', 'simple-contact-info'); ?></label></th>
						<td><?php echo $dropdown; ?></td>
					</tr>                   
				</tbody>
			</table>
			<p class="submit">
				<input type="hidden" name="<?php echo $hidden_field_upload; ?>" value="Y">
				<input id="submit" class="button button-primary" type="submit" value="<?php _e('Upload', 'simple-contact-info'); ?>" name="submit" />
			</p>
		</form>
	</div>
	<div id="dialog-message" title="Ooops." style="display: none;">
		<p><?php _e('You must select an icon for each social network.', 'simple-contact-info');?></p>
	</div>
	<div id="dialog-confirm" title="<?php _e('Delete icon?', 'simple-contact-info');?>" style="display: none;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><?php _e('These icon will be permanently deleted and cannot be recovered. Are you sure?', 'simple-contact-info');?></p>
	</div>
<?php }