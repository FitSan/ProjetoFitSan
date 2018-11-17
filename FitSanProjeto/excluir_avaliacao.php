<?php
require_once './autenticacao.php';

$id_avaliacao = $_GET['id_avaliacao'];

$query = "delete from avaliacao where id =$id_avaliacao";

mysqli_query($conexao, $query);


    header('Location: '.URL_SITE.'form_historico_avaliacao_profissional.php');

