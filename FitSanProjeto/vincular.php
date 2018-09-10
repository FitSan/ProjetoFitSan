<?php
require_once './autenticacao.php';

if ($_SESSION['tipo']=='aluno'){
    $aluno_id = $_SESSION['id'];
    $profissional_id = $_GET['id'];
}else{
    $profissional_id = $_SESSION['id'];
    $aluno_id = $_GET['id'];
}

$query2 = "select * from usuario where id = " . mysqliEscaparTexto($_SESSION['id']);
$resultado = mysqli_query($conexao, $query2) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query2.PHP_EOL.print_r(debug_backtrace(), true));
$linha = mysqli_fetch_array($resultado) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query2.PHP_EOL.print_r(debug_backtrace(), true));

$tipo = (!empty($_SESSION['tipo']) ? $_SESSION['tipo'] : null);
$query = "insert into vinculo (aluno_id, profissional_id, status, solicitante) values (".mysqliEscaparTexto($aluno_id).", ".mysqliEscaparTexto($profissional_id) . ", 'espera', ".mysqliEscaparTexto($tipo).")";
mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));

criarNotificacao('INFO',
    'Você tem uma nova solicitação de '. $linha['nome'] . " " . $linha['sobrenome']  . '<br> O que deseja fazer? <a href="status_vinculo.php?id='.$_SESSION['id'].'&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id='.$_SESSION['id'].'&status=negado">Negar</a>',
    ($_SESSION['tipo']=='aluno') ? $profissional_id : null,
    ($_SESSION['tipo']!='aluno') ? $aluno_id : null,
    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'vinculo']
);
/*
<script>history.go(-1)</script>
*/
if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: vinculos.php');
}
