<?php
require_once './autenticacao.php';

$id_dica=$_POST['id'];
$diretorio= "uploads/dicas/";

$query_up = "select * from upload_dica where dica_id = $id_dica";
$resultado = mysqli_query($conexao, $query_up);
while ($linha_up = mysqli_fetch_array($resultado)){
    if(is_file($diretorio.$linha_up['nome_arq'])){
        unlink($diretorio.$linha_up['nome_arq']);
    }
}
$query = "delete from dica where id=$id_dica";
mysqli_query($conexao, $query);

$query_up_del = "delete from upload_dica where dica_id = $id_dica";
mysqli_query($conexao, $query_up_del);

if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: '.URL_SITE.'vinculos.php');
}