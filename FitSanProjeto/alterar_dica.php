<?php
require_once 'autenticacao.php';

$id = $_POST['id'];
$dica = $_POST['dica'];
$titulo = (!empty($_POST['titulo']) ? $_POST['titulo'] : null);
$link = (!empty($_POST['link_video']) ? $_POST['link_video'] : null);


//if (!empty($_GET['erro'])) {
//    $_SESSION['msg'] = 'Não altere a URL! Essa dica não corresponde a suas postagens!';
//    header('Location: ' . URL_SITE . 'minhas_dicas.php');
//} else {

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

    $query_dica = "select id from upload_dica where dica_id= ".mysqliEscaparTexto($id)." and tipo='img'";
    $resultado_dica = mysqli_query($conexao, $query_dica);
    $quantUploads = mysqli_num_rows($resultado_dica);

    if ($quantUploads < 0) {
        $quantUploads = 0;
    }
    if ($quantUploads == 0) {
        $query_dica_vid = "select * from upload_dica where dica_id=".mysqliEscaparTexto($id)." and tipo='vid' or tipo='url'";
        $resultado_dica_vid = mysqli_query($conexao, $query_dica_vid);
        $linha_vid = mysqli_fetch_array($resultado_dica_vid);
        $quantUploadsVid = mysqli_num_rows($resultado_dica_vid);
        if ($quantUploadsVid <= 0) {
            $quantUploadsVid = 0;
            $video = false;
        } else {
            $video = true;
            $quantUploadsVid = $quantUploadsVid - $excluidos;
        }
    } else {
        $quantUploads = $quantUploads - $excluidos;
    }

    $query = "update dica set texto=".mysqliEscaparTexto($dica).", titulo=".mysqliEscaparTexto($titulo).", profissional_nome=".mysqliEscaparTexto(exibirName(true)).", profissional_id=".mysqliEscaparTexto($_SESSION[id]).", data_envio=".mysqliEscaparTexto($data_envio)." where id=".mysqliEscaparTexto($id);

    if ($_FILES['imagens']['size'][0] != 0 && $link != null) {
        $_SESSION['msg'] = "Dica não alterada! Escolha apenas um tipo de upload.";
        header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
    } else if ($_FILES['imagens']['size'][0] != 0) {
        $arquivo = $_FILES['imagens'];
        $numArq = count(array_filter($arquivo['name']));

        $type = 'img';

        $permite = array('image/jpeg', 'image/png');
        $maxSize = 1024 * 1024 * 5; // TODO: 5 megabytes
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
                    $query_upload = "select * from upload_dica where id=".mysqliEscaparTexto($id_upload);
                    $resultado = mysqli_query($conexao, $query_upload);
                    $linha_up = mysqli_fetch_array($resultado);
                    if (is_file($diretorio . $linha_up['nome_arq'])) {
                        unlink($diretorio . $linha_up['nome_arq']);
                    }
                    $query_del_up = "delete from upload_dica where id = ".mysqliEscaparTexto($id_upload);
                    mysqli_query($conexao, $query_del_up);
                }
            }
            mysqli_query($conexao, $query);
            for ($i = 0; $i < $numArq; $i++) {
                $extensao = @end(explode('.', $arquivo['name'][$i]));
                $novo_nome = md5(rand()) . $extensao;
                move_uploaded_file($arquivo['tmp_name'][$i], $diretorio . $novo_nome);
                $query = "insert into upload_dica values (default, ".mysqliEscaparTexto($novo_nome).", ".mysqliEscaparTexto($type).", ".mysqliEscaparTexto($id).")";

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
    } else if ($link != null) {
        $url = video_id_from_vimeo_url($link);
        if ($url != false) {
            $type = 'vid';
            $video_url = vimeo_video_url_with_id($url);
        } else {
            $url = video_id_from_youtube_url($link);
            if ($url != false) {
                $type = 'vid';
                $video_url = youtube_video_url_with_id($url);
            } else {
                if (filter_var($link, FILTER_VALIDATE_URL) !== FALSE) {
                    $type = 'url';
                } else {
                    $erro = true;
                }
            }
        }
        if (!$erro && $quantUploads == 0) {
            if ($video && $type == 'vid') {
                $query_vid = "update upload_dica set nome_arq=".mysqliEscaparTexto($video_url).", tipo=".mysqliEscaparTexto($type)." where id=$linha_vid[id] and dica_id= ".mysqliEscaparTexto($id);
            } else if (!$video && $type == 'vid') {
                $query_vid = "insert into upload_dica values (default, ".mysqliEscaparTexto($video_url).", ".mysqliEscaparTexto($type).", ".mysqliEscaparTexto($id).")";
            } else if ($video && $type == 'url') {
                $query_vid = "update upload_dica set nome_arq=".mysqliEscaparTexto($link).", tipo=".mysqliEscaparTexto($type)." where id=$linha_vid[id] and dica_id= ".mysqliEscaparTexto($id);
            } else if (!$video && $type = 'url') {
                $query_vid = "insert into upload_dica values (default, ".mysqliEscaparTexto($link).", ".mysqliEscaparTexto($type).", ".mysqliEscaparTexto($id).")";
            }
            if (!mysqli_query($conexao, $query_vid)) {
                $_SESSION['msg'] = "Dica não alterada! Falha na conexão.";
                header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
            } else {
                if (isset($_POST[id_upload]) && !$video) {
                    foreach ($_POST['id_upload'] as $id_upload) {
                        $query_upload = "select * from upload_dica where id=".mysqliEscaparTexto($id_upload);
                        $resultado = mysqli_query($conexao, $query_upload);
                        $linha_up = mysqli_fetch_array($resultado);
                        if (is_file($diretorio . $linha_up['nome_arq'])) {
                            unlink($diretorio . $linha_up['nome_arq']);
                        }
                        $query_del_up = "delete from upload_dica where id = ".mysqliEscaparTexto($id_upload);
                        mysqli_query($conexao, $query_del_up);
                    }
                }
                if ($type == 'url') {
                    $_SESSION['info'] = 'Formato de vídeo não encontrado! Envio de URL como link.';
                    header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
                } else {
                    header('Location: ' . URL_SITE . 'pagina1.php');
                }
            }
        } else {
            if ($quantUploads !== 0) {
                $_SESSION['msg'] = "Dica não alterada! Dica já possui upload de imagem.";
                header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
            } else {
                $_SESSION['msg'] = "Dica não alterada! URL inválido.";
                header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
            }
        }
    } else {
        if (!trim($dica) && $quantUploads == 0 && $quantUploadsVid == 0) {
            $_SESSION['msg'] = "Dica não alterada! Dica vazia.";
            header('Location: ' . URL_SITE . 'form_alterarDica.php?id=' . $id);
        } else {
            if (isset($_POST[id_upload])) {
                foreach ($_POST['id_upload'] as $id_upload) {
                    $query_upload = "select * from upload_dica where id=".mysqliEscaparTexto($id_upload);
                    $resultado = mysqli_query($conexao, $query_upload);
                    $linha_up = mysqli_fetch_array($resultado);
                    if ($linha_up['type'] == 'img') {
                        if (is_file($diretorio . $linha_up['nome_arq'])) {
                            unlink($diretorio . $linha_up['nome_arq']);
                        }
                    }
                    $query_del_up = "delete from upload_dica where id = ".mysqliEscaparTexto($id_upload);
                    mysqli_query($conexao, $query_del_up);
                }
            }
            mysqli_query($conexao, $query);
            header('Location: ' . URL_SITE . 'pagina1.php');
        }
    }

    /**
     * Fetches the ID of a Vimeo video given a URL
     *
     * @param string $source  Vimeo URL
     *
     * @return mixed          A video ID if matched, otherwise false
     */
    function video_id_from_vimeo_url($source) {
        $pattern = "/^(?:(?:https?:\/\/)?(?:www\.)?vimeo\.com.*\/([\w\-]+))/is";
        $matches = array();
        preg_match($pattern, $source, $matches);
        if (isset($matches[1]))
            return $matches[1];
        return false;
    }

    /**
     * Fetches the ID of a YouTube video given a URL
     *
     * @param string $source  YouTube URL
     *
     * @return mixed          A video ID if matched, otherwise false
     */
    function video_id_from_youtube_url($source) {
        $pattern = '/^(?:(?:(?:https?:)?\/\/)?(?:www\.)?(?:youtu(?:be\.com|\.be))\/(?:watch\?v\=|v\/|embed\/)?([\w\-]+))/is';
        $matches = array();
        preg_match($pattern, $source, $matches);
        if (isset($matches[1]))
            return $matches[1];
        return false;
    }

    /**
     * Generate a URL to a YouTube video with a YouTube video ID
     *
     * @param string $id     YouTube video ID
     * @param array $params  Query params to send to video
     *
     * @return string        A YouTube URL
     */
    function youtube_video_url_with_id($id, array $params = array()) {
        $query = empty($params) ? '' : '?' . http_build_query($params);
        return ("//youtube.com/embed/{$id}{$query}");
    }

    /**
     * Generate a URL to a Vimeo video with a Vimeo video ID
     *
     * @param string $id     Vimeo video ID
     * @param array $params  Query params to send to video
     *
     * @return string        A Vimeo URL
     */
    function vimeo_video_url_with_id($id, array $params = array()) {
        $defaults = array(
            'color' => 'ffffff',
            'title' => 0,
            'byline' => 0,
            'portrait' => 0,
        );
        $params = array_merge($defaults, $params);

        $query = empty($params) ? '' : '?' . http_build_query($params);
        return "//player.vimeo.com/video/{$id}{$query}";
    }

//}