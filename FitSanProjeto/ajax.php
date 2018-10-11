<?php
require_once './autenticacao.php';

function pegarLista(){
    global $conexao;
    if (!tipoLogado("profissional")) return array('status' => 'error', 'mensagem' => 'Apenas para profissionais');
    $query = "select * from usuario join vinculo on usuario.id = vinculo.aluno_id where vinculo.status = 'aprovado' and vinculo.profissional_id = " . $_SESSION[id];
    $retorno = mysqli_query($conexao, $query);
    if (!$retorno) return array('status' => 'error', 'mensagem' => ('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true)));
    $dados = array();
    while ($resultado = mysqli_fetch_array($retorno)){
        $dados[] = $resultado;
    }
    return array('status' => 'ok', 'dados' => $dados);
}

function enviarPlanilha(){
    global $conexao;
    if (!tipoLogado("profissional")) return array('status' => 'error', 'mensagem' => 'Apenas para profissionais');
    $titulo = (!empty($_REQUEST['titulo']) ? $_REQUEST['titulo'] : '');
    $alunos = (!empty($_REQUEST['lista-aluno']) ? $_REQUEST['lista-aluno'] : '');
    if (empty($titulo)) return array('status' => 'error', 'mensagem' => 'Título está vazio');
    if (empty($alunos)) return array('status' => 'error', 'mensagem' => 'Alunos está vazio');
    $query = "insert into planilha ( titulo ) values (" . mysqliEscaparTexto($titulo) . " )";
    if (!mysqli_query($conexao, $query)) return array('status' => 'error', 'mensagem' => ('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true)));
    $id = mysqli_insert_id($conexao);
    $query2 = "update planilha_tabela set planilha_id = " . mysqliEscaparTexto($id) . " where planilha_id is null";
    if (!mysqli_query($conexao, $query2)) return array('status' => 'error', 'mensagem' => ('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true)));
    foreach ($alunos as $aluno){
        $query3 = "insert into planilha_aluno (planilha_id, aluno_id) values (" . mysqliEscaparTexto($id) . ", " . mysqliEscaparTexto($aluno) . ")";
        if (!mysqli_query($conexao, $query3)) return array('status' => 'error', 'mensagem' => ('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true)));
        criarNotificacao("OK", "Uma planilha foi enviada à você.".PHP_EOL.'Acesse <a href="planilha_aluno.php?id='.$id.'">sua planilha</a>', $aluno);
    }
    return array('status' => 'ok');
}

header('Content-Type: text/javascript; charset=utf-8');   
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");

$acao = (!empty($_REQUEST['acao']) ? $_REQUEST['acao'] : '');

if ($acao == 'lista'){
    $ret = pegarLista();
} elseif ($acao == 'enviar_planilha'){
    $ret = enviarPlanilha();
} else {
    $ret = array('status' => 'error', 'mensagem' => 'Comando inválido');
}

echo json_encode($ret);
exit;
