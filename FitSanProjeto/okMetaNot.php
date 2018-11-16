<?php
require_once './autenticacao.php';

$id = isset($_GET['notificacao']) ? $_GET['notificacao'] : null;
leituraNotificacao($id);
header('Location: '.URL_SITE.'historico.php?aba=pesosMedidas');
