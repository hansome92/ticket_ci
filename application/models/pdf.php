<?php 

class Pdf extends CI_Model
{
	/**
	 *	Object properties
	 */
	private $wizard;
	private $database;
	
	/**
	 * Constructor
	 */
	function __construct(){
		parent::__construct();
		
		$this->database = $this->db->conn_id;
	}
	// Load all the events
	public function maketicket($ticketdata, $overalldata){
		ob_clean();
		// Include the main TCPDF library (search for installation path).
		require_once('./tcpdf/config/tcpdf_config.php');
		require_once('./tcpdf/tcpdf.php');
		require_once('./tcpdf/custompdf.php');


		// create new PDF document
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new Custompdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Tibbaa');
		$pdf->SetTitle('Tibbaa e-ticket');
		$pdf->SetSubject('Ticket');
		$pdf->SetKeywords('Ticket');
		// set default header data
		if(isset($ticketdata['eventdata']['customisationpreferences']['header_photo']['Value']) && $ticketdata['eventdata']['customisationpreferences']['header_photo']['Value'] != ''){
			$pdf->SetHeaderData('../../../uploads/cover_photos/_src/'.$ticketdata['eventdata']['customisationpreferences']['header_photo']['Value'], 180, PDF_HEADER_TITLE.' ', '');
		}
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin( 0 );

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		// ---------------------------------------------------------

		// set a barcode on the page footer
		//$pdf->setBarcode(date('Y-m-d H:i:s'));

		// set font
		$pdf->SetFont('helvetica', '', 11);
		foreach ($ticketdata['ticketnumbers'] as $key => $value) {
			// add a page
			$pdf->AddPage();
			// -----------------------------------------------------------------------------

			$pdf->SetFont('helvetica', '', 10);
			$positionYOffset = 62;
			$positionXOffset = 59;
			// CODE 128 A
			
			for ($i=0; $i < 3; $i++) { 
				for ($j=0; $j < 3; $j++) { 
					if($ticketdata['eventdata']['eventsponsorpreferences'][( ($i) + ($j*3) )]['Value'] === 'barcode'){
						$txt= '<table cellpadding="5px">
						<tr>
							<td>'.$value['BuyerName'].'</td>
						</tr>
						<tr>
							<td>'.$ticketdata['eventdata']['EventName'].'</td>
						</tr>
						<tr>
							<td>Price: &euro;'.$ticketdata['preferences']['tickets-ppt']['Value'].'</td>
						</tr>
						</table>';
						$pdf->writeHTMLCell(56, 56, (($positionXOffset*$i)+17), (($positionYOffset*$j)+75), $txt, 0);
						// define barcode style
						$style = array( 'position' => '', 'align' => 'C', 'stretch' => false, 'fitwidth' => true, 'cellfitalign' => '', 'border' => false, 'hpadding' => 'auto', 'vpadding' => 'auto', 'fgcolor' => array(0,0,0), 'bgcolor' => false, 'text' => true, 'font' => 'helvetica', 'fontsize' => 7, 'stretchtext' => 4
						);
						$value = sprintf('%1$09d', $value['ID']);
						$pdf->write1DBarcode($value.'8', 'EAN13', (($positionXOffset*$i)+17), (($positionYOffset*$j)+105), 56, 20, 0.4, $style, 'N');
					}
					else{
						if($ticketdata['eventdata']['eventsponsorpreferences'][( ($i) + ($j*3) )]['image']['Value'] != ''){
							$img = $ticketdata['eventdata']['eventsponsorpreferences'][( ($i) + ($j*3) )]['image'];
							if(strstr($img, '.jpg') != false){
								$imgtype = 'JPG';
							}
							elseif(strstr($img, '.png') != false){
								$imgtype = 'PNG';
							}
							// Check for cropped images, else just take the full image.
							if(file_exists('uploads/promotion_images/cropped-'.$img)){
								$pdf->Image('uploads/promotion_images/cropped-'.$img, (($positionXOffset*$i)+15), (($positionYOffset*$j)+71.8), 62, 62, $imgtype, '', '', false, 300, '', false, false, 0, false, false, false);
							}
							else{
								$pdf->Image('uploads/promotion_images/'.$img, (($positionXOffset*$i)+15), (($positionYOffset*$j)+71.8), 62, 62, $imgtype, '', '', false, 300, '', false, false, 0, false, false, false);
							}
						}
					}
				}
			}
		}

		//Close and output PDF document
		$pdf->Output('./ticket_cache/ticketorder-'.$ticketdata['OrderID'].'-'.$ticketdata['EticketID'].'.pdf', 'F');
		//exit();
		ob_end_flush();
		return 'ticketorder-'.$ticketdata['OrderID'].'-'.$ticketdata['EticketID'].'.pdf';
	}
	public function previewTickets($ticketdata=null, $overalldata=null){
		ob_clean();
		// Include the main TCPDF library (search for installation path).
		require_once('./tcpdf/config/tcpdf_config.php');
		require_once('./tcpdf/tcpdf.php');
		require_once('./tcpdf/custompdf.php');


		// create new PDF document
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new Custompdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Tibbaa');
		$pdf->SetTitle('Tibbaa e-ticket');
		$pdf->SetSubject('Ticket');
		$pdf->SetKeywords('Ticket');
		// set default header data
		if(isset($overalldata['eventscustomisationpreferences']['header_photo']['Value']) && $overalldata['eventscustomisationpreferences']['header_photo']['Value'] != ''){
			$pdf->SetHeaderData('../../../uploads/cover_photos/_src/'.$overalldata['eventscustomisationpreferences']['header_photo']['Value'], 180, PDF_HEADER_TITLE.' ', '');
		}
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin( 0 );

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// -----------------------------------------------------------------------------

		// set a barcode on the page footer
		//$pdf->setBarcode(date('Y-m-d H:i:s'));

		// set font
		$pdf->SetFont('helvetica', '', 11);
		// add a page
		$pdf->AddPage();
		// -----------------------------------------------------------------------------

		$pdf->SetFont('helvetica', '', 10);

		$positionYOffset = 62;
		$positionXOffset = 59;
		// CODE 128 A
		for ($i=0; $i < 3; $i++) { 
			for ($j=0; $j < 3; $j++) { 
				if(isset($overalldata['eventsponsorpreferences'][( ($i) + ($j*3) )]) && $overalldata['eventsponsorpreferences'][( ($i) + ($j*3) )]['Value'] === 'barcode'){
					$txt= '<table cellpadding="5px">
						<tr>
							<td>John Doe</td>
						</tr>
						<tr>
							<td>'.$overalldata['EventName'].'</td>
						</tr>
						<tr>
							<td>Price: &euro; 99,-</td>
						</tr>
					</table>';
					//echo 'ja';
					$pdf->writeHTMLCell(56, 56, (($positionXOffset*$i)+17), (($positionYOffset*$j)+75), $txt, 0);
					// define barcode style
					$style = array( 'position' => '', 'align' => 'C', 'stretch' => false, 'fitwidth' => true, 'cellfitalign' => '', 'border' => false, 'hpadding' => 'auto', 'vpadding' => 'auto', 'fgcolor' => array(0,0,0), 'bgcolor' => false, 'text' => true, 'font' => 'helvetica', 'fontsize' => 7, 'stretchtext' => 4
					);
					$value = sprintf('%1$09d', 99999999);
					$pdf->write1DBarcode($value.'8', 'EAN13', (($positionXOffset*$i)+17), (($positionYOffset*$j)+105), 56, 20, 0.4, $style, 'N');
				}
				else{
					if(isset($overalldata['eventsponsorpreferences'][( ($i) + ($j*3) )]['preferences']['image']) && $overalldata['eventsponsorpreferences'][( ($i) + ($j*3) )]['preferences']['image']['Value'] != ''){
						$img = $overalldata['eventsponsorpreferences'][( ($i) + ($j*3) )]['preferences']['image']['Value'];
						if(strstr($img, '.jpg') != false){
							$imgtype = 'JPG';
						}
						elseif(strstr($img, '.png') != false){
							$imgtype = 'PNG';
						}
						if(file_exists('uploads/promotion_images/cropped-'.$img)){
							$pdf->Image('uploads/promotion_images/cropped-'.$img, (($positionXOffset*$i)+15), (($positionYOffset*$j)+71.8), 62, 62, $imgtype, '', '', false, 150, '', false, false, 0, false, false, false);
						}
						else{
							$pdf->Image('uploads/promotion_images/'.$img, (($positionXOffset*$i)+15), (($positionYOffset*$j)+71.8), 62, 62, $imgtype, '', '', false, 150, '', false, false, 0, false, false, false);
						}
						
					}
				}
			}
		}

		//Close and output PDF document
		$pdf->Output('./ticket_cache/ticketorder-'.$ticketdata['OrderID'].'-'.$ticketdata['EticketID'].'.pdf', 'I');

		ob_end_flush();
		//ob_clean();
		//$ticket = chunk_split($ticket);
		//echo '<xmp>';print_r($ticket); echo '</xmp>';
		//return 'ticketorder-'.$ticketdata['OrderID'].'-'.$ticketdata['EticketID'].'.pdf';
	}
	public function showTicket($ticketdata=null, $overalldata=null){
		$pdf = $this->setPDFSettings( (isset($ticketdata['eventdata']['customisationpreferences']['header_photo']) && $ticketdata['eventdata']['customisationpreferences']['header_photo']['Value'] != '' ? $ticketdata['eventdata']['customisationpreferences']['header_photo']['Value'] : '') );
		//echo '<xmp>'; print_r($ticketdata);echo '</xmp>';
		$positionYOffset = 62;
		$positionXOffset = 59;
		// set default header data
		for ($i=0; $i < 3; $i++) { 
			for ($j=0; $j < 3; $j++) { 
				if($ticketdata['eventdata']['eventsponsorpreferences'][( ($i) + ($j*3) )]['Value'] === 'barcode'){
					$txt= '<table cellpadding="5px">
					<tr>
						<td>'.$ticketdata['BuyerName'].'</td>
					</tr>
					<tr>
						<td>'.$ticketdata['eventdata']['EventName'].'</td>
					</tr>
					<tr>
						<td>'.$ticketdata['ticket']['preferences']['tickets-name']['Value'].'</td>
					</tr>
					<tr>
						<td>Price: &euro; '.$ticketdata['ticket']['preferences']['tickets-ppt']['Value'].'</td>
					</tr>
					</table>';
					$pdf->writeHTMLCell(56, 56, (($positionXOffset*$i)+17), (($positionYOffset*$j)+75), $txt, 0);
					// define barcode style
					$style = array( 'position' => '', 'align' => 'C', 'stretch' => false, 'fitwidth' => true, 'cellfitalign' => '', 'border' => false, 'hpadding' => 'auto', 'vpadding' => 'auto', 'fgcolor' => array(0,0,0), 'bgcolor' => false, 'text' => true, 'font' => 'helvetica', 'fontsize' => 7, 'stretchtext' => 4
					);
					//echo '<xmp>'; print_r($ticketdata);echo '</xmp>';
					$value = sprintf('%1$09d', $ticketdata['ticketnumber']);
					$pdf->write1DBarcode($value.'8', 'EAN13', (($positionXOffset*$i)+17), (($positionYOffset*$j)+105), 56, 20, 0.4, $style, 'N');
				}
				else{
					if($ticketdata['eventdata']['eventsponsorpreferences'][( ($i) + ($j*3) )]['image']['Value'] != ''){
						$img = $ticketdata['eventdata']['eventsponsorpreferences'][( ($i) + ($j*3) )]['image'];
						if(strstr($img, '.jpg') != false){
							$imgtype = 'JPG';
						}
						elseif(strstr($img, '.png') != false){
							$imgtype = 'PNG';
						}
						// Check for cropped images, else just take the full image.
						if(file_exists('uploads/promotion_images/cropped-'.$img)){
							$pdf->Image('uploads/promotion_images/cropped-'.$img, (($positionXOffset*$i)+15), (($positionYOffset*$j)+71.8), 62, 62, $imgtype, '', '', false, 300, '', false, false, 0, false, false, false);
						}
						else{
							$pdf->Image('uploads/promotion_images/'.$img, (($positionXOffset*$i)+15), (($positionYOffset*$j)+71.8), 62, 62, $imgtype, '', '', false, 300, '', false, false, 0, false, false, false);
						}
					}
				}
			}
		}
		//Close and output PDF document
		$pdf->Output('./ticket_cache/ticketorder-'.$ticketdata['OrderID'].'-'.$ticketdata['EticketID'].'.pdf', 'I');

		ob_end_flush();
	}
	public function setPDFSettings($header=''){
		ob_clean();
		// Include the main TCPDF library (search for installation path).
		require_once('./tcpdf/config/tcpdf_config.php');
		require_once('./tcpdf/tcpdf.php');
		require_once('./tcpdf/custompdf.php');


		// create new PDF document'
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new Custompdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Tibbaa');
		$pdf->SetTitle('Tibbaa e-ticket');
		$pdf->SetSubject('Ticket');
		$pdf->SetKeywords('Ticket');


		if($header != ''){
			$pdf->SetHeaderData('../../../uploads/cover_photos/_src/'.$header, 180, PDF_HEADER_TITLE.' ', '');
		}
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin( 0 );

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		// -----------------------------------------------------------------------------

		// set a barcode on the page footer
		//$pdf->setBarcode(date('Y-m-d H:i:s'));

		// set font
		$pdf->SetFont('helvetica', '', 11);
		// add a page
		$pdf->AddPage();
		// -----------------------------------------------------------------------------

		$pdf->SetFont('helvetica', '', 10);

		return $pdf;
	}
}

?>