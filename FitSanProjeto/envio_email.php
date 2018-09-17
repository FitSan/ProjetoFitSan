<?php
include './autenticacao.php'; 
ini_set('display_errors', true);

require_once './PHPMailer-6.0.5/src/PHPMailer.php';
require_once './PHPMailer-6.0.5/src/Exception.php';
require_once './PHPMailer-6.0.5/src/SMTP.php';
require_once './PHPMailer-6.0.5/src/POP3.php';
require_once './PHPMailer-6.0.5/src/OAuth.php';
require_once './PHPMailer-6.0.5/src/class.phpmailer.php';
require_once './PHPMailer-6.0.5/src/class.smtp.php';
require_once './PHPMailer-6.0.5/src/PHPMailerAutoload.php';


$email = (!empty($_POST['email']) ? $_POST['email'] : null);

$query = "select email from usuario";
$resultado_email = mysqli_query($conexao, $query);

while($linha = mysqli_fetch_array($resultado_email)){
    if($linha['email']==$email){
        $existe = true;
        break;
    }else {
        $existe = false;
    }
}
if($existe == FALSE){
    
    $_SESSION['erroEmail'] = "Dados nao conferem!";
    header('Location: form_recEmail.php'); 
    
} else {

$sql = "select id from usuario where email=$email";

$retorno = mysqli_query($conexao, $sql);



echo $retorno;

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
    $mail->Body = 'Recupere sua senha do FitSan!'
            . '<a href="http://localhost/FitSan/form_recSenha.php?perfil_id=<?php echo $perfil_id;?>"> Link </a>;';
    if (!$mail->send()){
        echo 'Não foi possível enviar a mensagem';
        echo 'Erro: ' . $mail->ErrorInfo;
    } else {
        
         $_SESSION['sucesso'] = "Dados conferem!";
      header('Location:http://localhost/FitSan/form_recEmail.php');
    }
        
}



}
?>
