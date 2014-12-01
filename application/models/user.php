<?php 

class User extends CI_Model
{
	var	$db_host,
		$db_name,
		$db_user,
		$db_password,
		$connection,
		$email,
		$password;
	
	var $privileges = array(
		"add_project" => 1,
		"edit_project" => 1
	);
	
	private $code = "%C8ex#5S&**X3yazLds&";
	/**
	 * Constructor
	 */
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->database = $this->db->conn_id;
	}
	/**
	 * Check if the user is logged in
	 * @return true or false
	 */
	function isLoggedIn()
	{
		if($this->session->userdata('logged_in') == true){
			//echo $this->session->userdata('email');
			return true;
		}
		else{
			return false;
		}
	}
	/************************************
			Login Facebook function
	************************************/
	function doLoginFacebook($fbUserProfile){
		/*
			Check if variables are correctly set
		 */
		if($fbUserProfile['id'] == '' || $fbUserProfile['name'] == ''){
			return false;
		}
		/************************************
			 Check if user exists already		
		************************************/
		$query = "SELECT *, p.ID as user_id FROM user p LEFT JOIN userpreferences pp ON p.ID = pp.UserID WHERE pp.Field = :field AND pp.Value = :value";
		$stmt = $this->db->conn_id->prepare($query);
		$stmt->bindValue(':field', '98', PDO::PARAM_STR);
		$stmt->bindValue(':value', $fbUserProfile['id'], PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$user_id = $row['user_id'];
		}
		/************************************
			If user doesnt exist, register it
		************************************/
		else{
			$query = "INSERT INTO user(UserType, LastActive) VALUES(:usertype, NOW())";
			$stmt = $this->db->conn_id->prepare($query);
			$stmt->bindValue(':usertype', '1', PDO::PARAM_STR);
			$stmt->execute();

			$user_id = $this->database->lastInsertId();

			$preferences = array(
				3 => 'first_name',
				6 => 'link',
				96 => array(0 => 96, 1 => 1, 2 => 'login type'),
				97 => 'last_name',
				98 => 'id'
				);
			foreach ($preferences as $key => $value) {
				$query = "INSERT INTO userpreferences(UserID, Field, Value) VALUES(:user_id, :field, :value)";
				$stmt = $this->db->conn_id->prepare($query);
				$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
				if(!is_array($value)){
					$stmt->bindValue(':field', $key, PDO::PARAM_STR);
					$stmt->bindValue(':value', $fbUserProfile[$value], PDO::PARAM_STR);
				}
				else{
					$stmt->bindValue(':field', $key, PDO::PARAM_STR);
					$stmt->bindValue(':value', $value[1], PDO::PARAM_STR);
				}
				$stmt->execute();
			}
		}
		/************************************
			Set session status to logged in

		************************************/
		$logindata = array(
			'user_id'		=> $user_id,
			'user_level'	=> 1,
			'type_login'	=> 'facebook',
			'logged_in' 	=> true
		);
		$this->session->set_userdata($logindata);
		//print_r($_POST);
		if(!isset($_POST['refresh']) || $_POST['refresh'] != false){
			//ob_clean();
			//echo 'Location: '.$this->config->item('base_url').'dashboard';
			//header('Location: '.$this->config->item('base_url').'dashboard');
		}
	}
	/************************************
				Login function
	************************************/
	function doLogin($username, $password, $level='')
	{
		$this->load->library('encrypt');
		$query = "SELECT *, p.ID as user_id FROM user p LEFT JOIN userpreferences pp ON p.ID = pp.UserID WHERE p.UserName = :name AND Field = :field AND pp.Value = :pass";
		$pdoStatement = $this->db->conn_id->prepare($query);
		$pdoStatement->bindValue(':name', $username, PDO::PARAM_STR);
		$pdoStatement->bindValue(':field', '7', PDO::PARAM_STR);
		$pdoStatement->bindValue(':pass', $this->encrypt->sha1($password), PDO::PARAM_STR);

		$pdoStatement->execute();
		// If no user/password combo exists return false
		if( $pdoStatement->rowCount() != 1)
		{
			return false;
		}
		else // matching login ok
		{	
			$row = $pdoStatement->fetch();
			$logindata = array(
			   'username'   => $row['UserName'],
			   'user_id'	=> $row['user_id'],
			   'user_level'	=> $row['UserType'],
			   'logged_in' 	=> true
		       );
			$this->db->query("UPDATE user SET LastActive = '".time()."' WHERE ID='".$row['user_id']."'");
			$this->session->set_userdata($logindata);
			
		}
		return true;
	}
	/************************************
	 		Login function promoter // Obsolete, now returning value of 'doLogin' to prevent errors
	************************************/
	function doLoginPromoter($username, $password)
	{
		return $this->doLogin($username, $password);
	}
	
	/************************************
	 		Login function buyer // Obsolete, now returning value of 'doLogin' to prevent errors
	************************************/
	
	function doLoginBuyer($username, $password)
	{
		return $this->doLogin($username, $password);
	}
	/**
	 * Destroy session data/Logout.
	 */
	function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		session_destroy();
		return true;
	}

	/**
	 * Get username
	 */
	public function getUser()
	{
		$query = "SELECT * FROM user WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $this->session->userdata('user_id'));
		$db->execute();
		// Get gebruikersnaam uit sessie
		
		$row = $db->fetch();
		$query = "SELECT * FROM userpreferences WHERE UserID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $this->session->userdata('user_id'));
		$db->execute();
		while($result = $db->fetch(PDO::FETCH_ASSOC)){
			$row['preferences'][$result['Field']] = $result;
		}
		return $row;
	}
	
	public function getUserInfoById($id) {
		$query = "SELECT * FROM user WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);
		
		$query = "SELECT * FROM userpreferences WHERE UserID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		while( $row = $db->fetch(PDO::FETCH_ASSOC) ){
			$result['preferences'][$row['Field']] = $row;
		}
		
		return $result;
	}
	
	/**
	 * create a random password
	 * 
	 * @param	int $length - length of the returned password
	 * @return	string - password
	 */
	public function randomPassword($length = 8)
	{
		$pass = "";
		
		// possible password chars.
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
		for($i=0 ; $i < $length ; $i++)
		{
			$pass .= $chars[mt_rand(0, count($chars) -1)];
		}	
		return $pass;
	}
	public function doesUserExist($name, $module)
	{
		$query = "SELECT * FROM promoter WHERE ".$module."Name = :name";
		$pdoStatement = $this->database->prepare($query);
		$pdoStatement->bindValue(':name', $name, PDO::PARAM_STR);
		$pdoStatement->execute();
		if($pdoStatement->rowCount() < 1)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	public function registerPromoter(){
		// Maak gebruiker aan
		$query = "INSERT INTO user(UserName) VALUES (:username)";
		$db = $this->database->prepare($query);
		$db->bindValue(":username", $_POST['preferences'][4]);
		$db->execute();

		$user_id = $this->database->lastInsertId();

		foreach($_POST['preferences'] as $key => $value){
			if($value != ''){
				if($key == 7){
					$this->load->library('encrypt');
					$var = $this->encrypt->sha1($value);
				}
				else{
					$var = $value;
				}
				$query = "INSERT INTO userpreferences(UserID, Field, Value) VALUES (:id, :pref_id, :var)";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $user_id);
				$db->bindValue(":pref_id", $key);
				$db->bindValue(":var", $var);
				$db->execute();
			}
		}
	}
	/************************************
			Register a new person // Temporary function for demo
	************************************/
	public function temporaryRegister($username='', $password=''){
		// Maak gebruiker aan
		$query = "INSERT INTO user(UserName, LastActive) VALUES (:username, NOW())";
		$db = $this->database->prepare($query);
		$db->bindValue(":username", $username);
		$db->execute();

		$user_id = $this->database->lastInsertId();

		$this->load->library('encrypt');
		$var = $this->encrypt->sha1($password);

		$query = "INSERT INTO userpreferences(UserID, Field, Value) VALUES (:id, :pref_id, :var)";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $user_id);
		$db->bindValue(":pref_id", 7);
		$db->bindValue(":var", $var);
		$db->execute();
		return true;
	}
	public function ticketboxRegister(){
		// Maak gebruiker aan
		$query = "INSERT INTO user(UserName, LastActive) VALUES (:username, NOW())";
		$db = $this->database->prepare($query);
		$db->bindValue(":username", $_POST['emailaddress']);
		$db->execute();

		$user_id = $this->database->lastInsertId();

		foreach ($_POST['preferences'] as $key => $value) {
			$this->load->library('encrypt');
			if($key == 7){
				$value = $this->encrypt->sha1($value);
			}

			$query = "INSERT INTO userpreferences(UserID, Field, Value) VALUES (:id, :pref_id, :var)";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $user_id);
			$db->bindValue(":pref_id", $key);
			$db->bindValue(":var", $value);
			$db->execute();
		}
		
		return true;
	}
	public function registerBuyer(){
		// Maak gebruiker aan
		$query = "INSERT INTO user(UserName) VALUES (:name)";
		$db = $this->database->prepare($query);
		$db->bindValue(":name", $_POST['preferences'][4]);
		$db->execute();

		$user_id = $this->database->lastInsertId();

		foreach($_POST['preferences'] as $key => $value){
			if($value != ''){
				if($key == 7){
					$this->load->library('encrypt');
					$var = $this->encrypt->sha1($value);
				}
				else{
					$var = $value;
				}
				$query = "INSERT INTO userpreferences(BuyerID, Field, Value) VALUES (:id, :pref_id, :var)";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $user_id);
				$db->bindValue(":pref_id", $key);
				$db->bindValue(":var", $var);
				$db->execute();
			}
		}
	}
	public function getEmail(){
		$query = "SELECT * FROM userpreferences WHERE UserID = :user_id AND Field = :field";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->bindValue(":field", '5');
		$db->execute();

		$row = $db->fetch(PDO::FETCH_ASSOC);
		return $row['Value'];

	}
	/************************************
			Get certain setting // $user isnt needed as parameter when its about the logged in user
	************************************/
	public function getsetting($preferenceCode='', $user=''){
		$query = "SELECT * FROM userpreferences WHERE UserID = :user_id AND Field = :field";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", ($user == '' ? $this->session->userdata('user_id') : $user) );
		$db->bindValue(":field", $preferenceCode);
		$db->execute();

		$row = $db->fetch(PDO::FETCH_ASSOC);
		return $row['Value'];
	}
	public function saveSettings(){
		try {
			foreach ($_POST['user']['preferences'] as $key => $value) {
				if($key == 'email'){
					$query = "UPDATE user SET UserName = :value WHERE ID = :id";
					$db = $this->database->prepare($query);
					$db->bindValue(":id", $this->session->userdata('user_id'));
					$db->bindValue(":value", $value);
					$db->execute();
				}
				else{
					
				}
			}
		} catch (Exception $e) {
			
		}
	}
	public function sendNewPassword($username){
		try {
			$query = "SELECT * FROM user WHERE UserName = :username AND UserType = :type";
			$db = $this->database->prepare($query);
			$db->bindValue(":username", $username);
			$db->bindValue(":type", '0');
			$db->execute();
			if($db->rowCount() == 1){
				$row = $db->fetch(PDO::FETCH_ASSOC);
				$newPassword = $this->randomPassword(8);

				$query = "UPDATE user SET Value = :newpass WHERE Field = :field AND UserName = :username";
				$db = $this->database->prepare($query);
				$db->bindValue(":username", $username);
				$db->bindValue(":field", '7');
				$db->bindValue(":newpass", $this->encrypt->sha1($newPassword));
				$db->execute();
				/*
					Send the email
				 */
				$mail = new PHPMailer();

				$message = file_get_contents($this->config->item('base_url').'mail_lostpass.html');

				$mail->AddReplyTo('no-reply@tibbaa.com', 'Tibbaa Second Generation Ticketing');
				$mail->AddAddress( $username, '');
				$mail->SetFrom('no-reply@tibbaa.com', 'Tibbaa Second Generation Ticketing');

				$mail->Subject = 'Password request';
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

				$newMessage = str_replace('%pass%', $newPassword, $message);
				$newMessage = str_replace('%link%', $this->config->item('base_url'), $newMessage);
				$mail->MsgHTML($newMessage);
				$mail->Send();
				return true;
			}
			else{
				return 'Emailaddress was not recognised.';
			}

		} catch (Exception $e) {
			
		}
		
	}
}

?>