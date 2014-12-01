<?php 

class Wizards extends CI_Model
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
	public function getWizards(){
		try{
			$query = "SELECT * FROM wizards";
			$db = $this->database->prepare($query);
			$db->execute();
				
			$wizards = $db->fetchAll(PDO::FETCH_ASSOC);
			return $wizards;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function registerNewWizard(){
		try{
			$query = "INSERT INTO wizards(Name) VALUES (:name)";
			$db = $this->database->prepare($query);
			$db->bindValue(":name", $_POST['name']);
			$db->execute();
				
			$result = $this->database->lastInsertId();
			return $result;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	/*
		To get all the wizardsteps
	*/
	public function getWizardsteps($wizard_id){
		try{
			$query = "SELECT * FROM wizardsteps WHERE WizardID = :wizard";
			$db = $this->database->prepare($query);
			$db->bindValue(":wizard", $wizard_id);
			$db->execute();
				
			$wizards = $db->fetchAll(PDO::FETCH_ASSOC);
			return $wizards;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function registerNewWizardStep($wizard_id){
		try{
			$query = "INSERT INTO wizardsteps(WizardID, Name, `Order`) VALUES (:wizard, :name, '0')";
			$db = $this->database->prepare($query);
			$db->bindValue(":name", $_POST['name']);
			$db->bindValue(":wizard", $wizard_id);
			$db->execute();
				
			$result = $this->database->lastInsertId();
			return $result;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

	/*
		To get all the wizardstepspreferences
	*/
	public function getWizardstepspreferences($wizardstep_id){
		try{
			$query = "SELECT * FROM wizardstepsdefaultpreferences WHERE WizardStepID = :wizardstepid";
			$db = $this->database->prepare($query);
			$db->bindValue(":wizardstepid", $wizardstep_id);
			$db->execute();
				
			$wizards = $db->fetchAll(PDO::FETCH_ASSOC);
			return $wizards;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function registerNewWizardSteppreference($wizardstep_id){
		try{
			$query = "INSERT INTO wizardstepsdefaultpreferences(WizardStepID, Descript, typeOfPreference, SystemPreference, HelpContent) VALUES (:wizardstepid, :descript, :typeorpref, :systempref, :help_content)";
			$db = $this->database->prepare($query);
			$db->bindValue(":wizardstepid", $wizardstep_id);
			$db->bindValue(":descript", $_POST['descript']);
			$db->bindValue(":typeorpref", $_POST['validator']);
			$db->bindValue(":systempref", (isset($_POST['required']) ? $_POST['required'] : ''));
			$db->bindValue(":help_content", $_POST['help_content']);
			$db->execute();
				
			$result = $this->database->lastInsertId();
			return $result;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function editWizardSteppreference(){
		try{
			$query = "UPDATE wizardstepsdefaultpreferences SET Descript = :descript, typeOfPreference = :typeorpref, SystemPreference = :systempref, HelpContent = :help_content WHERE ID = :id";
			$db = $this->database->prepare($query);
			$db->bindValue(":descript", $_POST['descript']);
			$db->bindValue(":typeorpref", $_POST['validator']);
			$db->bindValue(":systempref", $_POST['required']);
			$db->bindValue(":help_content", $_POST['help_content']);
			$db->bindValue(":id", $_POST['preference_id']);
			$db->execute();
				
			$result = $this->database->lastInsertId();
			return $result;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	public function getValidators(){
		try{
			$query = "SELECT * FROM validators";
			$db = $this->database->prepare($query);
			$db->execute();
				
			$validators = $db->fetchAll(PDO::FETCH_ASSOC);
			return $validators;
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	
	
}
?>