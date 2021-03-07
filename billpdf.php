<?php
session_start();
$data=$_SESSION['data'];
#$ss=$_SESSION['ss'];
require_once '../vendor/autoload.php';
$mpdf=new \Mpdf\Mpdf();
$ss= file_get_contents('style.css'); // external css
$mpdf->WriteHTML($ss,1);
$mpdf->WriteHTML($data,2);
$mpdf->Output('invoice.pdf','D');
?>