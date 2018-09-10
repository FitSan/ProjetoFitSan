<?php
require_once './autenticacao.php';

$query = "delete from usuario where id=$_SESSION[id]";
mysqli_query($conexao, $query);

header('Location: form_login.php');