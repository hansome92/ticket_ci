<?php 

class Settings extends CI_Model
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
	public function getAllSettings(){
		try{
			$query = "SELECT * FROM userpreferences WHERE UserID=:user_id";
			$db = $this->database->prepare($query);
			$db->bindValue(":user_id", $this->session->userdata('user_id'));
			$db->execute();
				
			
			// Loop through the steps and get associated fields
			while ($row = $db->fetch(PDO::FETCH_ASSOC)){
				$settings[$row['Field']] = $row;
			}
			return $settings;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function saveSettings(){
		try{
			// Foreach settingpage we update the settings, or insert them if they are unknown until now.
			if(isset($_POST['preferences']) && !empty($_POST['preferences'])){
				foreach ($_POST['preferences'] as $key => $value) {
					foreach ($value as $preferenceKey => $preferenceValue) {
						$query = "SELECT * FROM userpreferences WHERE UserID = :user_id AND Field = :field";
						$db = $this->database->prepare($query);
						$db->bindValue(":user_id", $this->session->userdata('user_id'));
						$db->bindValue(":field", $preferenceKey);
						$db->execute();

						if($db->rowCount() > 0){
							$query = "UPDATE userpreferences SET Value = :value WHERE UserID = :id AND Field = :field";
						}
						else{
							$query = "INSERT INTO userpreferences(UserID, Field, Value) VALUES (:id, :field, :value)";
						}
						$db = $this->database->prepare($query);
						$db->bindValue(":id", $this->session->userdata('user_id'));
						$db->bindValue(":value", $preferenceValue);
						$db->bindValue(":field", $preferenceKey);
						$db->execute();
					}
				}
			}
			/*
			 	Check if there are postes files
			 */
			if(isset($_FILES['preferences'])){
				foreach ($_FILES['preferences']['name'] as $key => $value) {
					$tmp_name = $_FILES["preferences"]["tmp_name"][$key];
					$old_name = $_FILES["preferences"]["name"][$key];
					$name = explode('.', $_FILES["preferences"]["name"][$key]);

					$elementName = $this->user->randomPassword(12).'.' . end($name);
					move_uploaded_file($tmp_name, "./uploads/user_uploads/".$elementName);

					$query = "SELECT * FROM userpreferences WHERE UserID = :user_id AND Field = :field";
					$db = $this->database->prepare($query);
					$db->bindValue(":user_id", $this->session->userdata('user_id'));
					$db->bindValue(":field", $key);
					$db->execute();

					if($db->rowCount() > 0){
						$query = "UPDATE userpreferences SET Value = :value, FileName = :filename WHERE UserID = :id AND Field = :field";
					}
					else{
						$query = "INSERT INTO userpreferences(UserID, Field, Value, FileName) VALUES (:id, :field, :value, :filename)";
					}
					$db = $this->database->prepare($query);
					$db->bindValue(":id", $this->session->userdata('user_id'));
					$db->bindValue(":filename", $elementName);
					$db->bindValue(":value", $old_name);
					$db->bindValue(":field", $key);
					$db->execute();
				}
			}
			return true;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}
?>