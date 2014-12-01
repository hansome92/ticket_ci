<?php 

class Translation extends CI_Model
{
	/**
	 *	Object properties
	 */
	private $database;
	private $language = 1;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('user');

		$this->database = $this->db->conn_id;

		/*************************************************
			First check if a language has been posted
		*************************************************/
		if(isset($_POST['language']) && $_POST['language'] != '' && is_numeric($_POST['language'])){
			$this->language = $_POST['language'];
			if($this->user->isLoggedIn() === true){
				//$this->user->setPreference(99, $this->language);
			}
			else{
				$this->session->set_userdata(array('language' => $this->language));
			}
		}
		/***************************************************************************************
			If no post has been made, check if user is logged in, if yes then get the setting
		***************************************************************************************/
		elseif($this->user->isLoggedIn() === true){
				if($setting = $this->user->getsetting(99) !== false){
				$this->language = $setting;
			}
		}
		/*******************************************************
			If not logged in but something is in the session
		*******************************************************/
		elseif($this->session->userdata('language') !== false){
			$this->language = $this->session->userdata('language');
		}
		/************************************
			If nothing has been set, get code by IP address
		************************************/
		else{
			$this->language = $this->getLocalCode();
		}		// Todo: set $this->language based on session.
	}

	/**
	 * function set_language()
	 * Updates $language property based
	 */
	public function getLocalCode(){
		return 1;
	}
	public function set_language($language_code){
		
		// If language code is a string
		if (!is_numeric($language_code)) {
			
			// Check if language code exists
			$query = "SELECT * FROM langcodes WHERE code=:code";
			$db = $this->database->prepare($query);
			$db->bindValue(":code", $languange_code, PDO::PARAM_INT);
			$db->execute();
			
			if ($db->rowCount() == 1)
			{
				$this->language = $language_code;
				return true;
			}
			
			return false;
		}
		
		return false;
	}
	
	/**
	 * function get_language()
	 * returns property $language
	 */
	public function get_language(){
		// check if property language has been defined
		if (!empty($this->language))
		{
			return $this->language;
		}
		return false;
	}
	
	/**
	 * function get()
	 * gets translation of given string
	 */
	public function get($string){
		$sql = "SELECT * FROM langstrings WHERE String = :string";
		
		$db = $this->database->prepare($sql);
		$db->bindValue(":string", $string, PDO::PARAM_STR);
		$db->execute();
		
		
		// When there is a translation, get and return it
		if ($db->rowCount() > 0){
			$row = $db->fetch(PDO::FETCH_ASSOC);
			$query = "SELECT * FROM langstringstranslated WHERE TranslationOf = :id AND LangCode = :langcode";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $row['ID']);
			$db->bindValue(":langcode", $this->language);
			$db->execute();
			$result = $db->fetch(PDO::FETCH_ASSOC);

			if(!isset($result['String']) || $result['String'] == ''){
				return $row['String'];
			}
			else{
				return $result['String'];
			}
		}
		else{
			/**********************************************************
				Check if it exists in database, otherwise create it
			**********************************************************/
			if($db->rowCount() < 1){
				$insertStringQuery = "INSERT INTO langstrings(String) VALUES (:string)";
				$db = $this->database->prepare($insertStringQuery);
				$db->bindValue(":string", $string, PDO::PARAM_STR);
				$db->execute();
			}

			return $string;
		}
	}
	public function getLanguages(){
		$query = "SELECT * FROM langcodes";
		$db = $this->database->prepare($query);
		$db->execute();
		$data = $db->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
}

?>