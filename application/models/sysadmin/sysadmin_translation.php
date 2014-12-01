<?php 

class Sysadmin_translation extends CI_Model
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
	public function getTotalLanguage($id){
		$query = "SELECT * FROM langcodes WHERE ID = :id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);

		/*
			Get all the languagestrings
		 */
		$query = "SELECT * FROM langstrings";
		$db = $this->database->prepare($query);
		$db->execute();
		while ($row = $db->fetch(PDO::FETCH_ASSOC)) {
			$result['translates'][$row['ID']] = $row;
			$result['translates'][$row['ID']]['translated'] = $this->getTranslatedString($row['ID'], $id);
		}
		return $result;
	}
	public function getTranslatedString($id, $langId){
		$query = "SELECT * FROM langstringstranslated WHERE TranslationOf = :id AND LangCode = :lang_id";
		$db = $this->database->prepare($query);
		$db->bindValue(":id", $id);
		$db->bindValue(":lang_id", $langId);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);
		return $result['String'];
	}
	public function saveTranslation($langID){
		try {
			foreach ($_POST['stringtranslations'] as $key => $value) {
				$query = "UPDATE langstrings SET improvedString = :value WHERE ID = :id";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $key);
				$db->bindValue(":value", $value['original']);
				$db->execute();

				/*
					Check if row exists
				 */
				$query = "SELECT * FROM langstringstranslated WHERE TranslationOf = :id AND LangCode = :langid";
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $key);
				$db->bindValue(":langid", $langID);
				$db->execute();
				if($db->rowCount() > 0){
					$query = "UPDATE langstringstranslated SET String = :value WHERE TranslationOf = :id AND LangCode = :langid";
				}
				else{
					$query = "INSERT INTO langstringstranslated(String, TranslationOf, LangCode) VALUES (:value, :id, :langid)";
				}
				$db = $this->database->prepare($query);
				$db->bindValue(":id", $key);
				$db->bindValue(":langid", $langID);
				$db->bindValue(":value", $value['translated']);
				$db->execute();
			}
		} catch (Exception $e) {
			
		}
	}
	public function getLanguages(){
		$query = "SELECT * FROM langcodes";
		$db = $this->database->prepare($query);
		$db->execute();
		$result = $db->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}
?>