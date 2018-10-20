<?php
require_once './autenticacao.php';


$profissional_id = $_SESSION['id'];
    $aluno_id = $_GET['id'];

$query2 = "select * from usuario where id = " . mysqliEscaparTexto($_SESSION['id']) . " and status = 'ativado'";
$resultado = mysqli_query($conexao, $query2) or die_mysql($query2, __FILE__, __LINE__);
$linha = mysqli_fetch_array($resultado) or die_mysql($query2, __FILE__, __LINE__);




criarNotificacao('INFO',
    'Você tem uma nova avaliação de '. $linha['nome'] . " " . $linha['sobrenome']  . '<br> Existe uma nova avaliação',
    tipoLogado('aluno') ? $profissional_id : null,
    !tipoLogado('aluno') ? $aluno_id : null,
    ['profissional_id' => $profissional_id, 'aluno_id' => $aluno_id, 'table' => 'vinculo']
);


 header('Location: form_login.php');