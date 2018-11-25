<?php
require_once 'autenticacao.php';

$enviar = $_POST['enviar'];
$profissional = $_POST['profissional'];
if (empty($enviar)){
    $_SESSION['erro'] = "Documento não indicado.";
    header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
    exit;
}
if (empty($profissional)){
    $_SESSION['erro'] = "Profissional não selecionado.";
    header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
    exit;
}

$docs = dbquery("select * from documentos_historico where id in (" . implode(',', $enviar).")");
foreach ($docs as $doc){
    criarNotificacao('INFO',
        $_SESSION['nome'] . " " . $_SESSION['sobrenome']  . ' enviou à você um documento.<br><a href="'.URL_SITE.'visualizar_anexo.php?id='.$doc['id'].'" target="_blank">Visualizar</a>',
        $profissional,
        null,
        [
            'aluno_id' => $_SESSION['id'],
            'profissional_id' => $profissional,
            'destinatario' => $profissional,
            'table' => 'documentos_historico',
        ]
    );
}
$_SESSION['info'] = "Anexo enviado com êxito.";
header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
