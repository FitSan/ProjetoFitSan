<?php
require_once './autenticacao.php';

if (tipoLogado('aluno')){
    $aluno_id = $_SESSION['id'];
    $profissional_id = $_GET['id'];
}else{
    $profissional_id = $_SESSION['id'];
    $aluno_id = $_GET['id'];
}

$status = (isset($_GET['status']) ? $_GET['status'] : 'espera');
if ($status == 'negado'){
    $query = "delete from vinculo where profissional_id=".mysqliEscaparTexto($profissional_id)." and aluno_id=".mysqliEscaparTexto($aluno_id);
} else {
    $query = "update vinculo set status = " . mysqliEscaparTexto($status) . " where aluno_id = ".mysqliEscaparTexto($aluno_id)." and profissional_id = ".mysqliEscaparTexto($profissional_id);
}
mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));

leituraNotificacao(
    isset($_GET['notificacao']) ? $_GET['notificacao'] : null,
    null,
    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'vinculo']
);
if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: vinculos.php');
}
