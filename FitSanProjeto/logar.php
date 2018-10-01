<?php

require_once './autenticacao.php';

ini_set("display_errors", true);

$email = $_POST['e-mail'];
$senha = $_POST['senha'];

$sql = "select usuario.*, tipo_usuario.tipo from usuario left join tipo_usuario on tipo_usuario.id=usuario.tipo_id where email = '$email'";
$retorno = mysqli_query($conexao, $sql) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$sql.PHP_EOL.print_r(debug_backtrace(), true));
$resultado = mysqli_fetch_array($retorno);

if ($resultado == null) {  
    $_SESSION['erro'] = "Dados nao conferem!";    
    header('Location: form_login.php');    
}else{
    $confirm = password_verify($senha, $resultado['senha']);
}

if ($confirm) {
    logar($resultado);
    header('Location: pagina1.php');    
}else{
    $_SESSION['erro'] = "Senha incorreta!";
    header('Location: form_login.php');   
}






