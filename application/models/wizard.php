<?php 

class Wizard extends CI_Model
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

	
	public function set_current_wizard($wizard_id) 
	{
		
		// If parameter is numeric
		if (is_numeric($wizard_id)) 
		{
			
			// Check if wizard exists
			$query = "SELECT * FROM wizards WHERE id=:id";
			$db = $this->database->prepare($query);
			$db->bindValue(":id", $wizard_id, PDO::PARAM_INT);
			$db->execute();
			
			if ($db->rowCount() == 1)
			{
				$this->wizard = $wizard_id;
				return true;
			}
			
			return false;
		}
		
		return false;
	}
	
	public function load_fields()
	{
		// check if property wizard has been defined
		if (!empty($this->wizard))
		{
			
			$query = "SELECT * FROM wizardsteps WHERE WizardID=:wizard_id ORDER BY `Order` ASC";
			$db = $this->database->prepare($query);
			$db->bindValue(":wizard_id", $this->wizard);
			$db->execute();
			
			$wizard_steps = $db->fetchAll(PDO::FETCH_ASSOC);
			
			// Loop through the steps and get associated fields
			foreach ($wizard_steps as $key => $step) 
			{
				$query = "SELECT w.*, v.ID AS ValidatorID, v.Naam, v.Code FROM wizardstepsdefaultpreferences w LEFT JOIN validators v ON w.typeOfPreference = v.ID WHERE w.WizardStepID=:step_id";
				$db = $this->database->prepare($query);
				$db->bindValue(":step_id", $step['ID']);
				$db->execute();
				
				if ($db->rowCount() > 0)
				{
					$wizard_steps[$key]['fields'] = $db->fetchAll(PDO::FETCH_ASSOC);
				}
				
			}
			
			return $wizard_steps;
			
		}
		
		return false;
	}
	
}

?>