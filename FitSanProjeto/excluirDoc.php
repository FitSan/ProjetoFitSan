<?php
require_once './autenticacao.php';

$id=$_POST['doc_id'];
$diretorio= "uploads/anexos/";

$query_up = "select * from documentos_historico where id =". $id;
$resultado = mysqli_query($conexao, $query_up);
while ($linha_up = mysqli_fetch_array($resultado)){
    if(is_file($diretorio.$linha_up['anexo'])){
        unlink($diretorio.$linha_up['anexo']);
    }
}
$query = "delete from documentos_historico where id=".$id;
mysqli_query($conexao, $query);

if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: '.URL_SITE.'vinculos.php');
}