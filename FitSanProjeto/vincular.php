<?php
require_once './autenticacao.php';

if (tipoLogado('aluno')){
    $aluno_id = $_SESSION['id'];
    $profissional_id = $_GET['id'];
}else{
    $profissional_id = $_SESSION['id'];
    $aluno_id = $_GET['id'];
}

$query2 = "select * from usuario where id = " . mysqliEscaparTexto($_SESSION['id']) . " and status = 'ativado'";
$resultado = mysqli_query($conexao, $query2) or die_mysql($query2, __FILE__, __LINE__);
$linha = mysqli_fetch_array($resultado) or die_mysql($query2, __FILE__, __LINE__);

$tipo = (!empty($_SESSION['tipo']) ? $_SESSION['tipo'] : null);
$query = "insert into vinculo (aluno_id, profissional_id, status, solicitante) values (".mysqliEscaparTexto($aluno_id).", ".mysqliEscaparTexto($profissional_id) . ", 'espera', ".mysqliEscaparTexto($tipo).")";
mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);

criarNotificacao('INFO',
    'Você tem uma nova solicitação de '. $linha['nome'] . " " . $linha['sobrenome']  . '<br> O que deseja fazer? <a href="status_vinculo.php?id='.$_SESSION['id'].'&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id='.$_SESSION['id'].'&status=negado">Negar</a>',
    tipoLogado('aluno') ? $profissional_id : null,
    !tipoLogado('aluno') ? $aluno_id : null,
    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'vinculo']
);

if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: vinculos.php');
}
