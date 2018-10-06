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

header('Content-Type: text/javascript; charset=utf-8');   

$acao = (!empty($_REQUEST['acao']) ? $_REQUEST['acao'] : '');

if ($acao == 'lista'){
    $ret = pegarLista();
} else {
    $ret = array('status' => 'error', 'mensagem' => 'Comando inválido');
}

echo json_encode($ret);
exit;
