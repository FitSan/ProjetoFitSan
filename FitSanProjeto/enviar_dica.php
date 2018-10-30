<?php
date_default_timezone_set('America/Sao_Paulo');

require_once './autenticacao.php';

$now = new DateTime();
$data_envio = $now->format('Y-m-d H:i:s');

$dica = $_POST['dica'];

$msg = '';
$diretorio = "upload/dica/";
if($_FILES['imagens']['size'][0] != 0&&$_FILES['video']['size']!=0){
    $_SESSION['msg'] = "Dica não alterada! Escolha apenas um tipo de upload.";
    header('Location: '.URL_SITE.'minhas_dicas.php');
}else if ($_FILES['imagens']['size'][0] != 0) {
    $arquivo = $_FILES['imagens'];
    $numArq = count(array_filter($arquivo['name']));

    $type = 'img';

    $permite = array('image/jpeg', 'image/png');
    $maxSize = 1024 * 1024 * 2; //2 megabytes
    $maxNum = 6; //6 imagens permitidas OPINIÕES
    
    $arqSize = $maxSize * $numArq;
    
    for ($i = 0; $i < $numArq; $i++) {
        if ($arquivo['error'][$i] != 0 || !in_array($arquivo['type'][$i], $permite) || $arquivo['size'][$i] > $maxSize || $numArq>$maxNum) {
            $Error = true;
            $iError = $i;
            break;
        } else {
            $Error = false;            
        }
    }

    if (!$Error) {
        $query = "insert into dica values (default, '$dica', '$_SESSION[nome]', $_SESSION[id], '$data_envio')";
        mysqli_query($conexao, $query);
        $dica_id = mysqli_insert_id($conexao);
        for ($i = 0; $i < $numArq; $i++) {
            $extensao = @end(explode('.', $arquivo['name'][$i]));
            $novo_nome = md5(rand()) . $extensao;
            move_uploaded_file($arquivo['tmp_name'][$i], $diretorio . $novo_nome);
            $query = "insert into upload_dica values (default, '$novo_nome', '$type', $dica_id)";

            if (!mysqli_query($conexao, $query)) {
                $_SESSION['msg'] = "Envio não realizado! Falha na conexão.";
                header('Location: '.URL_SITE.'minhas_dicas.php');
            } else {
                header('Location: '.URL_SITE.'pagina1.php');
            }
        }
    } else{
        if($numArq>$maxNum){
            $msg = "Envio não realizado! Muitos arquivos selecionados, máximo ".$maxNum.".";            
        }else if(!in_array($arquivo['type'][$iError], $permite)){    
            $msg = "Envio não realizado! Arquivo ".$arquivo['name'][$iError]. " possui tipo de arquivo não permitido.";            
        }else if($arquivo['size'][$iError] > $maxSize){
            $msg = "Envio não realizado! Tamanho do arquivo ".$arquivo['name'][$iError]. " excede limite de 2MB.";            
        }else{
            $msg = "Envio não realizado! Erro no upload.";
        }
        $_SESSION['msg'] = $msg;
        header('Location: '.URL_SITE.'minhas_dicas.php');
    }
} else if ($_FILES['video']['size']!=0) {
    $arquivo = $_FILES['video'];
    $type = 'vid';
    $permite = array('video/mp4', 'video/avi'); //MAIS ALGUM
    $maxSize = 1024 * 1024 * 15; //15 megabytes

    if ($arquivo['error'] == 0 && in_array($arquivo['type'], $permite) && $arquivo['size'] <= $maxSize) {
        $query = "insert into dica values (default, '$dica', '$_SESSION[nome]', $_SESSION[id], '$data_envio')";
        mysqli_query($conexao, $query);
        $dica_id = mysqli_insert_id($conexao);
        $extensao = @end(explode('.', $arquivo['name']));
        $novo_nome = md5(rand()) . $extensao;

        move_uploaded_file($arquivo['tmp_name'], $diretorio . $novo_nome);
        $query = "insert into upload_dica values (default, '$novo_nome', '$type', $dica_id)";

        if (!mysqli_query($conexao, $query)) {
            $_SESSION['msg'] = "Envio não realizado! Falha na conexão.";
            header('Location: '.URL_SITE.'minhas_dicas.php');
        } else {
            header('Location: '.URL_SITE.'pagina1.php');
        }
    } else {
        if(!in_array($arquivo['type'], $permite)){    
            $msg = "Envio não realizado! Vídeo ".$arquivo['name']. " possui tipo de arquivo não permitido.";
           
        }else if($arquivo['size'] > $maxSize){
            $msg = "Envio não realizado! Tamanho do arquivo ".$arquivo['name']. " excede limite de 15MB.";
            
        }else{
            $msg = "Envio não realizado! Erro no upload do vídeo.";
        }
        $_SESSION['msg'] = $msg;
        header('Location: '.URL_SITE.'minhas_dicas.php');
    }
} else {
    if (!trim($dica)) {
        $_SESSION['msg'] = "Envio não realizado! Dica vazia.";
        header('Location: '.URL_SITE.'minhas_dicas.php');
    } else {
        $query = "insert into dica values (default, '$dica', '$_SESSION[nome]', $_SESSION[id], '$data_envio')";
        mysqli_query($conexao, $query);
        header('Location: '.URL_SITE.'pagina1.php');
    }
}
