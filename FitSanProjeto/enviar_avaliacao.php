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
   
   $musculatura = (!empty($_POST['musculatura']) ? $_POST['musculatura'] : null); 
   $lesao = (!empty($_POST['lesao']) ? $_POST['lesao'] : null); 
   $queimacao = (!empty($_POST['queimacao']) ? $_POST['queimacao'] : null); 
   $caimbras = (!empty($_POST['caimbras']) ? $_POST['caimbras'] : null); 
   $tontura = (!empty($_POST['tontura']) ? $_POST['tontura'] : null); 
   $consideracoes_corporal = (!empty($_POST['consideracoes_corporal']) ? $_POST['consideracoes_corporal'] : null); 
   

   $query = "insert into `avaliacao` (`data`, `desempenho`, `frequencia`, `grupo_cumpriu`, `grupo_duvida`, `grupo_dificuldade`, `caso_sim`, `consideracoes`, `musculatura`, `lesao`, `queimação`, `caimbras`, `tontura`, `consideracoes_corporal`, `profissional_id`, `aluno_id`) values "
           . "('$data_envio', '$desempenho', '$frequencia', '$cumpriu', '$duvida', '$dificuldade', '$caso_sim', '$consideracoes', '$musculatura', '$lesao', '$queimacao', '$caimbras', '$tontura', '$consideracoes_corporal', '$_SESSION[id]', '$aluno')";

          echo $query;
           exit();
           
            mysqli_query($conexao, $query);          
            
    $profissional_id = $_SESSION['id'];
    $aluno_id = $_POST['id'];

$query2 = "select * from usuario where id = " . mysqliEscaparTexto($_SESSION['id']) . " and status = 'ativado'";
$resultado = mysqli_query($conexao, $query2) or die_mysql($query2, __FILE__, __LINE__);
$linha = mysqli_fetch_array($resultado) or die_mysql($query2, __FILE__, __LINE__);


criarNotificacao('INFO',
    'Você tem uma Avaliação de '. $linha['nome'] . " " . $linha['sobrenome']  . "<br> <a href='form_receber_avaliacao.php'> Ver </a>",
  tipoLogado('aluno') ? $profissional_id : null,
    !tipoLogado('aluno') ? $aluno_id : null,
    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'notificacao']
);
            

            header('Location: pagina1.php');        