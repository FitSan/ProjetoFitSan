<?php
require_once './autenticacao.php';

$query = "update usuario set status = 'desativado' where id=$_SESSION[id]";
mysqli_query($conexao, $query);

deslogar(); 

header('Location: '.URL_SITE.'form_login.php');
