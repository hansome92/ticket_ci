<?php 

class Sponsor_campaigns extends CI_Model
{
	/**
	 *	Object properties
	 */
	private $wizard;
	private $database;
	
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->database = $this->db->conn_id;
	}
	// Load all the events
	public function load_campaigns($limit=999999999)
	{
		// Query to get all the events from a certain user that's logged in.
		$query = "SELECT * FROM events WHERE UserID=:user_id LIMIT ".$limit;
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();
			
		$events = $db->fetchAll();
		// Loop through the steps and get associated fields
		foreach ($events as $key => $event) 
		{
			$query = "SELECT * FROM eventspreferences ep WHERE ep.EventID=:event_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":event_id", $event['EventID']);
			$db->execute();
			
			if ($db->rowCount() > 0)
			{
				while($row = $db->fetch(PDO::FETCH_ASSOC)){
					$events[$key]['preferences'][$row['Field']] = $row;
				}
			}
			$events[$key]['total_available_tickets'] = $this->countTotalTickets($event['EventID']);
			$events[$key]['tickets_pending'] = $this->countTicketsPending($event['EventID']);
			$events[$key]['tickets_sold'] = $this->countTicketsSold($event['EventID']);
			$events[$key]['tickets_scanned'] = $this->countTicketsScanned($event['EventID']);
		}
		return $events;
	}
	/*
		Claculation of tickets used in dashboard for statistics
	 */
	public function countTotalTickets($event_id){
		$query = "SELECT * FROM etickets e LEFT JOIN eticketspreferences ep ON ep.EticketID = e.ID WHERE e.EventID = :id AND ep.Field = :field";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $event_id);
		$db->bindValue(":field", 'tickets-capacity');
		$db->execute();
		$total = 0;
		while($result = $db->fetch(PDO::FETCH_ASSOC)){
			$total += $result['Value'];
		}
		return $total;
	}
	public function countTicketsPending($event_id){
		try{
			$query = "SELECT SUM(Quantity) AS total FROM eticketbuyer etb LEFT JOIN orders o ON o.OrderID = etb.OrderID WHERE etb.EventID = :id AND (etb.OrderID = '0' OR (o.Status = '1'))";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $event_id);
			$db->execute();
			$result = $db->fetch(PDO::FETCH_ASSOC);
			return ($result['total'] == NULL ? 0 : $result['total']);
		}
		catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function countTicketsSold($event_id, $ticket_id=''){
		$total = 0;
		$query = "SELECT * FROM eticketbuyer WHERE EventID = :id ".(isset($ticket_id) && $ticket_id != '' ? ' AND EticketID = "'.$ticket_id.'"' : '');
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $event_id);
		$db->execute();
		$result = $db->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $ticketbuyer){
			
			$query = "SELECT * FROM ticketnumbers WHERE EticketBuyerID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticketbuyer['ID']);
			$db->execute();
			$total += $db->rowCount();
		}
		return $total;
	}
	public function countTicketsScanned($event_id, $ticket_id=''){
		$total = 0;
		$query = "SELECT * FROM eticketbuyer WHERE EventID = :id".(isset($ticket_id) && $ticket_id != '' ? ' AND EticketID = "'.$ticket_id.'"' : '');
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $event_id);
		$db->execute();
		$result = $db->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $ticketbuyer){
			
			$query = "SELECT * FROM ticketnumbers WHERE EticketBuyerID = :id AND Scanned_in = :scanned";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticketbuyer['ID']);
			$db->bindValue(":scanned", '1');
			$db->execute();
			$total += $db->rowCount();
		}
		return $total;
	}
	// This is the function that loads all the variables for the detailed event page including acts, information, etc.
	public function load_event($event_id){
		// Get event plus preferences
		$query = "SELECT * FROM events WHERE EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event_id);
		$db->execute();
		$event = $db->fetch();
		// Loop through the steps and get associated fields
		$query = "SELECT * FROM eventspreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event_id);
		$db->execute();
		
		while ($row = $db->fetch(PDO::FETCH_ASSOC)){
			$event['preferences'][$row['Field']] = $row;
		}
		// Loop through the steps and get associated fields
		$query = "SELECT * FROM eventscustomisationpreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event_id);
		$db->execute();
		
		while ($row = $db->fetch(PDO::FETCH_ASSOC))
		{
			$event['eventscustomisationpreferences'][$row['Field']] = $row;
		}
		// Loop through the steps and get associated fields
		$query = "SELECT * FROM eventsponsorpreferences ep WHERE ep.EventID=:event_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":event_id", $event_id);
		$db->execute();
		
		while ($row = $db->fetch(PDO::FETCH_ASSOC)){
			$event['eventsponsorpreferences'][$row['Field']] = $row;

			$sql = "SELECT * FROM sponsorblockspreferences WHERE SponsorBlockID = :id";
			$stmt = $this->database->prepare($sql);
			$stmt->bindValue(":id", $row['Value']);
			$stmt->execute();
			while($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
				$event['eventsponsorpreferences'][$row['Field']]['preferences'][$row2['Field']] = $row2;
			}
		}
		$event['acts']= $this->getActs($event_id);
		$event['tickets']= $this->getTickets($event_id);

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
			$query = "SELECT * FROM eticketspreferences ep WHERE ep.EticketID=:id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $value['ID']);
			$db->execute();
			while($row = $db->fetch(PDO::FETCH_ASSOC)){
				$tickets[$key]['preferences'][$row['Field']] = $row;
			}
			$tickets[$key]['tickets_sold'] = $this->countTicketsSold($event_id, $value['ID']);
			$tickets[$key]['tickets_scanned'] = $this->countTicketsScanned($event_id, $value['ID']);
		}
		return $tickets;
	}
	/************************************
		   Register a new event		
	************************************/
			
	public function registerNewEvent(){
		try{
			if(isset($_POST['event_id']) && $_POST['event_id'] != ''){

				foreach($_POST as $key => $value){
					if($value != ''){
						$query = "SELECT * FROM eventspreferences WHERE EventID = :id AND Field = :pref_id";
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $_POST['event_id']);
						$db->bindValue(":pref_id", $key);
						$db->execute();
						if($db->rowCount() > 0){
							// Insert every preferences into the datavase
							$query = "UPDATE eventspreferences SET Value = :value WHERE EventID = :id AND Field = :pref_id";
							$db = $this->database->prepare($query);
							$db->bindValue(":id", $_POST['event_id']);
							$db->bindValue(":pref_id", $key);
							$db->bindValue(":value", $value);
							$db->execute();
						}
						else{
							// Insert every preferences into the datavase
							$query = "INSERT INTO eventspreferences(EventID, Field, Value) VALUES (:id, :pref_id, :var)";
							$db = $this->database->prepare($query);
							$db->bindValue(":id", $_POST['event_id']);
							$db->bindValue(":pref_id", $key);
							$db->bindValue(":var", $value);
							$db->execute();
						}
					}
				}
				return $_POST['event_id'];
			}
			else{
				// Set up the PDO query
				$query = "INSERT INTO events(UserID, EventName, MetaLink) VALUES (:userid, :eventname, :meta)";
				$db = $this->database->prepare($query);

				// Get the values for the query, eventname comes from the dynamic preferences in the wizard under the key '9' and user_id comes from the session library.
				$db->bindValue(":eventname", $_POST['eventname']);
				$db->bindValue(":userid", $this->session->userdata('user_id'));
				$db->bindValue(":meta", strtolower($this->user->randomPassword(10)));
				$db->execute();

				// Get the last inserted ID
				$inserted_id = $this->database->lastInsertId();
				// Start the loop for each of the preferences loaded in the wizard/form.
				foreach($_POST as $key => $value){
					if($value != ''){
						// Insert every preferences into the datavase
						$query = "INSERT INTO eventspreferences(EventID, Field, Value) VALUES (:id, :pref_id, :var)";
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $inserted_id);
						$db->bindValue(":pref_id", $key);
						$db->bindValue(":var", $value);
						$db->execute();
					}
				}
				// Return the inserted ID for the redirect through Javascript on the wizard.
				return $inserted_id;
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function registerCustomisationVariables(){
		try{
			if(isset($_FILES['upload-header']) && $_FILES['upload-header'] != ''){

				if ($_FILES["upload-header"]["error"] == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["upload-header"]["tmp_name"];
					$name = explode('.', $_FILES["upload-header"]["name"]);
					$_POST['header_photo'] = $this->user->randomPassword(8).'.' . end($name);
					move_uploaded_file($tmp_name, "./uploads/cover_photos/_src/".$_POST['header_photo']);


					// *** Include the class
					$this->load->model('promoter/resize');

					$this->resize->openImage("./uploads/cover_photos/_src/".$_POST['header_photo']);
					if($this->resize->width > 720 || $this->resize->height > 250){
						// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
						$this->resize->resizeImage(720, 250, 'crop');
						$this->resize->saveImage("./uploads/cover_photos/_cropped/".$_POST['header_photo'], 75);

						$resized = true;
					}
					else{
						$resized = false;
					}
				}
			}
			// Start the loop for each of the customisation loaded in the wizard/form.
			foreach($_POST as $key => $value){
				if($key != 'event_id' && $key != 'fb_header' && $value != ''){
					$query = "SELECT * FROM eventscustomisationpreferences WHERE EventID = :id AND Field = :pref_id";
					$db = $this->database->prepare($query);
					$db->bindValue(":id", $_POST['event_id']);
					$db->bindValue(":pref_id", $key);
					$db->execute();

					if($db->rowCount() < 1){
						// Insert every preferences into the datavase
						$query = "INSERT INTO eventscustomisationpreferences(EventID, Field, Value) VALUES (:id, :pref_id, :var)";
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $_POST['event_id']);
						$db->bindValue(":pref_id", $key);
						$db->bindValue(":var", $value);
						$db->execute();
					}
					else{
						$query = "UPDATE eventscustomisationpreferences SET Value = :value WHERE EventID = :id AND Field = :pref_id";
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $_POST['event_id']);
						$db->bindValue(":pref_id", $key);
						$db->bindValue(":value", $value);
						$db->execute();
					}
				}
			}
			
			return array('result' => true, 'resized' => (isset($resized) ? $resized : ''));
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function registerNewTickettypes($event_id){
		// Set up the PDO query
		// 
		// Insert new tickets
		if(isset($_POST['tickets']['tickets-name'][0])){
			foreach ($_POST['tickets']['tickets-name'][0] as $key => $value) {
				if($event_id == $_POST['new-tickets']){
					$query = "INSERT INTO etickets(EventID, date) VALUES (:event_id, NOW())";
					$db = $this->database->prepare($query);
					$db->bindValue(":event_id", $event_id);
					$db->execute();
					// Get the last inserted ID
					$inserted_id = $this->database->lastInsertId();

					foreach($_POST['tickets'] as $preference => $input){
						if($value != ''){
							// Insert every preferences into the datavase
							$query = "INSERT INTO  eticketspreferences(EticketID, Field, Value) VALUES (:id, :pref_id, :var)";
							$db = $this->database->prepare($query);
							$db->bindValue(":id", $inserted_id);
							$db->bindValue(":pref_id", $preference);
							$db->bindValue(":var", $input[0][$key]);
							$db->execute();
						}
					}
				}
			}
		}
		// Update old tickets
		foreach ($_POST['tickets']['tickets-name'] as $key => $value) {
			if($event_id == $_POST['new-tickets'] && $key != 0){

				foreach($_POST['tickets'] as $preference => $input){
					if($value != ''){
						$query = "SELECT * FROM eticketspreferences WHERE EticketID = :id AND Field = :field";
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $key);
						$db->bindValue(":field", $preference);
						$db->execute();

						if($db->rowCount() > 0){
							// Update every preferences into the datavase
							$query = "UPDATE eticketspreferences SET Value = :value WHERE EticketID = :id AND Field = :field";
							$db = $this->database->prepare($query);
							$db->bindValue(":id", $key);
							$db->bindValue(":field", $preference);
							$db->bindValue(":value", $input[$key]);
							$db->execute();
						}
						else if($db->rowCount() > 0 && !isset($input[$key])){
							// Delete every preferences into the datavase
							$query = "DELETE FROM eticketspreferences WHERE EticketID = :id AND Field = :field";
							$db = $this->database->prepare($query);
							$db->bindValue(":id", $key);
							$db->bindValue(":field", $preference);
							$db->execute();
						}
						else if(isset($input[$key])){
							// Insert every preferences into the datavase
							$query = "INSERT INTO eticketspreferences(EticketID, Field, Value) VALUES (:id, :field, :value)";
							$db = $this->database->prepare($query);
							$db->bindValue(":id", $key);
							$db->bindValue(":field", $preference);
							$db->bindValue(":value", $input[$key]);
							$db->execute();
						}
					}
				}
			}
			
		}
		return true;
	}
	/*
		Get all types for events
	 */
	public function getTypes(){
		$query = "SELECT * FROM eventtypes ORDER BY Type ASC";
		$db = $this->database->prepare($query);
		$db->execute();
		return $db->fetchAll(PDO::FETCH_ASSOC);
	}
	/*
		Get all presets for events from a certain user
	 */
	public function load_presets($user_id){
		$query = "SELECT * FROM customisation_presets WHERE UserID = :user_id OR UserID = '0'";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $user_id);
		$db->execute();
		$presets = $db->fetchAll(PDO::FETCH_ASSOC);
		foreach($presets as $key => $value){
			$query = "SELECT * FROM customisation_presetspreferences WHERE PresetID = :preset_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":preset_id", $value['ID']);
			$db->execute();
			while($prefs = $db->fetch(PDO::FETCH_ASSOC)){
				$presets[$key]['preferences'][$prefs['Field']] = $prefs;
			}
		}
		return $presets;
	}
}
?>