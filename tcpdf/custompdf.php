<?php
class Custompdf extends TCPDF {
    public function Footer() {
        $image_file = "images/logo.png";
        $this->Image($image_file, 11, 256, 55, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetFont('helvetica', 'N', 16);
        $this->Text(65, 267, 'Second generation ticketing', false, false, true, 0, 0, 'L', false, '', 0, false, 'T', 'M', false);
        // Voorwaarden

        $this->SetFont('helvetica', 'N', 8);
        //$this->Text(210, 5, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, ex, vero ut accusantium dignissimos ad eligendi nostrum et aut neque nam id voluptatum obcaecati tempora rerum reiciendis reprehenderit suscipit quos.', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Text(15, 275, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, ex, vero ut accusantium dignissimos ad eligendi nostrum et aut neque nam id voluptatum', false, false, true, 0, 4, 'L', false, '', 0, false, 'T', 'M', false);
        $this->Text(15, 278, 'obcaecati tempora rerum reiciendis reprehenderit suscipit quos.', false, false, true, 0, 4, 'L', false, '', 0, false, 'T', 'M', false);
    }
}
?>