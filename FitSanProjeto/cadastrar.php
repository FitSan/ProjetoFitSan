<?php

require_once './autenticacao.php';
include './bancodedados/conectar.php';

$nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
$sobrenome = (!empty($_POST['sobrenome']) ? $_POST['sobrenome'] : null);
$datanasc = (!empty($_POST['dataNasc']) ? $_POST['dataNasc'] : null);
$sexo = (!empty($_POST['sexo']) ? $_POST['sexo'] : null);
$foto = (!empty($_POST['foto']) ? $_POST['foto'] : null);
$email = (!empty($_POST['email']) ? $_POST['email'] : null);
$senha = (!empty($_POST['senha']) ? $_POST['senha'] : null);
$confsenha = (!empty($_POST['confsenha']) ? $_POST['confsenha'] : null);
$tipo_usuario = (!empty($_POST['tipo_id']) ? $_POST['tipo_id'] : null);

function tratar_nome($nome) {
    $nome = strtolower($nome); // Converter o nome todo para minúsculo
    $nome = explode(" ", $nome); // Separa o nome por espaços
    for ($i = 0; $i < count($nome); $i++) {

        // Tratar cada palavra do nome
        if ($nome[$i] == "de" or $nome[$i] == "da" or $nome[$i] == "e" or $nome[$i] == "dos" or $nome[$i] == "do") {
            $saida .= $nome[$i] . ' '; // Se a palavra estiver dentro das complementares mostrar toda em minúsculo
        } else {
            $saida .= ucfirst($nome[$i]) . ' '; // Se for um nome, mostrar a primeira letra maiúscula
        }
    }
    return $saida;
}

$nome = tratar_nome($nome);
$sobrenome = tratar_nome($sobrenome);
$size = strlen($nome);
$nome = substr($nome,0, $size-1);
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

$query_usuario = "select email from usuario";

$resultado_usuario = mysqli_query($conexao, $query_usuario);

while ($linha = mysqli_fetch_array($resultado_usuario)) {
    if ($linha['email'] == $email) {
        $existe = true;
        break;
    } else {
        $existe = false;
    }
}

$contEmail = strlen($email); //contando o número de caracteres da email 
$contSenha = strlen($senha); //contando o número de caracteres da senha 


if ($contSenha < 8) {

    $_SESSION['erroCount'] = "Dados nao conferem!";
    $_SESSION['erro_nome'] = "$nome";
    $_SESSION['erro_sobrenome'] = "$sobrenome ";
    $_SESSION['erro_email'] = "$email ";
    $_SESSION['erro_tipo_usuario'] = "$tipo_usuario ";

    header('Location: form_cadastrar.php');
} else {


    if ($senha != $confsenha) {
        $_SESSION['errosenha'] = "Dados nao conferem!";
        $_SESSION['erro_nome'] = "$nome";
        $_SESSION['erro_sobrenome'] = "$sobrenome ";
        $_SESSION['erro_email'] = "$email ";
        $_SESSION['erro_tipo_usuario'] = "$tipo_usuario ";

        header('Location: form_cadastrar.php');
    } else {

        if ($existe || $contEmail == null) {
            $_SESSION['erroemail'] = "Dados nao conferem!";
            $_SESSION['erro_nome'] = "$nome ";
            $_SESSION['erro_sobrenome'] = "$sobrenome ";
            $_SESSION['erro_senha'] = "$senha ";
             $_SESSION['erro_confsenha'] = "$confsenha ";
             $_SESSION['erro_tipo_usuario'] = "$tipo_usuario ";



            header('Location: form_cadastrar.php');
        } else {
            $query = "insert into usuario (nome, sobrenome, senha, email, tipo_id) values ('$nome', '$sobrenome', '$senha_hash', '$email', '$tipo_usuario')";


            //echo $query;

            mysqli_query($conexao, $query);

            header('Location: form_login.php');
        }
    }
}
