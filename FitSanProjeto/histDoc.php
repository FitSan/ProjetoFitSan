<?php

require_once './autenticacao.php';

$id = $_GET['id'];
$acao = $_GET['acao'];

$query_anexo = "select * from documentos_historico where id=" . mysqliEscaparTexto($id) . " and usuario_id=" . $_SESSION['id'];
$resultado = mysqli_query($conexao, $query_anexo);
if (mysqli_num_rows($resultado) == 0) {
    $_SESSION['erro'] = 'Erro no processo.';
    header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
} else {
    $linha = mysqli_fetch_array($resultado);
    $tipo = $linha['tipo'];
    $path = 'uploads/anexos/' . $linha['anexo'];
    $arquivo = $linha['anexo'];

    switch ($tipo) {
        case "pdf": $ctype = "application/pdf";
            break;
        case "exe": $ctype = "application/octet-stream";
            break;
        case "zip": $ctype = "application/zip";
            break;
        case "doc": $ctype = "application/msword";
            break;
        case "xls": $ctype = "application/vnd.ms-excel";
            break;
        case "ppt": $ctype = "application/vnd.ms-powerpoint";
            break;
        case "gif": $ctype = "image/gif";
            break;
        case "png": $ctype = "image/png";
            break;
        case "jpeg":
        case "jpg": $ctype = "image/jpg";
            break;
        default: $ctype = "application/force-download";
    }

    function viewAnexo($type, $arq, $file, $size) {
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false); // required for certain browsers
        header("content-disposition: inline; filename={$arq}");
        header("content-type: {$type}");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$size);
        
        readfile($file);
    }

    function downloadAnexo($type, $arq, $file, $size) {
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false); // required for certain browsers
        header("content-disposition: attachment; filename={$arq}");
        header("content-type: {$type}");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$size);
        
        readfile($file);
    }
    if( file_exists($path) ){
        $fsize = filesize($path);
            if ($acao == 'view') {
                viewAnexo($ctype, $arquivo, $path, $fsize);
            } else if ($acao == 'download') {
                downloadAnexo($ctype, $arquivo, $path, $fsize);
            } else {
                $_SESSION['erro'] = 'Erro no processo.';
                header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
            }
        }else{
        $_SESSION['erro'] = 'Arquivo não encontrado.';
        header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
    }
    }
    
?>
