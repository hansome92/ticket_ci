<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {
	public function index()
	{
		//$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
	}
	public function _remap($method, $params=null){
		require_once('./phpmailer/class.phpmailer.php');
		$this->$method($params);
	}
	public function sendtickets(){
		$this->load->model('cron_send_tickets');
		$this->load->model('ticket_mailing');
		/*
			Get orders that are unsent
		 */
		$orders = $this->cron_send_tickets->getPaidUnsentOrders();
		/*
			Create foreach loop to create and send tickets
		 */
		foreach ($orders as $key => $value) {
			/*foreach ($value['tickets'] as $key_tickets => $value_ticket) {
				$result = $this->pdf->maketicket($value_ticket, $value);
			}*/

			if($this->ticket_mailing->mail_ticket($value)){
				echo 'Mail verstuurd naar: '.$value['user']['UserName'].'<br>';
				$this->buyer_orders->setOrderStatus($value['OrderID'], '3');
			}
		}
	}
	public function clearopenorders($params=null){
		$this->buyer_orders->deleteOpenOrders((isset($params[0]) ? $params[0] : 3));
	}
}