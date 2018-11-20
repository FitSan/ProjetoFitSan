<?php

require_once './autenticacao.php';

 
$id = (!empty($_POST['id']) ? $_POST['id'] : null);
$nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
$sobrenome = (!empty($_POST['sobrenome']) ? $_POST['sobrenome'] : null);
//$email = (!empty($_POST['email']) ? $_POST['email'] : null);
$sexo = (!empty($_POST['sexo']) ? $_POST['sexo'] : null);
$datanasc = (!empty($_POST['datanasc']) ? $_POST['datanasc'] : null);
$fotoremover = !empty($_POST['fotoremover']);
$fotosel = (!empty($_POST['foto-sel']) ? $_POST['foto-sel'] : false);


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

$msg = '';
if (!empty($fotosel)){
    $caminho = ($uploaddir . $fotosel); // Monta o endereço da imagem
    $temp = ($tempdir . $fotosel); // Monta o endereço da imagem
    $foto = ($uploadurl . $fotosel);
    if (!@is_readable($temp)) $msg = 'Upload não encontrado'; // Para se não foi encontrado o arquivo temporário
    copy($temp, $caminho) or $msg = 'Upload não copiado'; // Move o arquivo enviado para a pasta de uploads
} elseif (!empty($_FILES['foto']['name'])){
    $arquivo = strtolower(preg_replace('{[^a-z0-9_\-\.]+}i', '_', $_FILES['foto']['name'])); // Limpa o nome da imagem removendo caracteres não permitidos
    $caminho = ($uploaddir . $arquivo); // Monta o endereço da imagem
    $foto = ($uploadurl . $arquivo);
    if (!empty($_FILES['foto']['error'])) $msg = 'Erro ao fazer upload'; // Para se deu erro no envio do arquivo
    if (empty($_FILES['foto']['tmp_name'])) $msg = 'Upload não enviado'; // Para se não foi encontrado o arquivo temporário
    $tamanho = getimagesize($_FILES['foto']['tmp_name']);    
    if (abs($tamanho[0]-$tamanho[1])>20) $msg = 'Envie uma imagem de dimensões quadradas para sua foto de perfil.';
    if (!@is_readable($_FILES['foto']['tmp_name'])) $msg = 'Upload não encontrado'; // Para se não foi encontrado o arquivo temporário
    move_uploaded_file($_FILES['foto']['tmp_name'], $caminho) or $msg = 'Upload não copiado'; // Move o arquivo enviado para a pasta de uploads
} elseif ($fotoremover){
    $foto = null;
    $sql = "select usuario.* from usuario where id = '$_SESSION[id]'";
    if ($retorno = mysqli_query($conexao, $sql)){
        if ($resultado = mysqli_fetch_array($retorno)){
            if ($url = $resultado['foto']){
                $file = (rtrim(dirname(__FILE__), '\\/') . '/uploads/' . basename($url));
                if (!@file_exists($file)){
                    $foto = false;
                } elseif (@unlink($file)){
                    $foto = false;
                }
            }
        }
    }
} else {
    $foto = null;
}

if(!empty($msg)){
    $_SESSION['erro'] = $msg;
    header('Location: '.URL_SITE.'form_perfil.php');
}else{
    $query_perfil = "update usuario set nome = ".mysqliEscaparTexto($nome).", sobrenome = ".mysqliEscaparTexto($sobrenome).", sexo = ".mysqliEscaparTexto($sexo).", datanasc = ".mysqliEscaparTexto($datanasc, 'date');
    if ($foto !== null){
        if ($foto) $query_perfil .= ", foto = ".mysqliEscaparTexto($foto);
        else $query_perfil .= ", foto = NULL";
    }
    $query_perfil .= " where id = $_SESSION[id]";
    mysqli_query($conexao, $query_perfil) or die_mysql($query_perfil, __FILE__, __LINE__);

    $logar = array(
        'nome' => $nome,
        'sobrenome' => $sobrenome,
        'sexo' => $sexo,
        'datanasc' => $datanasc,
    );
    if ($foto !== null) $logar['foto'] = $foto;
    logar($logar);

    header('Location: '.URL_SITE.'perfil.php');
}
// Para dar permissão nas pastas do site pelo linux:
// Abra um terminal e acesse a pasta
//  # cd /var/www/html/FitSan
// Digite o comando:
//  # sudo chown -Rc karen:karen ./
//  # find \( -type f -printf 'chmod -c 666 %p\n' \) -or \( -type d -printf 'chmod -c 777 %p\n' \) | sudo bash

