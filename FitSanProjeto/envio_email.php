<?php
 
ini_set('display_errors', true);

include './bancodedados/conectar.php';

require_once './PHPMailer-6.0.5/src/PHPMailer.php';
require_once './PHPMailer-6.0.5/src/Exception.php';
require_once './PHPMailer-6.0.5/src/SMTP.php';
require_once './PHPMailer-6.0.5/src/POP3.php';
require_once './PHPMailer-6.0.5/src/OAuth.php';
require_once './PHPMailer-6.0.5/src/class.phpmailer.php';
require_once './PHPMailer-6.0.5/src/class.smtp.php';
require_once './PHPMailer-6.0.5/src/PHPMailerAutoload.php';


$email = $_POST['email'];


if (!empty($email)){
       
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = TRUE;
    $mail->SMTPDebug = 1;
    $mail->SMTPAutoTLS = FALSE;
    $mail->SMTPSecure = 'ssl';
    $mail->Username = 'plataformafitsan@gmail.com';
    $mail->Password = 'NaStiF321';
    $mail->Port = 465;
    $mail->addAddress($email);
    $mail->setFrom($email);
    $mail->addReplyTo('plataformafitsan@gmail.com');
    $mail->isHTML();
    $mail->Subject = 'FitSan';
    $mail->Body = 'Recupere sua senha do FitSan!';
    if (!$mail->send()){
        echo 'Não foi possível enviar a mensagem';
        echo 'Erro: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensagem enviada.';
    }
        
}


//$sql = "insert into professores values (default, '$nome', $carga_horaria, '$email')";

//mysqli_query($conexao, $sql);

//header('Location: form_professores.php');



?>