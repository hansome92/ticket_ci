<?php 
class App_api extends CI_Model
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
		Function needs to be changed when there's multiple roles on one event
	 */
	public function checkTicket(){
		/*
			Format code to required code for system
		 */
		if(!isset($_REQUEST['code'])){
			return 0;
		}
		$newTicketID = substr_replace($_REQUEST['code'], '', -2, 7);
		$newTicketID = $newTicketID - 0;
		//echo $newTicketID.'<br>';
		/*
			Check if ticketnumber exists
		 */
		$query = "SELECT * FROM ticketnumbers WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $newTicketID);
		$db->execute();
		if($db->rowCount() < 1){
			return 1;
		}
		/*
			If the ticket exists
		 */
		$ticket = $db->fetch(PDO::FETCH_ASSOC);
		if($ticket['Scanned_in'] != 1){
			//$query = "SELECT * FROM eticketbuyer eb LEFT JOIN events e ON e.EventID = eb.EventID WHERE eb.ID = :id AND e.UserID = :user_id";
			$query = "SELECT * FROM eticketbuyer eb LEFT JOIN events e ON e.EventID = eb.EventID WHERE eb.ID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticket['EticketBuyerID']);
			//$db->bindValue(":user_id", $_POST['userid']);
			$db->execute();
			/*
				If everything is right, update ticket to scanned and return true
			 */
			if($db->rowCount() > 0){
				$query = "UPDATE ticketnumbers SET Scanned_in = :value, IPADRES = :ip_address, DATUMTIJD = :datumtijd WHERE ID = :id";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $newTicketID);
				$db->bindValue(":value", 1);
				$db->bindValue(":ip_address", (isset($_REQUEST['IPADRES']) ? $_REQUEST['IPADRES'] : $_SERVER['REMOTE_ADDR']));
				$db->bindValue(":datumtijd", (isset($_REQUEST['DATUMTIJD']) ? $_REQUEST['DATUMTIJD'] : time()));
				$db->execute();

				return true;
			}
			/*
				If the user isnt correct, return false
			 */
			else{
				return 3;
			}
		}
		else{
			return 2;
		}
	}
}
?> 