<?php

require_once './autenticacao.php';

  $aluno = (!empty($_POST['aluno']) ? $_POST['aluno'] : null);
  $frequencia = (!empty($_POST['frequencia']) ? $_POST['frequencia'] : null);
  $desempenho = (!empty($_POST['desempenho']) ? $_POST['desempenho'] : null);
  $cumpriu = (!empty($_POST['grupo_cumpriu']) ? $_POST['grupo_cumpriu'] : null);
  $duvida = (!empty($_POST['grupo_duvida']) ? $_POST['grupo_duvida'] : null);
  $dificuldade = (!empty($_POST['grupo_dificuldade']) ? $_POST['grupo_dificuldade'] : null);
  $caso_sim = (!empty($_POST['caso_sim']) ? $_POST['caso_sim'] : null);
   $consideracoes = (!empty($_POST['consideracoes']) ? $_POST['consideracoes'] : null);

          