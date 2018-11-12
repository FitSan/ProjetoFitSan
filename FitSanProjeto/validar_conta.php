<?php
include './autenticacao.php';

$email = $_GET['perfil_email'];

$_SESSION['codigo'] = $email;

$query_usuario = "select email from usuario";

$resultado_usuario = mysqli_query($conexao, $query_usuario);

// Arrumar isto
// Não buscar todos os usuários e correr a lista.
// Faça a busca na SQL para que traga apenas a quantidade
// Ver exemplo em envio_email.php e recSenha.php
while ($linha = mysqli_fetch_array($resultado_usuario)) {
    if ($linha['email'] == $email) {
        $existe = true;
        break;
    } else {
        $existe = false;
    }
}
if ($existe = true) {
    $query = "update usuario set status='ativado' where email ='$email'";
    mysqli_query($conexao, $query);
}

header('Location: ' . URL_SITE . 'form_login.php');
