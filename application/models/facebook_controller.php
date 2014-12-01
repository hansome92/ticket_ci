<?php 
class Facebook_Controller extends CI_Model
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
		
		require './facebook-sdk/facebook.php';

		// Create our Application instance (replace this with your appId and secret).
		$this->facebook = new Facebook(array(
		  'appId'  => '594798117210015',
		  'secret' => '120b4c267cd035ea0c2782a1f9f7f442'
		));
		$this->database = $this->db->conn_id;
		if(isset($_REQUEST['code'])){
			$fbUser = $this->getfbUser();
			//echo '<xmp>'; print_r($fbUser);echo '</xmp>'; exit();
			$this->user->doLoginFacebook($fbUser);
			echo '<script>window.location.hash = ""</script>';
			//header('Location: '.$this->config->item('base_url').$_SERVER['PATH_INFO']);
			//echo '<xmp>'; print_r($_SERVER ); echo '</xmp>';
		}
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
	public function getLoginUrl(){
		// Get User ID
		$user = $this->facebook->getUser();

		// We may or may not have this data based on whether the user is logged in.
		//
		// If we have a $user id here, it means we know the user is logged into
		// Facebook, but we don't know if the access token is valid. An access
		// token is invalid if the user logged out of Facebook.

		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $this->facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		//print_r($user_profile['id']);
		//echo $user_profile['id'];
		// Login or logout url will be needed depending on current user state.
		if ($user) {
			//$logoutUrl = $this->facebook->getLogoutUrl();
				return array('id' => $user_profile['id']);
		} else {
			$statusUrl = $this->facebook->getLoginStatusUrl();
			$loginUrl = $this->facebook->getLoginUrl();
		
			return array('url' => $loginUrl);
		}
	}
	public function checkForsharedStatus($order_id=''){
		// Get User ID
		$user = $this->facebook->getUser();

		// We may or may not have this data based on whether the user is logged in.
		//
		// If we have a $user id here, it means we know the user is logged into
		// Facebook, but we don't know if the access token is valid. An access
		// token is invalid if the user logged out of Facebook.

		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $this->facebook->api('/100000509333623/posts');
				//echo $user_profile['id'];
				//$user_profile = $this->facebook->api('/'.$user_profile['id'].'/statuses');
				//print_r($user_profile);
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		if($order_id != ''){
			$this->buyer_orders->insertOrderPreference($order_id, 'shared_on_facebook', '1');
		}
		return true;
	}
	public function getFBEventInfo($event_id){

		//if ($user) {
		try {
			// Proceed knowing you have a logged in user who's authenticated.
			$event_profile = $this->facebook->api('/'.trim($event_id));
			return $event_profile;
			
		} catch (FacebookApiException $e) {
			error_log($e);
		}
		return false;
	}
	public function getFBEventHeader($event_id, $fb_event_id){
		try {
			// Get event info about the cover and download it.
			$event_profile = $this->facebook->api('/'.trim($fb_event_id).'?fields=cover');
			if(isset($event_profile['cover']['source']) && $event_profile['cover']['source'] != ''){
				$content = file_get_contents($event_profile['cover']['source']);
				$newName = $this->user->randomPassword(8);
				$save = file_put_contents("./uploads/cover_photos/_src/".$newName.'.jpg',$content);
				return $newName.'.jpg';
			}
		} catch (FacebookApiException $e) {
			error_log($e);
		}
		//echo '<xmp>'; print_r($user_profile);echo '</xmp>'; exit();
		return false;
	}
}
?> 