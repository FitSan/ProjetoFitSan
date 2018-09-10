<?php
require_once './autenticacao.php';

$id_dica=$_POST['id'];

$query = "delete from dica where id=$id_dica";
mysqli_query($conexao, $query);
echo $id_dica;
header('Location: minhas_dicas.php');