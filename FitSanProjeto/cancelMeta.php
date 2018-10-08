<?php
require_once './autenticacao.php';

$id_meta = $_GET['id'];

$query = "update meta set status='cancelada' where id=$id_meta";
if(!mysqli_query($conexao, $query)){
    $_SESSION['erro'] = 'Meta não cancelada! Falha na conexão.';
    header('Location: metas.php');
}else{
    $_SESSION['info'] = 'Meta cancelada!';
    header('Location: metas.php');
}
