<?php

date_default_timezone_set('America/Sao_Paulo');
require_once 'autenticacao.php';

$id = mysqli_escape_string($conexao, $_POST['id']); // TODO: escape de caracteres estranhos dentro do id mudar todos que tenham post ou get.
$dica = $_POST['dica'];
$titulo = (!empty($_POST['titulo']) ? $_POST['titulo'] : null);
if ($titulo == null) {
    $_SESSION['msg'] = 'Preencha o título de sua dica!';
    header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
} else {
//$data_envio = $_POST['data_envio'];
    $now = new DateTime();
    $data_envio = $now->format('Y-m-d H:i:s');
//if (isset($_POST['id_upload'][0])) {
//    $id_upload[] = $_POST['id_upload'];
//}
    $excluidos = 0;
    $diretorio = "uploads/dicas/";
    if (isset($_POST['id_upload'])) {
        foreach ($_POST['id_upload'] as $excluido) {
            $excluidos = $excluidos + 1;
        }
    }

    $quantUploads = 0;
    $quantUploadsVid = 0;
    $msg = '';

    $query_dica = "select id from upload_dica where dica_id=$id and tipo='img'";
    $resultado_dica = mysqli_query($conexao, $query_dica);
    $quantUploads = mysqli_num_rows($resultado_dica);
    $quantUploads = $quantUploads - $excluidos;
    if ($quantUploads < 0) {
        $quantUploads = 0;
    }
    if ($quantUploads == 0) {
        $query_dica_vid = "select id from upload_dica where dica_id=$id and tipo='vid'";
        $resultado_dica_vid = mysqli_query($conexao, $query_dica_vid);
        $quantUploadsVid = mysqli_num_rows($resultado_dica_vid);
        $quantUploadsVid = $quantUploadsVid - $excluidos;
        if ($quantUploadsVid < 0) {
            $quantUploadsVid = 0;
        }
    }

    $query = "update dica set texto='$dica', profissional_nome='$_SESSION[nome]', profissional_id=$_SESSION[id], data_envio='$data_envio' where id=$id";

    if ($_FILES['imagens']['size'][0] != 0 && $_FILES['video']['size'] != 0) {
        $_SESSION['msg'] = "Dica não alterada! Escolha apenas um tipo de upload.";
        header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
    } else if ($_FILES['imagens']['size'][0] != 0) {
        $arquivo = $_FILES['imagens'];
        $numArq = count(array_filter($arquivo['name']));

        $type = 'img';

        $permite = array('image/jpeg', 'image/png');
        $maxSize = 1024 * 1024 * 2; // TODO: 2 megabytes
        $maxNum = 6 - $quantUploads; // TODO: 6 imagens permitidas OPINIÕES

        $arqSize = $maxSize * $numArq;

        for ($i = 0; $i < $numArq; $i++) {
            if ($arquivo['error'][$i] != 0 || !in_array($arquivo['type'][$i], $permite) || $arquivo['size'][$i] > $maxSize || $numArq > $maxNum || $quantUploadsVid != 0) {
                $Error = true;
                $iError = $i;
                break;
            } else {
                $Error = false;
            }
        }

        if (!$Error) {
            if (isset($_POST[id_upload])) {
                foreach ($_POST['id_upload'] as $id_upload) {
                    $query_upload = "select * from upload_dica where id=$id_upload";
                    $resultado = mysqli_query($conexao, $query_upload);
                    $linha_up = mysqli_fetch_array($resultado);
                    if (is_file($diretorio . $linha_up['nome_arq'])) {
                        unlink($diretorio . $linha_up['nome_arq']);
                    }
                    $query_del_up = "delete from upload_dica where id = $id_upload";
                    mysqli_query($conexao, $query_del_up);
                }
            }
            mysqli_query($conexao, $query);
            for ($i = 0; $i < $numArq; $i++) {
                $extensao = @end(explode('.', $arquivo['name'][$i]));
                $novo_nome = md5(rand()) . $extensao;
                move_uploaded_file($arquivo['tmp_name'][$i], $diretorio . $novo_nome);
                $query = "insert into upload_dica values (default, '$novo_nome', '$type', $id)";

                if (!mysqli_query($conexao, $query)) {
                    $_SESSION['msg'] = "Envio não realizado! Falha na conexão.";
                    header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
                } else {
                    header('Location: ' . URL_SITE . 'pagina1.php');
                }
            }
        } else {
            if ($numArq > $maxNum) {
                if ($maxNum == 0) {
                    $msg = "Dica não alterada! Dica já possui a quantidade máxima de imagens.";
                } else {
                    $msg = "Dica não alterada! Muitos arquivos selecionados, máximo " . $maxNum . ".";
                }
            } else if (!in_array($arquivo['type'][$iError], $permite)) {
                $msg = "Dica não alterada! Arquivo " . $arquivo['name'][$iError] . " possui tipo de arquivo não permitido.";
            } else if ($quantUploadsVid != 0) {
                $msg = "Dica não alterada! Dica já possui upload de vídeo.";
            } else if ($arquivo['size'][$iError] > $maxSize) {
                $msg = "Dica não alterada! Tamanho do arquivo " . $arquivo['name'][$iError] . " excede limite de 2MB.";
            } else {
                $msg = "Dica não alterada! Erro no upload.";
            }
            $_SESSION['msg'] = $msg;
            header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
        }
    } else if ($_FILES['video']['size'] != 0) {
        $arquivo = $_FILES['video'];
        $type = 'vid';
        $permite = array('video/mp4', 'video/avi'); // TODO: MAIS ALGUM
        $maxSize = 1024 * 1024 * 15; // TODO: 15 megabytes

        if ($arquivo['error'] == 0 && in_array($arquivo['type'], $permite) && $arquivo['size'] <= $maxSize && $quantUploadsVid == 0 && $quantUploads == 0) {
            if (isset($_POST[id_upload])) {
                foreach ($_POST['id_upload'] as $id_upload) {
                    $query_upload = "select * from upload_dica where id=$id_upload";
                    $resultado = mysqli_query($conexao, $query_upload);
                    $linha_up = mysqli_fetch_array($resultado);
                    if (is_file($diretorio . $linha_up['nome_arq'])) {
                        unlink($diretorio . $linha_up['nome_arq']);
                    }
                    $query_del_up = "delete from upload_dica where id = $id_upload";
                    mysqli_query($conexao, $query_del_up);
                }
            }
            mysqli_query($conexao, $query);
            $extensao = @end(explode('.', $arquivo['name']));
            $novo_nome = md5(rand()) . $extensao;

            move_uploaded_file($arquivo['tmp_name'], $diretorio . $novo_nome);
            $query = "insert into upload_dica values (default, '$novo_nome', '$type', $id)";

            if (!mysqli_query($conexao, $query)) {
                $_SESSION['msg'] = "Dica não alterada! Falha na conexão.";
                header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
            } else {
                header('Location: ' . URL_SITE . 'pagina1.php');
            }
        } else {
            if (!in_array($arquivo['type'], $permite)) {
                $msg = "Dica não alterada! Vídeo " . $arquivo['name'] . " possui tipo de arquivo não permitido.";
            } else if ($arquivo['size'] > $maxSize) {
                $msg = "Dica não alterada! Tamanho do arquivo " . $arquivo['name'] . " excede limite de 15MB.";
            } else if ($quantUploadsVid != 0) {
                $msg = "Dica não alterada! Dica já possui upload de vídeo.";
            } else if ($quantUploads != 0) {
                $msg = "Dica não alterada! Dica já possui upload de imagem.";
            } else {
                $msg = "Dica não alterada! Erro no upload do vídeo.";
            }
            $_SESSION['msg'] = $msg;
            header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
        }
    } else {
        if (!trim($dica) && $quantUploads == 0 && $quantUploadsVid == 0) {
            $_SESSION['msg'] = "Dica não alterada! Dica vazia.";
            header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
        } else {
            if (isset($_POST[id_upload])) {
                foreach ($_POST['id_upload'] as $id_upload) {
                    $query_upload = "select * from upload_dica where id=$id_upload";
                    $resultado = mysqli_query($conexao, $query_upload);
                    $linha_up = mysqli_fetch_array($resultado);
                    if (is_file($diretorio . $linha_up['nome_arq'])) {
                        unlink($diretorio . $linha_up['nome_arq']);
                    }
                    $query_del_up = "delete from upload_dica where id = $id_upload";
                    mysqli_query($conexao, $query_del_up);
                }
            }
            mysqli_query($conexao, $query);
            header('Location: ' . URL_SITE . 'pagina1.php');
        }
    }
}