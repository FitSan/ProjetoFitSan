<?php
require_once './autenticacao.php';

$now = new DateTime();
$data_envio = $now->format('Y-m-d H:i:s');

$dica = $_POST['dica'];
$titulo = (!empty($_POST['titulo']) ? $_POST['titulo'] : null);
$link = (!empty($_POST['link_video']) ? $_POST['link_video'] : null);

$msg = '';


$uploaddir = '/uploads/dicas/';
$dir = (rtrim(dirname(__FILE__), '\\/') . $uploaddir); // Obtém a pasta do arquivo do site
if (!@is_writable($dir))
    mkdir($dir, 0777, true); // Cria a pasta de uploads se não existir

if ($_FILES['imagens']['size'][0] != 0 && $link != null) {
    $_SESSION['msg'] = "Dica não enviada! Escolha apenas um tipo de upload.";
    header('Location: ' . URL_SITE . 'minhas_dicas.php');
} else if ($_FILES['imagens']['size'][0] != 0) {
    $arquivo = $_FILES['imagens'];
    $numArq = count(array_filter($arquivo['name']));

    $type = 'img';

    $permite = array('image/jpeg', 'image/png');
    $maxSize = 1024 * 1024 * 5; //2 megabytes
    $maxNum = 6; //6 imagens permitidas OPINIÕES

    $arqSize = $maxSize * $numArq;

    for ($i = 0; $i < $numArq; $i++) {
        if ($arquivo['error'][$i] != 0 || !in_array($arquivo['type'][$i], $permite) || $arquivo['size'][$i] > $maxSize || $numArq > $maxNum) {
            $Error = true;
            $iError = $i;
            break;
        } else {
            $Error = false;
        }
    }

    if (!$Error) {
        $query = "insert into dica values (default, '$dica', '$titulo', '" . exibirName(true) . "', $_SESSION[id], '$data_envio')";
        mysqli_query($conexao, $query);
        $dica_id = mysqli_insert_id($conexao);
        for ($i = 0; $i < $numArq; $i++) {
            $extensao = @end(explode('.', $arquivo['name'][$i]));
            $novo_nome = md5(rand()) . $extensao;
            move_uploaded_file($arquivo['tmp_name'][$i], $dir . $novo_nome);
            $query = "insert into upload_dica values (default, '$novo_nome', '$type', $dica_id)";

            if (!mysqli_query($conexao, $query)) {
                $_SESSION['msg'] = "Envio não realizado! Falha na conexão.";
                header('Location: ' . URL_SITE . 'minhas_dicas.php');
            } else {
                header('Location: ' . URL_SITE . 'pagina1.php');
            }
        }
    } else {
        if ($numArq > $maxNum) {
            $msg = "Envio não realizado! Muitos arquivos selecionados, máximo " . $maxNum . ".";
        } else if (!in_array($arquivo['type'][$iError], $permite)) {
            $msg = "Envio não realizado! Arquivo " . $arquivo['name'][$iError] . " possui tipo de arquivo não permitido.";
        } else if ($arquivo['size'][$iError] > $maxSize) {
            $msg = "Envio não realizado! Tamanho do arquivo " . $arquivo['name'][$iError] . " excede limite de 2MB.";
        } else {
            $msg = "Envio não realizado! Erro no upload.";
        }
        $_SESSION['msg'] = $msg;
        header('Location: ' . URL_SITE . 'minhas_dicas.php');
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
            if(filter_var($link, FILTER_VALIDATE_URL) !== FALSE) {
                $type = 'url';
            } else {
                $erro = true;
            }            
        }
    }
    if(!$erro){
    $query = "insert into dica values (default, '$dica', '$titulo', '" . exibirName(true) . "', $_SESSION[id], '$data_envio')";
    mysqli_query($conexao, $query);
    $dica_id = mysqli_insert_id($conexao);
    if($type=='url'){
        $query_link = "insert into upload_dica values (default, '$link', '$type', $dica_id)";
    }else{
        $query_link = "insert into upload_dica values (default, '$video_url', '$type', $dica_id)";
    }
    if (!mysqli_query($conexao, $query_link)) {
        $_SESSION['msg'] = "Envio não realizado! Falha na conexão.";
        header('Location: ' . URL_SITE . 'minhas_dicas.php');
    } else {
        if ($type == 'url') {
            $_SESSION['info'] = 'Formato de vídeo não encontrado! Envio de URL como link.';
            header('Location: ' . URL_SITE . 'minhas_dicas.php');
        } else {
            header('Location: ' . URL_SITE . 'pagina1.php');
        }
    }
    }else{
        $_SESSION['msg'] = 'Erro! URL inválido.';
        header('Location: ' . URL_SITE . 'minhas_dicas.php');
    }
} else {
    if (!trim($dica)) {
        $_SESSION['msg'] = "Envio não realizado! Dica vazia.";
        header('Location: ' . URL_SITE . 'minhas_dicas.php');
    } else {
        $query = "insert into dica values (default, '$dica', '$titulo', '" . exibirName(true) . "', $_SESSION[id], '$data_envio')";
        if (!mysqli_query($conexao, $query)) {
            $_SESSION['msg'] = "Envio não realizado! Falha na conexão.";
            header('Location: ' . URL_SITE . 'minhas_dicas.php');
        } else {
            header('Location: ' . URL_SITE . 'pagina1.php');
        }
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
