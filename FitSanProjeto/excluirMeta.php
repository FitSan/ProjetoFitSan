<?php
require_once './autenticacao.php';

if(isset($_POST['meta_id'])&&$_POST['dado_id']!=''){
    $meta_id = $_POST['meta_id'];
    $dado_id = $_POST['dado_id'];
    $query_del = "delete from dados_meta where id=".$dado_id." and meta_id=".$meta_id;
    if(!mysqli_query($conexao, $query_del)){
        $_SESSION['erro'] = 'Falha na conexão! Dado não excluído.';
        header('Location: metas.php');
    }else{
        $_SESSION['info']='Dado excluído!';
        header('Location: metas.php');
    }
}else if(isset($_POST['meta_id'])){
    $meta_id = $_POST['meta_id'];
    $query_del_dado = "delete from dados_meta where meta_id=".$meta_id;
    mysqli_query($conexao, $query_del_dado);
    $query_del = "delete from meta where id=".$meta_id;
    if(!mysqli_query($conexao, $query_del)){
        $_SESSION['erro'] = 'Falha na conexão! Meta não excluída.';
        header('Location: metas.php');
    }else{
        $_SESSION['info'] = 'Meta excluída!';
        header('Location: metas.php');
    }
}else{
    $_SESSION['erro'] = 'Erro! Ocorreu uma falha ao tentar excluir os dados.';
    header('Location: metas.php');
}