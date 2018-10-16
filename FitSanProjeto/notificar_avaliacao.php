<?php
require_once './autenticacao.php';


$profissional_id = $_SESSION['id'];
    $aluno_id = $_GET['id'];

$query2 = "select * from usuario where id = " . mysqliEscaparTexto($_SESSION['id']) . " and status = 'ativado'";
$resultado = mysqli_query($conexao, $query2) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query2.PHP_EOL.print_r(debug_backtrace(), true));
$linha = mysqli_fetch_array($resultado) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query2.PHP_EOL.print_r(debug_backtrace(), true));


criarNotificacao('INFO',
    'Você tem uma nova solicitação de '. $linha['nome'] . " " . $linha['sobrenome']  . '<br> Existe uma nova avaliação',
    tipoLogado('aluno') ? $profissional_id : null,
    !tipoLogado('aluno') ? $aluno_id : null,
    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'vinculo']
);

 header('Location: form_login.php');