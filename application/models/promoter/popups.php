<?php 

class Popups extends CI_Model
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
		
		$this->database = $this->db->conn_id;
	}
	/*
		Claculation of tickets used in dashboard for statistics
	 */
	public function getPopup($page_id = ''){
		$query = "SELECT * FROM popups WHERE PageID = :page_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":page_id", $page_id);
		$db->execute();
		while($result = $db->fetch(PDO::FETCH_ASSOC)){
			$queryPrefs = "SELECT * FROM useragreementspreferences WHERE UserID = :user_id AND PopupID = :id";
			$stmt = $this->database->prepare($queryPrefs);
			$stmt->bindValue(":id", $result['ID']);
			$stmt->bindValue(":user_id", $this->session->userdata('user_id'));
			$stmt->execute();

			if($stmt->rowCount() > 0){
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($result['Type'] == '1' && $row['Value'] != 'agree'){
					$flag = false;
				}
			}
			else{
				$flag = true;
			}
			if(isset($flag) && $flag == true){
 				$preferencesquery = "SELECT * FROM popupspreferences WHERE PopupID = :id";
 				$prefsdb = $this->database->prepare($preferencesquery);
 				$prefsdb->bindValue(":id", $result['ID']);
 				$prefsdb->execute();	
 				while( $prefsresult = $prefsdb->fetch(PDO::FETCH_ASSOC)){
 					$result['preferences'][$prefsresult['Field']] = $prefsresult;
 				}
 				return $result;
			}
		}
		return '';
	}
	public function saveAnswer(){
		$id = $_POST['popupid'];
		$answer = $_POST['answer'];
		$user_id = $this->session->userdata('user_id');

		$query = "SELECT * FROM useragreementspreferences WHERE UserID = :user_id AND PopupID = :popup_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $user_id);
		$db->bindValue(":popup_id", $id);
		$db->execute();
		if($db->rowCount() > 0){
			$query = "UPDATE useragreementspreferences SET Value = :value WHERE UserID = :user_id AND PopupID = :popup_id";
		}
		else{
			$query = "INSERT INTO useragreementspreferences(UserID, PopupID, Value) VALUES (:user_id, :popup_id, :value)";
		}
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $user_id);
		$db->bindValue(":popup_id", $id);
		$db->bindValue(":value", $answer);
		$db->execute();

		return true;
	}
	public function getPopupContent(){
		$popupid = $_POST['popupid'];

		$query = "SELECT * FROM wizardstepsdefaultpreferences WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $popupid);
		$db->execute();
		return $db->fetch(PDO::FETCH_ASSOC);

	}
}
?>