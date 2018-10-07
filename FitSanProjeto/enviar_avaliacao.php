<?php
date_default_timezone_set('America/Sao_Paulo');

require_once './autenticacao.php';

$now = new DateTime();
$data_envio = $now->format('Y-m-d H:i:s');

  $aluno = (!empty($_POST['aluno']) ? $_POST['aluno'] : null);
  $frequencia = (!empty($_POST['frequencia']) ? $_POST['frequencia'] : null);
  $desempenho = (!empty($_POST['desempenho']) ? $_POST['desempenho'] : null);
  $cumpriu = (!empty($_POST['grupo_cumpriu']) ? $_POST['grupo_cumpriu'] : null);
  $duvida = (!empty($_POST['grupo_duvida']) ? $_POST['grupo_duvida'] : null);
  $dificuldade = (!empty($_POST['grupo_dificuldade']) ? $_POST['grupo_dificuldade'] : null);
  $caso_sim = (!empty($_POST['caso_sim']) ? $_POST['caso_sim'] : null);
   $consideracoes = (!empty($_POST['consideracoes']) ? $_POST['consideracoes'] : null);

   $query = "insert into `avaliacao` (`data`, `desempenho`, `frequencia`, `grupo_cumpriu`, `grupo_duvida`, `grupo_dificuldade`, `caso_sim`, `consideracoes`, `profissional_id`, `aluno_id`) values "
           . "('$data_envio', '$desempenho', '$frequencia', '$cumpriu', '$duvida', '$dificuldade', '$caso_sim', '$consideracoes', '$_SESSION[id]', '$aluno')";


            //echo $query;

            mysqli_query($conexao, $query);

            header('Location: pagina1.php');        