<?php

require_once './autenticacao.php';

$nova_senha = $_POST['nova_senha'];
$repita_senha = $_POST['repita_senha'];
$codigo = $_SESSION['codigo'];

$contSenha = strlen($nova_senha); //contando os caracteres.

if ($nova_senha == $repita_senha && $contSenha >= 8) {
    $query = "select count(id) as total from usuario where codigo = " . mysqliEscaparTexto($codigo);
    $resultado_email = mysqli_query($conexao, $query);
    $linha = mysqli_fetch_array($resultado_email);
    $existe = (intval($linha['total']) > 0);
    if ($existe) {
        $senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);
        $sql = "UPDATE usuario SET senha=" . mysqliEscaparTexto($senha_hash) . " WHERE codigo = " . mysqliEscaparTexto($codigo) . ";";
        $retorno = mysqli_query($conexao, $sql);
        unset($_SESSION['codigo']);
        header('Location: ' . URL_SITE . 'form_login.php');
        exit();
    } else {
        $_SESSION['erroCodigo'] = "Dados nao conferem!";
        unset($_SESSION['codigo']);
        header('Location: ' . URL_SITE . 'form_recSenha.php');
    }
    header('Location: ' . URL_SITE . 'form_recSenha.php');
} else {
    $_SESSION['erroCount'] = "Dados nao conferem!";
    unset($_SESSION['codigo']);
    header('Location: ' . URL_SITE . 'form_recSenha.php');
}
