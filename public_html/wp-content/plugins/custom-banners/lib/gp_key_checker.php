<?php
/**
 * Calls home to the Gold Plugins Key Server to check API keys for validity.
 * Does not cache its results - makes a new web request each time (caching may 
 * become an option in a later version).
 *
 * @example
 *     // pass plugin name to constructor to begin
 *     $kc = new GoldPlugins_Key_Checker('custom-banners-pro'); 
 *     
 *     // get the key's status ('ACTIVE', 'EXPIRED', 'INVALID', or 'UNKNOWN')
 *     $key_status = $kc->get_key_status('me@example.com', 'API_KEY_123456');
 *     
 *     // simply check whether the key is currently active (true or false)
 *     $is_valid = $kc->is_key_active('me@example.com', 'API_KEY_123456');
 */ 
class GoldPlugins_Key_Checker
{
    /**
     * The update server's API URL
     * @var string
     */
    public $api_url = 'https://goldplugins.cloud/api';

    /**
     * Plugin name (e.g., "custom-banners-pro")
     * @var string
     */
    public $plugin;
 
    /**
     * Initialize a new instance of the Gold Plugins Key Checker class
     * @param string $plugin The slug of the plugin to check keys against.
     */
    function __construct($plugin)
    {
        $this->plugin = $plugin;
    }
	
    /**
     * Return the key status, after talking to the remote server
	 *
     * @param string $license_email The email address matching the API key
     * @param string $license_key  The API key to check
	 *
     * @return string The key status ('ACTIVE', 'EXPIRED', 'INVALID', 
	 *								  or 'UNKNOWN')
     */
    public function get_key_status($license_email, $license_key)
    {
		// prepare request variables
		$api_url = $this->get_endpoint_url('validate_key');
		$registration_details = compact('license_key', 'license_email');
		$post_params = array(
			'body' => $this->prepare_post_params( $registration_details )
		);
		
		// send the request
		$request = wp_remote_post($api_url, $post_params);
		$response_code = wp_remote_retrieve_response_code($request);
		
		// If we received a response from the key server, interpret it here.
        if ( !is_wp_error($request) && $response_code === 200 ) {
			$valid_responses = array('ACTIVE', 'EXPIRED', 'INVALID');
			if ( in_array($request['body'], $valid_responses) ) {
				return $request['body'];
			} else {
				return 'INVALID';
			}
        }
		
		// HTTP POST to the server failed, so we don't know if the key is active
		// or not. The caller should retry after a short wait.
        return 'UNKNOWN';
    }
	
    /**
     * Determines whether the provided email + API key combination represents
	 * a valid, active (non-expired) key.
	 *
     * @param string $license_email The email address matching the API key
     * @param string $license_key  The API key to check
	 *
     * @return bool Status of the key. true if the key is active, false if not.
     */
	public function is_key_active($license_email, $license_key)
	{
		$status = $this->get_key_status($license_email, $license_key);
		return ($status == 'ACTIVE');
	}
	
    /**
     * Determines whether the provided email + API key combination represents
	 * a valid, active (non-expired) key.
	 *
     * @param string $license_email The email address matching the API key
     * @param string $license_key  The API key to check
	 *
     * @return bool Status of the key. true if the key is active, false if not.
     */
	public function get_package_url($license_email, $license_key)
	{
		// prepare request variables
		$api_url = $this->get_endpoint_url('info');
		$registration_details = compact('license_key', 'license_email');
		$post_params = array(
			'body' => $this->prepare_post_params( $registration_details )
		);
		
		// send the request
		$request = wp_remote_post($api_url, $post_params);
		$response_code = wp_remote_retrieve_response_code($request);
		
		// If we received a response from the key server, interpret it here.
        if ( !is_wp_error($request) && $response_code === 200 ) {
			$plugin_info = unserialize($request['body']);
			if ( !empty($plugin_info) && !empty($plugin_info->download_link) ) {
				return $plugin_info->download_link;
			}	
        }
		
		// HTTP POST to the server failed, or the key is not active
        return '';
	}
	
    /**
     * Collects values to be sent with every API request, such as site_url, 
	 * merges them with the provided array, and returns the resulting array.
	 *
     * @param array $extra_params Any extra params to add to the array. Values 
	 *							  in this array will take precedence over the 
	 *							  automatically collected variables.
	 *
     * @return array The merged array of provided and collected values.
     */
	public function prepare_post_params($extra_params = array())
	{
		$params = array(
			'site_url' => site_url(),
			'rnd' => rand(1000,30000)
		);
		return array_merge($params, $extra_params);
	}
	
	/**
     * Returns the URL for the validate_key API endpoint.
	 *
     * @return sting URL to which validate_key API requests should be sent.
     */
	private function get_endpoint_url($endpoint)
	{
		// prepare request variables
		return sprintf( $this->api_url . '/%s/%s?r=%s', 
						$endpoint,
						$this->plugin,
						rand(1000, 50000)
		);
	}
}