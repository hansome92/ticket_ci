<?php 
class Buyer_orders extends CI_Model
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
	/************************************
			  Create a new order
	************************************/
	public function getOrderID(){
		// Check if there is an open order from this user
		$query = "SELECT * FROM orders WHERE UserID = :user_id AND status = :status";
		$db = $this->database->prepare($query);
		$db->bindValue(":status", '1');
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();

		if($db->rowCount() == 0){ // If there is no open order, make a new one
			$orderNumberQuery = "SELECT * FROM orders ORDER BY OrderNumber DESC";
			$db = $this->database->prepare($orderNumberQuery);
			$db->execute();
			$row = $db->fetch(PDO::FETCH_ASSOC);
			$newOrderNumber = ($row['OrderNumber']+1);

			$query = "INSERT INTO orders(OrderNumber, UserID, CreationDate, Status) VALUES (:ordernumber, :user_id, NOW(), :status)";
			$db = $this->database->prepare($query);
			$db->bindValue(":ordernumber", $newOrderNumber);
			$db->bindValue(":user_id", $this->session->userdata('user_id'));
			$db->bindValue(":status", '1');
			$db->execute();

			// Get last inserted ID
			$inserted_id = $this->database->lastInsertId();

			// Make all open tickets without an ordernumber and from this user part of the new order
			$this->assignOrdernumberToTickets($inserted_id);
			$order_id = $inserted_id;
		}
		else{
			$row = $db->fetch(PDO::FETCH_ASSOC);
			$order_id = $row['OrderID'];
			/**
			 * Set all open tickets to this order ID
			 */
		}
		/*
			Assign loose tickets to this order
		*/
		$query = "UPDATE eticketbuyer SET OrderID = :order_id WHERE OrderID = '0' AND UserID = :user_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":order_id", $order_id);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();
		/**************************************************
				   Call function to create preferences
		**************************************************/
		$result = $this->insertPreferences($order_id);
		if($result === true){
			$this->session->set_userdata(array('step_two_completed' => false, 'order_id' => $order_id));
			return $order_id;
		}
		else{
			return false;
		}
	}
	/*
		Get Order by ID
	*/
	public function getOrderById($id){
		// Query to get all the events from a certain user that's logged in.
		$query = "SELECT * FROM orders WHERE OrderID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		$order = $db->fetch(PDO::FETCH_ASSOC);
		// Loop through the steps and get associated fields
		$order['preferences'] = $this->getOrderPreferencesByOrderID($order['OrderID']);

		$order['eticketbuyer'] = $this->buyer_tickets->getTicketsByOrderID($order['OrderID']);
		
		return $order;
	}
	public function getOrderPreferencesByOrderID($order_id){
		$preferences = array();
		$query = "SELECT * FROM orderuserpreferences WHERE OrderID=:id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $order_id);
		$db->execute();
		
		if ($db->rowCount() > 0)
		{
			while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
				$preferences[$row['Field']] = $row;
			}
			return $preferences;
		}
		return false;
	}
	public function getUserOrderPreferencesByOrderID($order_id){
		$preferences = array();
		$query = "SELECT * FROM orderuserpreferences WHERE OrderID=:id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $order_id);
		$db->execute();
		
		if ($db->rowCount() > 0)
		{
			while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
				$preferences[$row['Field']] = $row;
			}
			return $preferences;
		}
		return false;
	}
	/********************************************
				Insert Order preferences
	********************************************/
	public function insertPreferences($order_id){
		$query = "INSERT INTO orderuserpreferences(OrderID, Field, Value) VALUES (:orderid, :field, :value)";
		$db = $this->database->prepare($query);
		foreach ($_POST as $key => $value) {
			if(!is_array($value)){
				$db->bindValue(":orderid", $order_id);
				$db->bindValue(":field", $key);
				$db->bindValue(":value", $value);
				$db->execute();
			}
		}
		return true;
	}
	/*
		Insert single preference
	 */
	public function insertOrderPreference($order_id, $preference, $value){
		$query = "SELECT * FROM orderuserpreferences WHERE OrderID = :orderid AND Field = :field AND Value = :value";
		$db = $this->database->prepare($query);
		$db->bindValue(":orderid", $order_id);
		$db->bindValue(":field", $preference);
		$db->bindValue(":value", $value);
		$db->execute();
		if($db->rowCount() < 1){
			$query = "INSERT INTO orderuserpreferences(OrderID, Field, Value) VALUES (:orderid, :field, :value)";
			$db = $this->database->prepare($query);
			$db->bindValue(":orderid", $order_id);
			$db->bindValue(":field", $preference);
			$db->bindValue(":value", $value);
			$db->execute();
		}
		return true;
	}
	/********************************************************
			Catch all the pending tickets in this order
	********************************************************/
	public function assignOrdernumberToTickets($id){
		$query = "UPDATE eticketbuyer SET OrderID = :id WHERE OrderID = :oldOrderId AND UserID = :user_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":oldOrderId", '0');
		$db->bindValue(":id", $id);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->execute();

		return true;
	}
	/************************************************************************
		When Adyen returns the user to the site, change the orderstatus
	************************************************************************/
	public function handle_order($order_id='', $status=''){
		/*
			Order statusses:
			1: Open for payment
			2: Paid and authorised
			4: Payment canceled
			99: Void and cleared by function deleteOpenOrders()


			check if order exists
		 */
		$query = "SELECT * FROM orders WHERE OrderID = :merchantReference";
		$db = $this->database->prepare($query);
		$db->bindValue(":merchantReference", $order_id);

		$db->execute();

		if($db->rowCount() == 0){
			return 'not_existing';
		}
		/*
			check if order status is correct
		 */
		$query = "SELECT * FROM orders WHERE status = :status AND OrderID = :merchantReference";
		$db = $this->database->prepare($query);
		$db->bindValue(":status", '1');
		$db->bindValue(":merchantReference", $order_id);

		$db->execute();

		if($db->rowCount() == 0){
			return 'handled_before';
		}
		if($_GET['authResult'] === 'AUTHORISED' || $status == 'OK'){
			$query = "UPDATE orders SET status = :status WHERE OrderID = :merchantReference";
			$db = $this->database->prepare($query);
			$db->bindValue(":status", '2');
			$db->bindValue(":merchantReference", $order_id);

			$db->execute();
			return 'authorised';
		}
		else{
			$query = "UPDATE orders SET status = :status WHERE OrderID = :merchantReference";
			$db = $this->database->prepare($query);
			$db->bindValue(":status", '4');
			$db->bindValue(":merchantReference", $order_id);

			$db->execute();
			return 'canceled';
		}
	}
	public function saveResultToDatabase($order_id, $status){
		$query = "INSERT INTO test(test) VALUES (:test)";
		$db = $this->database->prepare($query);
		$db->bindValue(":test", 'Saveresult to database --- Order ID : '.$order_id.' + Status: '.$status);
		$db->execute();
	}
	/************************************
			   	Get Open order
	************************************/
	public function getOpenOrder(){
		$query = "SELECT * FROM orders WHERE UserID = :user_id AND status = :status ORDER BY ID DESC";
		$db = $this->database->prepare($query);
		$db->bindValue(":user_id", $this->session->userdata('user_id'));
		$db->bindValue(":status", '1');
		$db->execute();
		$row = $db->fetch(PDO::FETCH_ASSOC);
		return $row['OrderID']; 
	}
	/**
	 * clear all order sessiondata
	 */
	public function clearSessionData(){
		$this->session->set_userdata(array('tickets' => false, 'step_one_completed' => false, 'step_two_completed' => false, 'order_id' => false));
		$this->session->unset_userdata(array('tickets' => '', 'step_one_completed' => '', 'step_two_completed' => '', 'order_id' => ''));
	}
	public function getUsedOrderPreferences(){
		$user_id = $this->session->userdata('user_id');

		$query = "SELECT * FROM orders WHERE UserID = :id ORDER BY CreationDate DESC";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $user_id);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);

		$query = "SELECT * FROM orderuserpreferences WHERE OrderID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $result['OrderID']);
		$db->execute();
		while( $row = $db->fetch(PDO::FETCH_ASSOC) ){
			$result['preferences'][$row['Field']] = $row;
		}
		return $result;
	}
	/*
		Function to set an order status
	 */
	public function setOrderStatus($order_id, $status){
		$query = "UPDATE orders SET Status = :value WHERE OrderID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $order_id);
		$db->bindValue(":value", $status);
		$db->execute();
	}
	public function deleteOpenOrders($timeInHours=3){
		$query = "UPDATE orders SET status = :status WHERE status = '1' AND CreationDate < DATE_SUB(NOW(), INTERVAL ".$timeInHours." HOUR)";
		$db = $this->database->prepare($query);
		$db->bindValue(":status", '99');
		$db->execute();
		$result = $db->fetchAll(PDO::FETCH_ASSOC);

		return $result; 
	}
	public function cancelOrder(){
		/*
			First select the order
		 */
		$query = "SELECT * FROM orders WHERE UserID = :id AND Status = :status";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $this->session->userdata('user_id'));
		$db->bindValue(":status", '1');
		$db->execute();
		while($row = $db->fetch(PDO::FETCH_ASSOC)){
			/*
				Then in the while loop select all eticketbuyers 
			 */
			$queryEB = "SELECT * FROM eticketbuyer WHERE UserID = :user_id AND OrderID = :order_id OR UserID = :user_id AND OrderID = :sec_order_id";
			$dbEB = $this->database->prepare($queryEB);
			$dbEB->bindValue(":user_id", $this->session->userdata('user_id'));
			$dbEB->bindValue(":order_id", $row['OrderID']);
			$dbEB->bindValue(":sec_order_id", '0');
			$dbEB->execute();
			while($result = $dbEB->fetch(PDO::FETCH_ASSOC)){
				/*
					Now let's go for the preferences
				 */
				$query = "DELETE FROM eticketbuyerpreferences WHERE EticketBuyerID = :id";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $result['ID']);
				$db->execute();
			}
			/*
				Then delete the eticketbuyer data with no or used orderid that is unpaid
			 */
			$queryEB = "DELETE FROM eticketbuyer WHERE UserID = :user_id AND OrderID = :order_id OR UserID = :user_id AND OrderID = :sec_order_id";
			$dbEB = $this->database->prepare($queryEB);
			$dbEB->bindValue(":user_id", $this->session->userdata('user_id'));
			$dbEB->bindValue(":order_id", $row['OrderID']);
			$dbEB->bindValue(":sec_order_id", '0');
			$dbEB->execute();
		}
		/*
			Finally delete all open order data
		 */
		$query = "DELETE FROM orders WHERE UserID = :id AND Status = :status";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $this->session->userdata('user_id'));
		$db->bindValue(":status", '1');
		$db->execute();
		$this->clearSessionData();
		return true;
	}
}
?> 