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

  
   
   

function tratar_nome ($nome) {
    $nome = strtolower($nome); // Converter o nome todo para minúsculo
    $nome = explode(" ", $nome); // Separa o nome por espaços
    for ($i=0; $i < count($nome); $i++) {
 
        // Tratar cada palavra do nome
        if ($nome[$i] == "de" or $nome[$i] == "da" or $nome[$i] == "e" or $nome[$i] == "dos" or $nome[$i] == "do") {
            $saida .= $nome[$i].' '; // Se a palavra estiver dentro das complementares mostrar toda em minúsculo
        }else {
            $saida .= ucfirst($nome[$i]).' '; // Se for um nome, mostrar a primeira letra maiúscula
        }
 
    }
    return $saida;
}



$nome = tratar_nome($nome);
$sobrenome = tratar_nome($sobrenome);
//$size = strlen($sobrenome);
//$sobrenome = substr($nome,0, $size-1);
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

$query_usuario = "select email from usuario";

$resultado_usuario = mysqli_query($conexao, $query_usuario);

while($linha = mysqli_fetch_array($resultado_usuario)){
    if($linha['email']==$email){
        $existe = true;
        break;
    }else {
        $existe = false;
    }
}

$conutSenha = strlen($senha);//contando o número de caracteres da senha 

if($conutSenha < 8){
    
            $_SESSION['erroCount'] = "Dados nao conferem!";
            header('Location: form_cadastrar.php');  
    
} else {
    

if($senha != $confsenha){    
            $_SESSION['errosenha'] = "Dados nao conferem!";
            header('Location: form_cadastrar.php');  
} else {

if($existe){
            $_SESSION['erroemail'] = "Dados nao conferem!";
            header('Location: form_cadastrar.php');  
    }else{
        $query = "insert into usuario values (default, '$nome', '$sobrenome', default, default, default, '$senha_hash', '$email', '$tipo_usuario')";

        
        //echo $query;
        
        mysqli_query($conexao, $query);

   header('Location: form_login.php');
            }
    
        
        }


    }