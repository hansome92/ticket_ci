<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	public function index()
	{
	}
	/************************************
				Scan ticket
	************************************/
	public function scanticket(){
		$errorStrings = array(
			0 => 'Code was not defined in the request.',
			1 => 'Ticket code is not defined in the database.',
			2 => 'Ticket is already scanned in.');
		$this->load->model('promoter/app_api');
		$result = $this->app_api->checkTicket();
		//print_r($_POST);
		//
		if($result === true && !is_numeric($result)){
			echo json_encode(array('result' => true));
		}
		else{
			echo json_encode(array('result' => false, 'error' => $result, 'errorstring' => (isset($errorStrings[$result]) ? $errorStrings[$result] : 'Error not recognised.')));
		}
	}
	/*
		Delete ticket from an order
	 */
	public function deleteticketfromorder(){
		$ticket_id = $_REQUEST['ticketid'];
		$result = $this->buyer_tickets->removeTicketFromOrder($ticket_id, $this->session->userdata('user_id'));
		if($result === true){
			echo json_encode(array('result' => true));
		}
		else{
			echo json_encode(array('result' => false, 'error' => $result));
		}
		
	}
}