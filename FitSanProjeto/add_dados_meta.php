<?php

namespace SDCU\GeneralBundle\Entity;

use \DateTime;

require_once './autenticacao.php';

$meta_id = (!empty($_POST['meta_id']) ? $_POST['meta_id'] : null);
$query_meta = "select * from meta where id=$meta_id";
$resultado_meta = mysqli_query($conexao, $query_meta);
$linha_meta = mysqli_fetch_array($resultado_meta);

$descricao = (!empty($_POST['descricao_dado']) ? $_POST['descricao_dado'] : null);
$data_add = (!empty($_POST['data_dado_meta']) ? $_POST['data_dado_meta'] : null);
$peso_add = (!empty($_POST['peso']) ? $_POST['peso'] : null);

$data_add = date('Y-m-d', dataParse($data_add));
$data_inicial = date('Y-m-d', dataParse($linha_meta['data_inicial']));
$data_final = date('Y-m-d', dataParse($linha_meta['data_final']));

$data = new DateTime($data_add);
$data_inicio = new DateTime($data_inicial);
$data_final = new DateTime($data_final);

$diff_inicio = $data->diff($data_inicio);
$diff_inicio = $diff_inicio->format("%r%a");

$diff_fim = $data->diff($data_final);
$diff_fim = $diff_fim->format("%r%a");
//echo $diff_fim .' ww '. $diff_inicio;

//echo $meta_id.$data.$peso_add;

if ($data_add == null || $peso_add== null){
    $_SESSION['erro'] = 'Erro! Complete os campos para a inserção dos dados.';
    header('Location: metas.php');
}else if($diff_fim<0 || $diff_inicio>0){
    $_SESSION['erro']= 'Dado não adicionado! Preencha uma data válida.';
    header('Location: metas.php');
}else{
    $query = "insert into dados_meta (data_add, peso_add, descricao, meta_id) values ('$data_add', '$peso_add', '$descricao', $meta_id)";
    if (!mysqli_query($conexao, $query)){
       $_SESSION['erro']= 'Dado não adicionado à meta atual! Falha na conexão.';
       header('Location: metas.php');
   }else{
      $_SESSION['info'] = 'Dado adicionado! Meta atualizada.';
      header('Location: metas.php');
   }
}