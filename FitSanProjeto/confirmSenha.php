<?php
require_once './autenticacao.php';

$senha = $_POST['senha'];
$senhaAlt = $_POST['senhaAlt'];

$query = "select * from usuario where id=$_SESSION[id]";
$retorno = mysqli_query($conexao, $query);

$linha = mysqli_fetch_array($retorno);

if (password_verify($senha, $linha['senha'])){
    $senhaAlt = password_hash($senhaAlt, PASSWORD_BCRYPT);
    $query_alt = "update usuario set senha = '$senhaAlt' where id=$_SESSION[id]";
    mysqli_query($conexao, $query);    
}else {
    
}

