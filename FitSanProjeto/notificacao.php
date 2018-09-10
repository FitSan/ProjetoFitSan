<?php
       
require_once './autenticacao.php';

//if ($_SESSION['tipo'] == 'profissional') {
//        criarNotificacao("OK", "Fulano adicionou você.", $_SESSION['id']);  
//    } else {
//        criarNotificacao("OK", "Fulano adicionou você.", null, $_SESSION['id']);  
//    }


$notificacao = consultarNotificacao();
foreach ($notificacao as $linha){
    var_dump($linha);
    echo $linha['texto'].'<br/>';
    if ($linha['profissional_id'] && ($linha['profissional_id'] != $_SESSION['id'])){
        echo 'Profissional: ' . $linha['prof_nome'].' '.$linha['prof_sobrenome'].'<br/>';
    }
    if ($linha['aluno_id'] && ($linha['aluno_id'] != $_SESSION['id'])){
        echo 'Aluno: ' . $linha['al_nome'].' '.$linha['al_sobrenome'].'<br/>';
    }
}
       