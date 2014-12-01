<?php 
class Icepay_controller extends CI_Model
{
	/**
	 *	Object properties
	 */
	private $wizard;
	private $database;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	public function getfbUser(){
		// Get User ID
		$user = $this->facebook->getUser();

		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $this->facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e); 
				$user = null;
			}
		}
		// Login or logout url will be needed depending on current user state.
		if ($user) {
			//$logoutUrl = $this->facebook->getLogoutUrl();
			return $user_profile;
		}
	}
}
?> 