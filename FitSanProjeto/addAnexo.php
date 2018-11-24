<?php

require_once './autenticacao.php';
$now = new DateTime();
$data_envio = $now->format('Y-m-d');


$alt_id = (!empty($_POST['alt_id']) ? $_POST['alt_id'] : null);
$titulo = (!empty($_POST['titulo']) ? $_POST['titulo'] : null);
$descricao = (!empty($_POST['descricao']) ? $_POST['descricao'] : null);
$msg = '';
$uploaddir = '/uploads/anexos/';
$dir = (rtrim(dirname(__FILE__), '\\/') . $uploaddir); // Obtém a pasta do arquivo do site
if (!@is_writable($dir)) {
    mkdir($dir, 0777, true); // Cria a pasta de uploads se não existir
}
if ($_FILES['anexo']['size'] != 0 && $titulo != null) {

    $arquivo = $_FILES['anexo'];
    if ($arquivo['error'] != 0) {
        $_SESSION['erro'] = 'Erro no envio do documento.';
        header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
    } else {
        $extensao = @end(explode('.', $arquivo['name']));
        $novo_nome = md5(rand()) . '.' . $extensao;
        move_uploaded_file($arquivo['tmp_name'], $dir . $novo_nome);
        if ($alt_id != null) {
            $query_upload = "select * from documentos_historico where id=" . mysqliEscaparTexto($alt_id);
            $resultado = mysqli_query($conexao, $query_upload);
            $linha_up = mysqli_fetch_array($resultado);
            if (is_file($dir . $linha_up['anexo'])) {
                unlink($dir . $linha_up['anexo']);
            }
            $query = "update documentos_historico set titulo='" . $titulo . "', descricao='" . $descricao . "', anexo='" . $novo_nome . "', tipo='" . $extensao . "', data_add='" . $data_envio . "' where id=" . $alt_id;
        } else {
            $query = "insert into documentos_historico (titulo, descricao, anexo, tipo, usuario_id, data_add) values ('$titulo', '$descricao', '$novo_nome', '$extensao', $_SESSION[id], '$data_envio')";
        }
        echo $query;
        if (!mysqli_query($conexao, $query)) {
            $_SESSION['erro'] = "Envio não realizado! Falha na conexão.";
//            header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
        } else {
            $_SESSION['info'] = 'Envio realizado! Documento anexado ao histórico.';
            header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
        }
    }
} else if ($alt_id != null && $_FILES['anexo']['size'] == 0) {
    $query = "update documentos_historico set titulo='" . $titulo . "', descricao='" . $descricao . "', data_add='" . $data_envio . "' where id=" . $alt_id;
    echo $query;
    if (!mysqli_query($conexao, $query)) {
        $_SESSION['erro'] = "Envio não realizado! Falha na conexão.";
//            header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
    } else {
        $_SESSION['info'] = 'Envio realizado! Documento anexado ao histórico.';
        header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
    }
} else {
    if ($_FILES['anexo']['size'][0] == 0 && $titulo != null) {
        $msg = 'Documento não enviado! Insira um anexo.';
    } else if ($_FILES['anexo']['size'][0] != 0 && $titulo == null) {
        $msg = 'Preencha o título do documento enviado.';
    } else {
        $msg = 'Erro! Preencha o campo título e realize o upload do anexo.';
    }
    $_SESSION['erro'] = $msg;
    header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
}