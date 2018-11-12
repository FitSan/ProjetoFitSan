<?php
require_once './autenticacao.php';

header('Content-Type: text/javascript; charset=utf-8');   
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");

$modo = (isset($_GET['modo']) ? $_GET['modo'] : '');
$arquivo = $erro = '';

$basedir = (rtrim(dirname(__FILE__), '\\/') . '/');
$baseurl = (
    'http' .
    ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 's' : '') .
    '://' .
    $_SERVER['HTTP_HOST'] .
    rtrim(dirname($_SERVER['REQUEST_URI']), '\\/')  .
    '/'
);

$uploadname = 'uploads/';
$uploaddir = ($basedir . $uploadname);
$uploadurl = ($baseurl . $uploadname);
if (!@is_writable($uploaddir)) mkdir($uploaddir, 0777, true);

$tempname = ($uploadname . 'temp/');
$tempdir = ($basedir . $tempname);
$tempurl = ($baseurl . $tempname);
if (!@is_writable($tempdir)) mkdir($tempdir, 0777, true);

switch ($modo){
    case 'crop':
	require_once('php/m2brimagem.class.php');
        $arquivo = $_POST['imagem'];
        $caminho = ($tempdir . $arquivo);
        $url = ($tempurl . $arquivo);
	$oImg = new m2brimagem($caminho);
	if ($oImg->valida() != 'OK'){
            $erro = 'Imagem inválida.';
            break;
	}
        if (!empty($_POST['redim'])) $oImg->redimensiona('500', '', '');
        $oImg->posicaoCrop($_POST['x'], $_POST['y']);
        $oImg->redimensiona($_POST['w'], $_POST['h'], 'crop');
        $oImg->grava($caminho);
        break;
    default:
        if (!empty($_FILES['imagem']['error'])){
            $erro = 'Erro ao fazer upload';
            break;
        }
        if (empty($_FILES['imagem']['tmp_name'])){
            $erro = 'Upload não enviado';
            break;
        }
        if (!@is_readable($_FILES['imagem']['tmp_name'])){
            $erro = 'Upload não encontrado';
            break;
        }
        $arquivo = strtolower(preg_replace('{[^a-z0-9_\-\.]+}i', '_', $_FILES['imagem']['name']));
        $caminho = ($tempdir . $arquivo);
        $url = ($tempurl . $arquivo);
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)){
            $erro = 'Upload não copiado';
            break;
        }
}

if ($erro){
    //header('HTTP/1.0 500 Error', true, 500);
    $saida = array('tipo' => 'erro', 'mensagem' => $erro);
} else {
    $saida = array('tipo' => 'ok', 'url' => $url, 'path' => $arquivo);
}

echo json_encode($saida);
