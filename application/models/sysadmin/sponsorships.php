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
		$query = "SELECT * FROM sponsorblocks";
		$db = $this->database->prepare($query);
		
		$db->execute();
			
		$events = $db->fetchAll();
		// Loop through the steps and get associated fields
		foreach ($events as $key => $event) 
		{
			$query = "SELECT * FROM sponsorblockspreferences ep WHERE ep.SponsorBlockID=:id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $event['ID']);
			$db->execute();
			
			if ($db->rowCount() > 0)
			{
				while($row = $db->fetch(PDO::FETCH_ASSOC)){
					$events[$key]['preferences'][$row['Field']] = $row;
				}
			}
		}
		return $events;
	}
	/*
		Claculation of tickets used in dashboard for statistics
	 */	
	public function registerNewSponsorship(){
		try{
			// Set up the PDO query
			$query = "INSERT INTO sponsorblocks(UserID, end_date) VALUES (:userid, :end_date)";
			$db = $this->database->prepare($query);
			$db->bindValue(":userid", '0');
			$db->bindValue(":end_date", $_POST['date']);
			$db->execute();

			// Get the last inserted ID
			$inserted_id = $this->database->lastInsertId();
			// Start the loop for each of the preferences loaded in the wizard/form.
			// 
			if(isset($_FILES['image']) && $_FILES['image'] != ''){

				if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["image"]["tmp_name"];
					$name = explode('.', $_FILES["image"]["name"]);
					$_POST['image'] = $this->user->randomPassword(8).'.' . end($name);
					move_uploaded_file($tmp_name, "./uploads/promotion_images/".$_POST['image']);
				}
			}

			foreach($_POST as $key => $value){
				if($value != ''){
					// Insert every preferences into the datavase
					$query = "INSERT INTO sponsorblockspreferences(SponsorBlockID, Field, Value) VALUES (:id, :pref_id, :var)";
					$db = $this->database->prepare($query);
					$db->bindValue(":id", $inserted_id);
					$db->bindValue(":pref_id", $key);
					$db->bindValue(":var", $value);
					$db->execute();
				}
			}
			// Return the inserted ID for the redirect through Javascript on the wizard.
			return $inserted_id;
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>