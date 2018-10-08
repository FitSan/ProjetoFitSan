<?php
require_once './autenticacao.php';

if (tipoLogado('aluno')){
    $aluno_id = $_SESSION['id'];
    $profissional_id = $_GET['id'];
}else{
    $profissional_id = $_SESSION['id'];
    $aluno_id = $_GET['id'];
}

$query = "delete from vinculo where profissional_id=$profissional_id and aluno_id=$aluno_id";

mysqli_query($conexao, $query);

?>
<!--<script>history.go(-1)</script>-->


<?php

if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: buscar.php');
}
