<?php 

class Buyer_events extends CI_Model
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
	public function load_frontpage_events()
	{
		// Query to get all the events from a certain user that's logged in.
		$query = "SELECT * FROM events e";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();

		$events = $db->fetchAll();
		// Loop through the steps and get associated fields
		foreach ($events as $key => $event) {
			$query = "SELECT * FROM eventspreferences ep WHERE ep.EventID=:event_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":event_id", $event['EventID']);
			$db->execute();
			
			if ($db->rowCount() > 0){
				while( $row = $db->fetch(PDO::FETCH_ASSOC)){
					$events[$key]['preferences'][$row['Field']] = $row;
				}
				//$events[$key]['preferences'] = $db->fetchAll();
			}
			/*
				Get customisation preferences
			 */

			$query = "SELECT * FROM eventscustomisationpreferences ep WHERE ep.EventID=:event_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":event_id", $event['EventID']);
			$db->execute();
			
			foreach ($db->fetchAll(PDO::FETCH_ASSOC) as $keyofpreference => $valueofpreference)
			{
				$events[$key]['customisationpreferences'][$valueofpreference['Field']] = $valueofpreference;
			}
			/*
				Get tickets
			 */
			$events[$key]['tickets'] = $this->getTickets($event['EventID']);
		}
		return $events;
	}
	// This is the function that loads all the variables for the detailed event page including acts, information, etc.
	
	public function load_event($meta){
		// Get event plus preferences
		$query = "SELECT * FROM events WHERE MetaLink=:meta";
		$db = $this->database->prepare($query);
		$db->bindValue(":meta", $meta);
		$db->execute();
		$event = $db->fetch(PDO::FETCH_ASSOC);

		// Loop through the steps and get associated fields
		$query = "SELECT * FROM eventspreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event['EventID']);
		$db->execute();
		
		foreach ($db->fetchAll(PDO::FETCH_ASSOC) as $key => $value)
		{
			$event['preferences'][$value['Field']] = $value;
		}

		// Get customisation options for this event
		$query = "SELECT * FROM eventscustomisationpreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event['EventID']);
		$db->execute();
		
		foreach ($db->fetchAll(PDO::FETCH_ASSOC) as $key => $value)
		{
			$event['customisationpreferences'][$value['Field']] = $value;
		}
		$event['acts'] = $this->getActs($event['EventID']);
		$event['tickets'] = $this->getTickets($event['EventID']);

		return $event;
	}
	/*
		Get event data by an ID instead of metalink (used by cron job sending tickets)
	 */
	public function getEventDataByID($id){
		// Get event plus preferences
		$query = "SELECT * FROM events WHERE EventID=:id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		$event = $db->fetch(PDO::FETCH_ASSOC);

		// Loop through the steps and get associated fields
		$query = "SELECT * FROM eventspreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event['EventID']);
		$db->execute();
		
		foreach ($db->fetchAll(PDO::FETCH_ASSOC) as $key => $value)
		{
			$event['preferences'][$value['Field']] = $value;
		}
		// Get customisation options for this event
		$query = "SELECT * FROM eventscustomisationpreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event['EventID']);
		$db->execute();
		
		foreach ($db->fetchAll(PDO::FETCH_ASSOC) as $key => $value)
		{
			$event['customisationpreferences'][$value['Field']] = $value;
		}
		// Get customisation options for this event
		$query = "SELECT * FROM eventsponsorpreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event['EventID']);
		$db->execute();
		
		foreach ($db->fetchAll(PDO::FETCH_ASSOC) as $key => $value)
		{
			$event['eventsponsorpreferences'][$value['Field']] = $value;
			
			if($value['Field'] != 'barcode'){
				$sql = "SELECT * FROM sponsorblockspreferences WHERE SponsorBlockID = :id AND Field = 'image'";
				$stmt = $this->database->prepare($sql);
				$stmt->bindValue(":id", $value['Value']);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$event['eventsponsorpreferences'][$key]['image'] = $result['Value'];
			}
		}
		$event['acts'] = $this->getActs($event['EventID']);
		$event['tickets'] = $this->getTickets($event['EventID']);

		return $event;
	}
	public function getActs($event_id){

		return false;
	}
	public function getTickets($event_id){
		// Get event plus preferences
		$query = "SELECT * FROM etickets WHERE EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event_id);
		$db->execute();
		$tickets = $db->fetchAll(PDO::FETCH_ASSOC);

		// Loop through the steps and get associated fields
		foreach ($tickets as $key => $value) {
			try{
				$query = "SELECT * FROM eticketspreferences ep WHERE ep.EticketID=:id";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $value['ID']);
				$db->execute();
				while($row = $db->fetch(PDO::FETCH_ASSOC)){
					$tickets[$key]['preferences'][$row['Field']] = $row;
				}
				$tickets[$key]['available'] = $this->checkAvailability($value['ID']);
			}
			catch(Exception $e){

			}
		}
		return $tickets;
	}

	// Function to get an Event ID by the metalink
	public function getEventIDByMeta($meta){
		$query = "SELECT * FROM events WHERE MetaLink = :meta";
		$db  = $this->database->prepare($query);
		$db->bindValue(":meta", $meta);
		$db->execute();
		$row = $db->fetch(PDO::FETCH_ASSOC);
		return $row['EventID'];
	}
	/*
		Check if tickets are still available
	 */
	public function checkAvailability($ticket_id){
		/*
		Get total amount of bought tickets
		 */
		$query = "SELECT SUM(QUANTITY) AS total_sold FROM eticketbuyer WHERE EticketID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $ticket_id);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);
		$total_sold = $result['total_sold'];
		/*
		Get total allowed tickets sold
		 */
		$query = "SELECT Value FROM eticketspreferences WHERE EticketID = :id AND Field = :field";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $ticket_id);
		$db->bindValue(":field", 'tickets-capacity');
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);
		$total_available = $result['Value'];
		if(($total_available - $total_sold) < 1){
			return false;
		}
		else{
			return true;
		}
	}
}

?>