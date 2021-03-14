<?php
    session_start();
    require_once('./classes/user.php');
    if(isset($_SESSION['user']))
    {
        $user=unserialize($_SESSION['user']);
        if($user->category!='user')
            header('location:logout.php');
    }
    else header('location:login.php');
    $data=$_SESSION['data'];
    #$ss=$_SESSION['ss'];
    require_once '../vendor/autoload.php';
    $mpdf=new \Mpdf\Mpdf();
    $ss= file_get_contents('style.css'); // external css
    $mpdf->WriteHTML($ss,1);
    $mpdf->WriteHTML($data,2);
    $mpdf->Output('invoice.pdf','D');
?>