<?php 

class Sponsorships extends CI_Model
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
	// Load all the events
	public function getsponsorships()
	{
		// Query to get all the events from a certain user that's logged in.
		$query = "SELECT sb.* FROM sponsorblocks sb LEFT JOIN sponsorblockspreferences sbp ON sb.ID = sbp.SponsorBlockID WHERE (sb.UserID = :user_id AND sbp.Field = 'custom' AND sbp.Value = '1') OR (sb.UserID = '0') GROUP BY sb.ID";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		
		$db->execute();
			
		$events = $db->fetchAll(PDO::FETCH_ASSOC);
		// Loop through the steps and get associated fields
		foreach ($events as $key => $event){
			$query = "SELECT * FROM sponsorblockspreferences ep WHERE ep.SponsorBlockID=:id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $event['ID']);
			$db->execute();
			
			if ($db->rowCount() > 0){
				while($row = $db->fetch(PDO::FETCH_ASSOC)){
					$events[$key]['preferences'][$row['Field']] = $row;
				}
			}
		}
		return $events;
	}
	public function saveElement(){
		if ($_FILES["upload-element"]["error"] == UPLOAD_ERR_OK) {

			$tmp_name = $_FILES["upload-element"]["tmp_name"];
			$name = explode('.', $_FILES["upload-element"]["name"]);
			if(end($name) != 'jpg' && end($name) != 'png'){
				return array('result' => false, 'error' => 'The posted picture isn\'t a valid type.');
			}
			$elementName = $this->user->randomPassword(8).'.' . end($name);
			move_uploaded_file($tmp_name, "./uploads/promotion_images/".$elementName);

			// *** Include the class
			/*$this->load->model('promoter/resize');

			$this->resize->openImage("./uploads/promotion_images/".$elementName);
			if($this->resize->width > 300 || $this->resize->height > 300){
				// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
				//$this->resize->resizeImage(300, 300, 'crop');
				//$this->resize->saveImage("./uploads/promotion_images/".$elementName, 75);

				$resized = true;
			}
			else{
				$resized = false;
			}*/
			$query = "INSERT INTO sponsorblocks(UserID, end_date) VALUES (:user_id, NOW())";
			$db = $this->database->prepare($query);
			$db->bindValue(":user_id", $this->session->userdata('user_id'));
			$db->execute();
			$inserted_id = $this->database->lastInsertId();

			$query = "INSERT INTO sponsorblockspreferences(SponsorBlockID, Field, Value) VALUES (:id, :field, :value)";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $inserted_id);
			$db->bindValue(":field", 'image');
			$db->bindValue(":value", $elementName);
			$db->execute();


			$db->bindValue(":id", $inserted_id);
			$db->bindValue(":field", 'custom');
			$db->bindValue(":value", '1');
			$db->execute();

			return array('id' => $inserted_id, 'url' => $elementName, 'resized' => (!empty($resized) ? $resized : '' ));
		}
	}
	public function deleteElement($url){
		
		$query = "SELECT * FROM sponsorblockspreferences WHERE Field = 'image' AND Value = :val";
		$db = $this->database->prepare($query);
		$db->bindValue(":val", $url);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);
		$id = $result["SponsorBlockID"];

		$query = "DELETE FROM sponsorblocks WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();

		$query = "DELETE FROM sponsorblockspreferences WHERE SponsorBlockID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		if(file_exists('./uploads/promotion_images/'.$url)){
			unlink('./uploads/promotion_images/'.$url);
		}
		return true;
	}
	public function connectSponsorshipsToTicket($event_id){
		foreach ($_POST['ticketpieces'] as $key => $value) {
			$query = "SELECT * FROM eventsponsorpreferences WHERE EventID = :id AND Field = :field";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $event_id);
			$db->bindValue(":field", $key);
			$db->execute();

			if($db->rowCount() > 0){
				$query = "UPDATE eventsponsorpreferences SET Value = :value WHERE EventID = :id AND Field = :field";
			}
			else{
				$query = "INSERT INTO eventsponsorpreferences(EventID, Field, Value) VALUES (:id, :field, :value)";
			}
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $event_id);
			$db->bindValue(":field", $key);
			$db->bindValue(":value", ($value == '' ? '' : $value));
			$db->execute();
		}
	}
}
?>