<?php
require_once 'autenticacao.php';

$id = $_GET['id'];

if (isset($_GET['notificacao'])) leituraNotificacao($_GET['notificacao']);

$doc = dbquery("select * from documentos_historico where id = " . mysqliEscaparTexto($id), 'row');

header('Location: ' . URL_SITE.'uploads/anexos/'.$doc['anexo']);
