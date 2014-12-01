<?php 

class Ticket_mailing extends CI_Model
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
	// Load all the events
	public function mail_ticket($order)
	{
		$mail = new PHPMailer();
		try {
			$message = file_get_contents($this->config->item('base_url').'mail.html');
			foreach ($order['tickets'] as $key => $value) {
				foreach ($value['ticketnumbers'] as $ticketskey => $ticketsvalue) {
					$mail->AddReplyTo('no-reply@tibbaa.com', 'Tibbaa Second Generation Ticketing');
					$mail->AddAddress( $ticketsvalue['BuyerEmail'], $ticketsvalue['BuyerName']);
					$mail->SetFrom('no-reply@tibbaa.com', 'Tibbaa Second Generation Ticketing');

					$mail->Subject = 'Ticket order '.$order['OrderID']. ' for: '.$ticketsvalue['BuyerName'];
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically

					$newMessage = str_replace('%eventName%', $value['eventdata']['EventName'], $message);
					$newMessage = str_replace('%link%', $this->config->item('base_url').'ticket/'.$order['OrderID'].'/'.$value['EticketID'].'/'.$ticketsvalue['ID'], $newMessage);
					$mail->MsgHTML($newMessage);

					// attachments
					/*foreach ($order['tickets'] as $key => $value) {
						/*if(file_exists('./ticket_cache/ticketorder-'.$order['OrderID'].'-'.$value['EticketID'].'.pdf')){
							$mail->AddAttachment( './ticket_cache/ticketorder-'.$order['OrderID'].'-'.$value['EticketID'].'.pdf' );
						}*
					}*/
					$mail->Send();
				}
			}
			return true;
		} catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			return false;
		}
		//echo '<xmp>'; print_r($ticket); echo '</xmp><br><bR>';
	}
}

?>