<?php 

class Events extends CI_Model
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
	public function getEventtypes( $main_id=0 )
	{
		// Query to get all the events from a certain user that's logged in.
		if($main_id != 0 && $main_id != ''){
			$query = "SELECT * FROM eventtypes WHERE MainID=:main";
			$db = $this->database->prepare($query);
			$db->bindValue(":main", $main_id);
		}
		else{
			$query = "SELECT * FROM eventtypes";
			$db = $this->database->prepare($query);
		}
		
		$db->execute();
		return $db->fetchAll(PDO::FETCH_ASSOC);
	}
	/*
		Claculation of tickets used in dashboard for statistics
	 */	
	public function registerNewEventtype( $main_id=0 ){
		try{
			if($main_id != 0){
				$query = "INSERT INTO eventtypes(Type, MainID) VALUES (:type, :main_id)";
				$db = $this->database->prepare($query);
				$db->bindValue(":type", $_POST['type']);
				$db->bindValue(":main_id", $main_id);
			}
			else{
				$query = "INSERT INTO eventtypes(Type) VALUES (:type)";
				$db = $this->database->prepare($query);
				$db->bindValue(":type", $_POST['type']);
			}
			// Set up the PDO query
			$db->execute();

			// Return the inserted ID for the redirect through Javascript on the wizard.
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>