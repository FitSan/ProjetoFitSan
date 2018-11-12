<?php

include './autenticacao.php';

require_once './PHPMailer-6.0.5/src/PHPMailer.php';
require_once './PHPMailer-6.0.5/src/Exception.php';
require_once './PHPMailer-6.0.5/src/SMTP.php';
require_once './PHPMailer-6.0.5/src/POP3.php';
require_once './PHPMailer-6.0.5/src/OAuth.php';
require_once './PHPMailer-6.0.5/src/class.phpmailer.php';
require_once './PHPMailer-6.0.5/src/class.smtp.php';
require_once './PHPMailer-6.0.5/src/PHPMailerAutoload.php';

$email = (!empty($_POST['email']) ? $_POST['email'] : null);

$query = "select count(id) as total from usuario where email = " . mysqliEscaparTexto($email);
$resultado_email = mysqli_query($conexao, $query);
$linha = mysqli_fetch_array($resultado_email);
$existe = (intval($linha['total']) > 0);
if (!$existe) {
    $_SESSION['erroEmail'] = "Dados nao conferem!";
    header('Location: ' . URL_SITE . 'form_recEmail.php');
} else {
    $codigo = uniqid();
    // Criar um campo para guardar a data de criação deste código e, na
    // form_recSenha.php, verificar se a data em que está sendo feita a
    // verificação é inferior a data de criação mais 24h
    $sql = "UPDATE usuario SET codigo = " . mysqliEscaparTexto($codigo) . " WHERE email = " . mysqliEscaparTexto($email) . ";";
    $retorno = mysqli_query($conexao, $sql);
    if (!empty($email)) {
        $mail = new PHPMailer();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = EMAIL_AUTH;
        $mail->SMTPDebug = 0;
        $mail->SMTPAutoTLS = EMAIL_AUTOTLS;
        $mail->SMTPSecure = EMAIL_SECURE;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->Port = EMAIL_PORT;
        $mail->addAddress($email);
        $mail->setFrom(EMAIL);
        $mail->addReplyTo(EMAIL);
        $mail->isHTML();
        $mail->Subject = 'FitSan';
        $mail->Body = "<a href=\"" . URL_SITE . "form_recSenha.php?perfil_codigo=" . urlencode($codigo) . "\">Link</a>";
        if (!$mail->send()) {
            $_SESSION['erroEmail'] = 'Não foi possível enviar a mensagem' . PHP_EOL;
            $_SESSION['erroEmail'] .= 'Erro: ' . $mail->ErrorInfo;
        } else {
            $_SESSION['sucesso'] = "Dados conferem!";
        }
    }
    header('Location:' . URL_SITE . 'form_recEmail.php');
}
