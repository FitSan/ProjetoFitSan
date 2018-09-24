<?php
require_once './autenticacao.php';


ini_set('display_errors', true);
    
$nova_senha = $_POST['nova_senha'];
$repita_senha = $_POST['repita_senha'];

$conutSenha = strlen($nova_senha);//contando os caracteres.

if($nova_senha == $repita_senha && $conutSenha > 8){ 
    
    
$query = "select codigo from usuario";
$resultado_email = mysqli_query($conexao, $query);

    
    while($linha = mysqli_fetch_array($resultado_email)){
    if($linha['codigo']==$codigo){
        $existe = true;
        break;
    }else {
        $existe = false;
    }
}
if($existe == true){

$codigo = $_GET['perfil_codigo'];
  
  $sql = "UPDATE usuario SET senha=$nova_senha WHERE codigo = '$codigo';";

   $retorno = mysqli_query($conexao, $sql);
  
    header('Location: form_login.php');
} else {
    
     $_SESSION['erroCount'] = "Dados nao conferem!";
     
    header('Location: form_recSenha.php');
    
}
  
///header('Location: form_recSenha.php');


} else {
    
         $_SESSION['erroCount'] = "Dados nao conferem!";
     
    header('Location: form_recSenha.php');
}