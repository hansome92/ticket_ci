<?php 
class Twitter_Controller extends CI_Model
{
	/**
	 *	Object properties
	 */
	private $wizard;
	private $database;
	private $twitter;
	private $oauth_token;
	private $oauth_token_secret;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		/*require './twitter/twitteroauth.php';
		$this->oauth_token = ($this->session->userdata('oauth_token') != false ? $this->session->userdata('oauth_token') : NULL);
		$this->oauth_token_secret = ($this->session->userdata('oauth_token_secret') != false ? $this->session->userdata('oauth_token_secret') : NULL);
		$this->twitter = new TwitterOAuth('qUiOBzMf6RKu2ANDb6Shg', '2LtcPns2PCm9SStEABJ0DWjCPKR79sVEWbLYOufYQ', $this->oauth_token, $this->oauth_token_secret);
		if(isset($_GET['oauth_verifier'])){
			// Let's request the access token
			$access_token = $this->twitter->getAccessToken($_GET['oauth_verifier']);
			// Save it in a session var
			$_SESSION['access_token'] = $access_token;
			// Let's get the user's info
			$user_info = $this->twitter->get('account/verify_credentials');
			// Print user's info
			print_r($user_info);
		}
		else{
			$result =  $this->twitter->getRequestToken('http://tibbaa.com/dev');

			// Saving them into the session
			//$this->session->set_userdata(array('oauth_token' => $result['oauth_token'], 'oauth_token_secret' => $result['oauth_token_secret']));

			if($this->twitter->http_code==200){
				// Let's generate the URL and redirect
				$url = $this->twitter->getAuthorizeURL($result['oauth_token']);
				echo '<a href="'.$url.'">'.$url.'</a>'; 

				exit();
				//header('Location: '. $url);
			} else {
				// It's a bad idea to kill the script, but we've got to know when there's an error.
				die('Something wrong happened.');
			}
			echo '<xmp>'; print_r($url); echo '</xmp>';
		}*/
		$this->database = $this->db->conn_id;
	}
	public function getTwitterUser(){
		// Get User ID
		$user = $this->twitter->getUser();

		
	}
}
?> 