<?php

require_once './autenticacao.php';

$email = $_POST['e-mail'];
$senha = $_POST['senha'];

$sql = "select usuario.*, tipo_usuario.tipo from usuario left join tipo_usuario on tipo_usuario.id=usuario.tipo_id where email = '$email' and status = 'ativado'";
$retorno = mysqli_query($conexao, $sql) or die_mysql($sql, __FILE__, __LINE__);
$resultado = mysqli_fetch_array($retorno);

if ($resultado == null) {  
    $_SESSION['erro'] = "Dados nao conferem!";    
    header('Location: '.URL_SITE.'form_login.php');    
}else{
    $confirm = password_verify($senha, $resultado['senha']);
}

if ($confirm) {
    logar($resultado);
    header('Location: '.URL_SITE.'pagina1.php');    
}else{
    $_SESSION['erro'] = "Senha incorreta!";
    header('Location: '.URL_SITE.'form_login.php');   
}






