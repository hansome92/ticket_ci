<?php 
class Pages extends CI_Model
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
	public function load_page($pageName){
		$query = "SELECT * FROM infopages WHERE PageName = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $pageName);
		$db->execute();
		$page = $db->fetch(PDO::FETCH_ASSOC);

		// Loop through the steps and get associated fields
		$query = "SELECT * FROM infopagespreferences ep WHERE ep.PageID=:id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $page['PageID']);
		$db->execute();
		
		if ($db->rowCount() > 0){
			while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
				$page['preferences'][$row['Field']] = $row;
			}
		}
		return $page;
	}
}
?> 