<?php
require_once './autenticacao.php';

$id = isset($_GET['notificacao']) ? $_GET['notificacao'] : null;
leituraNotificacao($id);
if (isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: vinculos.php');
}
