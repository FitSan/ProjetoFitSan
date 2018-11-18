<?php
date_default_timezone_set('America/Sao_Paulo');

require_once './autenticacao.php';


$id_avaliacao = $_SESSION['update'] ;
$usuario_passado = $_SESSION['usuario_passado'];

  unset($_SESSION['update']);

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
   
if($aluno == null){
    
           $_SESSION['semaluno']= "Dados nao conferem!";

        header('Location: '.URL_SITE.'form_avaliacao.php');
}else {
    if($frequencia == null && $desempenho == null && $cumpriu == null && $duvida == null && $dificuldade == null && $caso_sim == null && $consideracoes == null && $musculatura == null && $lesao == null && $queimacao == null && $caimbras == null && $tontura == null && $consideracoes_corporal == null){

        $_SESSION['semnada']= "Dados nao conferem!";

        header('Location: '.URL_SITE.'form_avaliacao.php');
    } else {
        
        if($usuario_passado==$aluno){
   $query = "update avaliacao set `data`='$data_envio', desempenho='$desempenho', frequencia='$frequencia',  grupo_cumpriu='$cumpriu', grupo_duvida='$duvida', grupo_dificuldade='$dificuldade', caso_sim='$caso_sim', consideracoes='$consideracoes', musculatura='$musculatura', lesao='$lesao', queimacao='$queimacao', caimbras='$caimbras',  tontura='$tontura', consideracoes_corporal= '$consideracoes_corporal' where avaliacao.id =$id_avaliacao";
  } else {
  
         $query = "insert into `avaliacao` (`data`, `desempenho`, `frequencia`, `grupo_cumpriu`, `grupo_duvida`, `grupo_dificuldade`, `caso_sim`, `consideracoes`, `musculatura`, `lesao`, `queimacao`, `caimbras`, `tontura`, `consideracoes_corporal`, `profissional_id`, `aluno_id`) values "
           . "('$data_envio', '$desempenho', '$frequencia', '$cumpriu', '$duvida', '$dificuldade', '$caso_sim', '$consideracoes', '$musculatura', '$lesao', '$queimacao', '$caimbras', '$tontura', '$consideracoes_corporal', '$_SESSION[id]', '$aluno')";
     
         $queryy = "delete from avaliacao where avaliacao.aluno_id=$usuario_passado and id =$id_avaliacao ";
  }


           
            mysqli_query($conexao, $query);        
                 mysqli_query($conexao, $queryy);    
  
$query2 = "select * from usuario where id = " . mysqliEscaparTexto($_SESSION['id']) . " and status = 'ativado'";
$resultado = mysqli_query($conexao, $query2) or die_mysql($query2, __FILE__, __LINE__);
$linha = mysqli_fetch_array($resultado) or die_mysql($query2, __FILE__, __LINE__);

 $_SESSION['atualizacao_avaliacao']= "Dados conferem!";

//criarNotificacao('INFO',
//    'Você tem uma Avaliação de '. $linha['nome'] . " " . $linha['sobrenome']  . "<br> <a href='form_receber_avaliacao.php'> Ver </a>",
//  tipoLogado('aluno') ? $profissional_id : null,
//    !tipoLogado('aluno') ? $aluno_id : null,
//    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'notificacao']
//);

criarNotificacao(
        "INFO", 
        " Você tem uma nova avaliação de " . $linha['nome'] . " " . $linha['sobrenome'] . ". " .PHP_EOL. 'Acesse: " <a href="'.URL_SITE.'form_receber_avaliacao.php"> Ver </a>', null, $aluno);
         

            header('Location: '.URL_SITE.'form_historico_avaliacao_profissional.php'); 
            
    }
            }
            
//form_mostrar_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>