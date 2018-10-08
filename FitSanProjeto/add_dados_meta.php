<?php
require_once './autenticacao.php';

$meta_id = (!empty($_POST['meta_id']) ? $_POST['meta_id'] : null);
//$query = "select * from meta where id=$meta_id";
//$resultado = mysqli_query($conexao, $query);
//$linha = mysqli_fetch_array($resultado);

$data_add = (!empty($_POST['data_dado_meta']) ? $_POST['data_dado_meta'] : null);
$peso_add = (!empty($_POST['peso']) ? $_POST['peso'] : null);

$data_add = date('Y-m-d', dataParse($data_add));
//$data_add = new DateTime($data_add);
//
//$diff_inicio = $data_add->diff($linha['data_inicial']);
//$diff_inicio = $diff_inicio->format("%r%a");
//
//$diff_fim = $data_add->diff($linha['data_final']);
//$diff_fim = $diff_fim->format("%r%a");
//
//if($diff_fim>0 || $diff_inicio<0){
//    $_SESSION['erro']= 'Dado não adicionado! Preencha uma data válida.';
//}
//echo $meta_id.$data_add.$peso_add;

if ($data_add == null || $peso_add== null){
    $_SESSION['erro'] = 'Erro! Complete os campos para a inserção dos dados.';
    header('Location: metas.php');
} else {
    $query = "insert into dados_meta (data_add, peso_add, meta_id) values ('$data_add', '$peso_add', $meta_id)";
    if (!mysqli_query($conexao, $query)){
       $_SESSION['erro']= 'Dado não adicionado à meta atual! Falha na conexão.';
       header('Location: metas.php');
   }else{
      $_SESSION['info'] = 'Dado adicionado! Meta atualizada.';
      header('Location: metas.php');
   }
}