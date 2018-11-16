<?php
require_once './autenticacao.php';

if(isset($_POST['meta_id'])){
    $id_meta=$_POST['meta_id'];
}

$query = "update meta set status='finalizada', data_final=now() where id=$id_meta";
if(!mysqli_query($conexao, $query)){
    $_SESSION['erro'] = 'Meta não finalizada! Falha na conexão.';
    header('Location: '.URL_SITE.'metas.php');
}else{
    $query_info = "select * from meta where id= $id_meta";
    $resultado = mysqli_query($conexao, $query_info);
    $linha = mysqli_fetch_array($resultado);
    criarNotificacao('INFO', 'Você finalizou sua meta em '.date('d M Y', dataParse($linha['data_final'])) . '<br><a href="'.URL_SITE.'okMetaNot.php">Ver</a>', null, $_SESSION['id'], null);
    $_SESSION['info'] = 'Meta finalizada!';
    header('Location: '.URL_SITE.'metas.php');
}
