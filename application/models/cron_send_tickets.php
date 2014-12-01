<?php 

class Cron_send_tickets extends CI_Model
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
	public function getPaidUnsentOrders(){
		$data = array();

		$query = "SELECT * FROM orders WHERE Status = :status ORDER BY OrderID ASC";
		$db = $this->database->prepare($query);
		$db->bindValue(":status", '2');
		$db->execute();
		$orders = $db->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($orders as $key => $value) {
			$data[$value['OrderID']] = $value;
			$data[$value['OrderID']]['user'] = $this->user->getUserInfoById($value['UserID']);
			$data[$value['OrderID']]['preferences'] = $this->buyer_orders->getOrderPreferencesByOrderID($value['OrderID']);
			$data[$value['OrderID']]['userpreferences'] = $this->buyer_orders->getUserOrderPreferencesByOrderID($value['OrderID']);
			$data[$value['OrderID']]['tickets'] = $this->buyer_tickets->getTicketsByOrderID($value['OrderID']);

			foreach ($data[$value['OrderID']]['tickets'] as $keytwo => $valuetwo) {
				$data[$value['OrderID']]['tickets'][$keytwo]['ticketnumbers'] = $this->getTicketNumbers($valuetwo);

				$data[$value['OrderID']]['tickets'][$keytwo]['eventdata'] = $this->buyer_events->getEventDataByID($valuetwo['EventID']);
			}
		}
		return $data;
	}
	/*
	Get ticketnumbers per ticket
	 */
	public function getTicketNumbers($data){
		$query = "SELECT * FROM ticketnumbers WHERE EticketBuyerID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $data['ID']);
		$db->execute();


		if($db->rowcount() < $data['Quantity']){
			$amount = ($data['Quantity'] - $db->rowCount());
			for ($i=0; $i < $amount; $i++) { 
				$queryInsert = "INSERT INTO ticketnumbers(EticketBuyerID, Scanned_in) VALUES(:id, :scanned)";
				$stmt = $this->db->conn_id->prepare($queryInsert);
				$stmt->bindValue(':id', $data['ID'], PDO::PARAM_STR);
				$stmt->bindValue(':scanned', '0', PDO::PARAM_STR);
				$stmt->execute();
			}
		}
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $data['ID']);
		$db->execute();
		return $db->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>