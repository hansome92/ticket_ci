<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sysadmin extends CI_Controller {
	/************************************
		Redirect modules from here
	************************************/
	public function _remap($method, $params)
	{
		// Standard variables for header
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		$data['sys_base'] = $this->config->item('sysadmin_url');
		if($data['logged_in'] === true){
			// Laad de header in
			$this->load->view('sysadmin/header', $data);
			$this->load->view('sysadmin/menu', $data);
			if(method_exists($this, $method)){
				$this->$method($params, $data);
			}
		}
		else{
			$this->login();
		}
	}
	/************************************************
		Login function for the system administrator
	************************************************/
	public function login(){
		$data = array();

		if(isset($_POST['username']) && $_POST['username'] != '' && $_POST['password'] != ''){
			$result = $this->user->doLogin($_POST['username'], $_POST['password']);
			if($result === true){
				header("Location:".$this->config->item('sysadmin_url'));
			}
			else{
				echo $result;
				$data['error'] = 'De ingevoerde gegevens kloppen niet.';
				$data['used_username'] = $_POST['username'];
			}
		}
		// Laad de header in
		$this->load->view('sysadmin/login', $data);
	}
	/***********************************
			Managen van vertalingen
	***********************************/
	public function translation($params=null, $data=null){
		$data = array();
		$this->load->model('sysadmin/sysadmin_translation');
		if(!isset($params[0])){
			$data['languages'] = $this->sysadmin_translation->getLanguages();
		}
		else{
			$data['langid'] = $params[0];
			if(!empty($_POST)){
				$this->sysadmin_translation->saveTranslation($data['langid']);
				header('Location: '.$this->config->item('sysadmin_url').'translation/'.$data['langid']);
			}
			$data['language'] = $this->sysadmin_translation->getTotalLanguage($params[0]);
		}
		$this->load->view('sysadmin/translation', $data);
	}
	/***********************************
			Managen van sponsorships
	***********************************/
	public function sponsorships($params=null, $data=null){
		$this->load->model('sysadmin/sponsorships');
		if( isset($_POST['title']) && $_POST['title']){
			$this->sponsorships->registerNewSponsorship();
			header('Location: '.$this->config->item('sysadmin_url').'sponsorships');
		}
		$data = array();
		$data['sponsorships'] = $this->sponsorships->getsponsorships();
		$this->load->view('sysadmin/sponsorships', $data);
	}
	/*
		Managing of eventtypes and categories
	 */
	public function categories($params=null, $data=null){
		$this->load->model('sysadmin/events');
		if( isset($_POST['type']) && $_POST['type']){
			$this->events->registerNewEventtype( (isset($params[0]) ? $params[0] : 0) );
			//echo '<xmp>'; print_r($_POST);echo '</xmp>';
			header('Location: '.$this->config->item('sysadmin_url').'categories'.(isset($params[0]) ? '/'.$params[0] : ''));
		}
		$data = array();
		$data['sys_base'] = $this->config->item('sysadmin_url');
		if(isset($params[0])){
			$data['main_id'] = $params[0];
		}
		$data['eventstypes'] = $this->events->getEventtypes( (isset($params[0]) ? $params[0] : 0) );
		$this->load->view('sysadmin/eventstypes', $data);
	}
	/*
		Managing of wizards
	 */
	public function wizards($params=null, $data=null){
		$this->load->model('sysadmin/wizards');
		if( isset($_GET['wizard']) && $_GET['wizard'] != '' && isset($_GET['wizardstep']) && $_GET['wizardstep'] != ''){

			$data['wizard'] = $_GET['wizard'];
			$data['wizardstep'] = $_GET['wizardstep'];
			if( isset($_POST['descript']) && $_POST['descript'] != '' && isset($_REQUEST['wizard']) && $_REQUEST['wizard'] != '' && isset($_REQUEST['wizardstep']) && $_REQUEST['wizardstep'] != ''){
				if(isset($_POST['edit'])){
					$result = $this->wizards->editWizardSteppreference( $_REQUEST['wizardstep'] );
				}
				else{
					$result = $this->wizards->registerNewWizardSteppreference( $_REQUEST['wizardstep'] );
				}
				header('Location: '.$this->config->item('sysadmin_url').'wizards/?wizard='.$_REQUEST['wizard'].'&wizardstep='.$_REQUEST['wizardstep']);
			}
			if(isset($_GET['edit'])){
				$data['edit'] = $_GET['edit'];
			}
			$data['validators'] = $this->wizards->getValidators();
			$data['wizardsteps'] = $this->wizards->getWizardstepspreferences($_GET['wizardstep']);
			$this->load->view('sysadmin/wizardstepsdefaultpreferences', $data);
		}
		elseif( isset($_GET['wizard']) && $_GET['wizard'] != ''){
			$data['wizard'] = $_GET['wizard'];
			if( isset($_POST['name']) && $_POST['name'] != '' && isset($_REQUEST['wizard']) && $_REQUEST['wizard'] != ''){
				$result = $this->wizards->registerNewWizardStep( $_REQUEST['wizard'] );
				header('Location: '.$this->config->item('sysadmin_url').'wizards/?wizard='.$_GET['wizard']);
			}
			$data['wizardsteps'] = $this->wizards->getWizardsteps($_GET['wizard']);
			$this->load->view('sysadmin/wizardsteps', $data);
		}
		else{
			if( isset($_POST['name']) && $_POST['name'] != ''){
				$result = $this->wizards->registerNewWizard( (isset($params[0]) ? $params[0] : 0) );
				header('Location: '.$this->config->item('sysadmin_url').'wizards/?wizard='.$result);
			}
			$data['wizards'] = $this->wizards->getWizards();
			$this->load->view('sysadmin/wizards', $data);
		}
	}
}