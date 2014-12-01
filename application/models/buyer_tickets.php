<?php 
class Buyer_tickets extends CI_Model
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
	public function registerNewTicket($event_id){
		// Set up the PDO query
		$query = "INSERT INTO etickets(EventID, date) VALUES (:event_id, NOW())";
		$db = $this->database->prepare($query);

		// Get the values for the query, eventname comes from the dynamic preferences in the wizard under the key '9' and user_id comes from the session library.
		$db->bindValue(":event_id", $event_id);
		$db->execute();

		// Get the last inserted ID
		$inserted_id = $this->database->lastInsertId();

		// Start the loop for each of the preferences loaded in the wizard/form.
		foreach($_POST['preferences'] as $key => $value){
			if($value != ''){
				// Insert every preferences into the database
				$query = "INSERT INTO eticketspreferences(EticketID, Field, Value) VALUES (:id, :pref_id, :var)";
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
	public function saveDataPerTicket(){
		try {
			$result = $this->buyer_orders->getOrderById($_POST['orderid']);
			if(empty($result)){
				return 1;
			}
			$query = "SELECT * FROM eticketbuyer WHERE OrderID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $_POST['orderid']);
			$db->execute();

			while($row = $db->fetch(PDO::FETCH_ASSOC)){
				$queryCount = "SELECT COUNT(*) AS total FROM ticketnumbers WHERE EticketBuyerID = :id";
				$dbCount = $this->database->prepare($queryCount);
				$dbCount->bindValue(":id", $row['ID']);
				$dbCount->execute();
				$dbCount = $dbCount->fetch(PDO::FETCH_ASSOC);
				for($i = 0; $i < $row['Quantity']; $i++){
					if($dbCount['total'] < $row['Quantity']){
						$query = "INSERT INTO ticketnumbers(EticketBuyerID, BuyerName, BuyerEmail, BuyerGender) VALUES (:id, :bname, :bemail, :gender)";
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $row['ID']);
						$db->bindValue(":bname", (isset($_POST['ticketdata'][$row['ID']][$i]['naam']) ? $_POST['ticketdata'][$row['ID']][$i]['naam'] : ''));
						$db->bindValue(":bemail", (isset($_POST['ticketdata'][$row['ID']][$i]['e-mail']) ? $_POST['ticketdata'][$row['ID']][$i]['e-mail'] : ''));
						$db->bindValue(":gender", (isset($_POST['ticketdata'][$row['ID']][$i]['gender']) ? $_POST['ticketdata'][$row['ID']][$i]['gender'] : ''));
						$db->execute();
						$dbCount['total']++;
					}
				}
			}
			$this->session->set_userdata(array('step_two_completed' => true));
		} catch (Exception $e) {}
	}
	public function getTicketInformation($orderid){
		$tickets = $this->getTicketsByOrderID($orderid);
		if(is_array($tickets) && count($tickets) > 0){
			foreach($tickets as $key => $value){
				$amount = $value;
				// Query to get all the events from a certain user that's logged in.
				$query = "SELECT * FROM etickets WHERE ID = :id";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $key);
				$db->execute();
				$tickets[$key] = $db->fetch(PDO::FETCH_ASSOC);

				// Loop through the steps and get associated fields
				$query = "SELECT * FROM eticketspreferences ep WHERE ep.EticketID=:id";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $tickets[$key]['ID']);
				$db->execute();
				
				if ($db->rowCount() > 0){
					while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
						$tickets[$key]['preferences'][$row['Field']] = $row;
					}
				}
				$tickets[$key] = $amount;
			}
		}
		return $tickets;
	}
	public function getTicketsByOrderID($id){
		// Query to get all the events from a certain user that's logged in.
		$query = "SELECT * FROM eticketbuyer WHERE OrderID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		$tickets = $db->fetchAll(PDO::FETCH_ASSOC);
		// Loop through the steps and get associated fields
		foreach ($tickets as $key => $ticket) 
		{
			$query = "SELECT * FROM eticketbuyerpreferences WHERE EticketBuyerID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticket['ID']);
			$db->execute();
			if ($db->rowCount() > 0)
			{
				while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
					$tickets[$key]['buyerpreferences'][$row['Field']] = $row;
				}
			}

			$query = "SELECT * FROM eticketspreferences ep WHERE ep.EticketID=:id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticket['EticketID']);
			$db->execute();
			
			if ($db->rowCount() > 0){
				while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
					$tickets[$key]['preferences'][$row['Field']] = $row;
				}
			}
		}
		return $tickets;
	}
	/*
		For seeing the ticket after ordering
	 */
	public function getTicketByTicketnumber($method, $params=null){
		try {
			$query = "SELECT *, t.ID AS ticketnumber FROM ticketnumbers t LEFT JOIN eticketbuyer e ON e.ID = t.EticketBuyerID WHERE t.ID = :id AND e.OrderID = :order_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $params[1]);
			$db->bindValue(":order_id", $method);
			$db->execute();
			if($db->rowCount() < 1){	
				return 1;
			}
			else{
				$result = $db->fetch(PDO::FETCH_ASSOC);
				$order = $this->buyer_orders->getOrderById($result['OrderID']);
				$result['ticket'] = $this->getTicketInformationByID($result['EticketID']);
				$result['eventdata'] = $this->buyer_events->getEventDataByID($result['EventID']);


			}
			return array('ticket' => $result, 'order' => $order);
		} catch (Exception $e) {
			
		}
	}
	public function getTicketInformationByID($ticket_id){
		// Query to get all the events from a certain user that's logged in.
		$query = "SELECT * FROM etickets WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $ticket_id);
		$db->execute();
		$ticket = $db->fetch(PDO::FETCH_ASSOC);

		// Loop through the steps and get associated fields
		$query = "SELECT * FROM eticketspreferences ep WHERE ep.EticketID=:id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $ticket['ID']);
		$db->execute();
		
		if ($db->rowCount() > 0){
			while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
				$ticket['preferences'][$row['Field']] = $row;
			}
		}
		return $ticket;
	}
	public function saveLog($post){
		$query = "INSERT INTO adyen_log(`Log`, `Date`) VALUES (:log, NOW())";
		$db = $this->database->prepare($query);
		$db->bindValue(":log", json_encode($post));
		$db->execute();
	}
	public function reserveTickets($meta=''){
		/***************************************************************
				First delete orderless tickets from the database   		
		***************************************************************/
		$query = "SELECT * FROM eticketbuyer WHERE OrderID = :id AND UserID = :user_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", '0');
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();

		while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
			$query = "DELETE FROM eticketbuyerpreferences WHERE EticketBuyerID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $row['ID']);
			$db->execute();
		}
		/*
			And finally delete the orderless tickets
		 */
		$query = "DELETE FROM eticketbuyer WHERE OrderID = :id AND UserID = :user_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", '0');
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();
		/*
			Now for the reservations
		 */
		foreach ($this->session->userdata('tickets') as $key => $value) {
			if($value > 0){
				$query = "INSERT INTO eticketbuyer(`EticketID`, `EventID`, `UserID`, `Quantity`) VALUES (:ticket_id, :event_id, :user_id, :quantity)";
				$db = $this->database->prepare($query);
				$db->bindValue(":ticket_id", $key);
				$db->bindValue(":event_id", $this->buyer_events->getEventIDByMeta($meta));
				$db->bindValue(":user_id", $this->session->userdata('user_id'));
				$db->bindValue(":quantity", $value);
				$db->execute();
				$inserted_id = $this->database->lastInsertId();

				/*
					Add preferences per ticket
					First the ensurance
				 */
				if($this->session->userdata('ensurance') != false && $this->session->userdata('ensurance') == '1'){
					$query = "INSERT INTO eticketbuyerpreferences(EticketBuyerID, Field, Value) VALUES (:id, :field, :value)";
					$db = $this->database->prepare($query);
					$db->bindValue(":id", $inserted_id);
					$db->bindValue(":field", '1');
					$db->bindValue(":value", $this->session->userdata('ensurance'));
					$db->execute();
				}
				/*
					Add time that ticket has been bought
				 */
				$query = "INSERT INTO eticketbuyerpreferences(EticketBuyerID, Field, Value) VALUES (:id, :field, :value)";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $inserted_id);
				$db->bindValue(":field", '2');
				$db->bindValue(":value", time());
				$db->execute();

				if(!isset($inserted_id)){
					$row = $db->fetch(PDO::FETCH_ASSOC);
					$inserted_id = $row['ID'];
				}
			}
		}
		$this->session->unset_userdata('tickets');
		$this->session->unset_userdata('ensurance');
		
	}
	public function removeTicketFromOrder($ticket_id, $user_id){
		$query = "SELECT * FROM eticketbuyer WHERE ID = :id AND UserID = :user_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $ticket_id);
		$db->bindValue(":user_id", $user_id);
		$db->execute();
		if($db->rowCount() > 0){
			$query = "DELETE FROM eticketbuyer WHERE ID = :id AND UserID = :user_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticket_id);
			$db->bindValue(":user_id", $user_id);
			$db->execute();

			$query = "DELETE FROM eticketbuyerpreferences WHERE EticketBuyerID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $ticket_id);
			$db->execute();

			return true;
		}
		else{
			return 'This ticket does not belong to the user.';
		}
	}
}
?> 