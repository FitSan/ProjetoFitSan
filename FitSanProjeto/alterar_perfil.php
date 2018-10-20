<?php

require_once './autenticacao.php';

 
$id = (!empty($_POST['id']) ? $_POST['id'] : null);
$nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
$sobrenome = (!empty($_POST['sobrenome']) ? $_POST['sobrenome'] : null);
//$email = (!empty($_POST['email']) ? $_POST['email'] : null);
$sexo = (!empty($_POST['sexo']) ? $_POST['sexo'] : null);
$datanasc = (!empty($_POST['datanasc']) ? $_POST['datanasc'] : null);
$fotoremover = (!empty($_POST['fotoremover']) ? !empty($_POST['fotoremover']) : false);

if (!empty($_FILES['foto']['name'])){
    $uploaddir = '/uploads/';
    $dir = (rtrim(dirname(__FILE__), '\\/') . $uploaddir); // Obtém a pasta do arquivo do site
    if (!@is_writable($dir)) mkdir($dir, 0777, true); // Cria a pasta de uploads se não existir
    $arquivo = strtolower(preg_replace('{[^a-z0-9_\-\.]+}i', '_', $_FILES['foto']['name'])); // Limpa o nome da imagem removendo caracteres não permitidos
    $caminho = ($dir . $arquivo); // Monta o endereço da imagem
    $foto = ( // Monta a url da imagem
        'http' .
        ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 's' : '') .
        '://' .
        $_SERVER['HTTP_HOST'] .
        rtrim(dirname($_SERVER['REQUEST_URI']), '\\/')  .
        $uploaddir . $arquivo
    );
    if (!empty($_FILES['foto']['error'])) die('Erro ao fazer upload'); // Para se deu erro no envio do arquivo
    if (empty($_FILES['foto']['tmp_name'])) die('Upload não enviado'); // Para se não foi encontrado o arquivo temporário
    if (!@is_readable($_FILES['foto']['tmp_name'])) die('Upload não encontrado'); // Para se não foi encontrado o arquivo temporário
    move_uploaded_file($_FILES['foto']['tmp_name'], $caminho) or die('Upload não copiado'); // Move o arquivo enviado para a pasta de uploads
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

header('Location: perfil.php');

// Para dar permissão nas pastas do site pelo linux:
// Abra um terminal e acesse a pasta
//  # cd /var/www/html/FitSan
// Digite o comando:
//  # sudo chown -Rc karen:karen ./
//  # find \( -type f -printf 'chmod -c 666 %p\n' \) -or \( -type d -printf 'chmod -c 777 %p\n' \) | sudo bash

