<?php 

class Statistics extends CI_Model
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
	public function frontpageStatistics($days=7){
		try{
			$totaltickets = 0;
			$statistics = array();
			switch ($days) {
				case 90:
					# code...
					break;
				case 30:
					# code...
					break;
				case 7:
					for ($i=0; $i < 7; $i++) { 
						$statistics['dailystats'][$i][0] = date('D', (time()- ($i*24*60*60) ));
						$statistics['dailystats'][$i][1] = 0;
					}
					break;
				default:
					# code...
					break;
			}
			/*
			First ,lets get all the events per user
			 */
			$query = "SELECT * FROM events WHERE UserID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $this->session->userdata('user_id'));
			$db->execute();

			$events = $db->fetchAll(PDO::FETCH_ASSOC);

			/*
				Then get all the tickets per event
			 */
			foreach($events as $key => $event){
				$query = "SELECT * FROM eticketbuyer e LEFT JOIN eticketbuyerpreferences ep ON ep.EticketBuyerID = e.ID WHERE e.EventID = :id ".(is_numeric($days) ? "AND Field = '2' AND Value > '".(time()- ($days*24*60*60) )."'" : '');
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $event['EventID']);
				$db->execute();

				$result = $db->fetchAll(PDO::FETCH_ASSOC);
				/*
					If we get results then put them in the right places
				 */
				switch ($days) {
					case 90:
						# code...
						break;
					case 30:
						# code...
						break;
					
					case 7:
						foreach ($result as $key => $value) {
							foreach ($statistics['dailystats'] as $keyDay => $valueDay) {
								if($valueDay[0] == date('D', $value['Value'])){
									$statistics['dailystats'][$keyDay][1] += $value['Quantity'];
									$totaltickets += $value['Quantity'];
								}
							}
						}
						break;
					
					default:
						# code...
						break;
				}
			}
			$statistics['totalsoldperweek'] = $totaltickets;
			return $statistics;

		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	
}
?>