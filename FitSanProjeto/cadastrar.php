<?php

require_once './autenticacao.php';
include './bancodedados/conectar.php';

require_once './PHPMailer-6.0.5/src/PHPMailer.php';
require_once './PHPMailer-6.0.5/src/Exception.php';
require_once './PHPMailer-6.0.5/src/SMTP.php';
require_once './PHPMailer-6.0.5/src/POP3.php';
require_once './PHPMailer-6.0.5/src/OAuth.php';
require_once './PHPMailer-6.0.5/src/class.phpmailer.php';
require_once './PHPMailer-6.0.5/src/class.smtp.php';
require_once './PHPMailer-6.0.5/src/PHPMailerAutoload.php';



$nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
$sobrenome = (!empty($_POST['sobrenome']) ? $_POST['sobrenome'] : null);
$datanasc = (!empty($_POST['dataNasc']) ? $_POST['dataNasc'] : null);
$sexo = (!empty($_POST['sexo']) ? $_POST['sexo'] : null);
$foto = (!empty($_POST['foto']) ? $_POST['foto'] : null);
$email = (!empty($_POST['email']) ? $_POST['email'] : null);
$senha = (!empty($_POST['senha']) ? $_POST['senha'] : null);
$confsenha = (!empty($_POST['confsenha']) ? $_POST['confsenha'] : null);
$tipo_usuario = (!empty($_POST['tipo_id']) ? $_POST['tipo_id'] : null);

function tratar_nome($nome) {
    $nome = strtolower($nome); // Converter o nome todo para minúsculo
    $nome = explode(" ", $nome); // Separa o nome por espaços
    for ($i = 0; $i < count($nome); $i++) {

        // Tratar cada palavra do nome
        if ($nome[$i] == "de" or $nome[$i] == "da" or $nome[$i] == "e" or $nome[$i] == "dos" or $nome[$i] == "do") {
            $saida .= $nome[$i] . ' '; // Se a palavra estiver dentro das complementares mostrar toda em minúsculo
        } else {
            $saida .= ucfirst($nome[$i]) . ' '; // Se for um nome, mostrar a primeira letra maiúscula
        }
    }
    return $saida;
}

$nome = tratar_nome($nome);
$sobrenome = tratar_nome($sobrenome);
$size = strlen($nome);
$nome = substr($nome, 0, $size - 1);
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

$query_usuario = "select email from usuario";

$resultado_usuario = mysqli_query($conexao, $query_usuario);

while ($linha = mysqli_fetch_array($resultado_usuario)) {
    if ($linha['email'] == $email) {
        $existe = true;
        break;
    } else {
        $existe = false;
    }
}

$contEmail = strlen($email); //contando o número de caracteres da email 
$contSenha = strlen($senha); //contando o número de caracteres da senha 


if ($contSenha < 8) {
    $_SESSION['erroCount'] = "Dados nao conferem!";
    $_SESSION['erro_nome'] = $nome;
    $_SESSION['erro_sobrenome'] = $sobrenome;
    $_SESSION['erro_email'] = $email;
    $_SESSION['erro_tipo_usuario'] = $tipo_usuario;
    header('Location: '.URL_SITE.'form_cadastrar.php');
} else {
    if ($senha != $confsenha) {
        $_SESSION['errosenha'] = "Dados nao conferem!";
        $_SESSION['erro_nome'] = $nome;
        $_SESSION['erro_sobrenome'] = $sobrenome;
        $_SESSION['erro_email'] = $email;
        $_SESSION['erro_tipo_usuario'] = $tipo_usuario;
        header('Location: '.URL_SITE.'form_cadastrar.php');
    } else {
        if ($existe || $contEmail == null) {
            $_SESSION['erroemail'] = "Dados nao conferem!";
            $_SESSION['erro_nome'] = $nome;
            $_SESSION['erro_sobrenome'] = $sobrenome;
            $_SESSION['erro_senha'] = $senha;
            $_SESSION['erro_confsenha'] = $confsenha;
            $_SESSION['erro_tipo_usuario'] = $tipo_usuario;
            header('Location: '.URL_SITE.'form_cadastrar.php');
        } else {
            $query = "insert into usuario (nome, sobrenome, senha, email, tipo_id, status, datahora) values (".mysqliEscaparTexto($nome).",".mysqliEscaparTexto($sobrenome).",".mysqliEscaparTexto($senha_hash).",".mysqliEscaparTexto($email).",".mysqliEscaparTexto($tipo_usuario).", 'desativado', now())";
            if (dbquery($query, false)){
                $_SESSION['cadastrado'] = "Sucesso";
                if (!empty($email)){ 
                    $mail = new PHPMailer();
                    $mail->isSMTP();
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
                    $mail->Body = "<a href=\"".URL_SITE."validar_conta.php?perfil_email=".urlencode($email)."\"> CLIQUE AQUI PARA ATIVAR SUA CONTA !</a>";
                    if (!$mail->send()){
                        $_SESSION['erroemail'] = 'Não foi possível enviar a mensagem'.PHP_EOL;
                        $_SESSION['erroemail'] .= 'Erro: ' . $mail->ErrorInfo;
                    }
                }
                header('Location: '.URL_SITE.'form_login.php');
            } else {
                $_SESSION['erroemail'] = "Usuário não cadastrado!";
                $_SESSION['erro_nome'] = $nome;
                $_SESSION['erro_sobrenome'] = $sobrenome;
                $_SESSION['erro_senha'] = $senha;
                $_SESSION['erro_confsenha'] = $confsenha;
                $_SESSION['erro_tipo_usuario'] = $tipo_usuario;
                header('Location: '.URL_SITE.'form_cadastrar.php');
            }
        }
    }
}
