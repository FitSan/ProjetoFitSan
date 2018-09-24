<?php
require_once './autenticacao.php';


ini_set('display_errors', true);
    
$nova_senha = $_POST['nova_senha'];
$repita_senha = $_POST['repita_senha'];
$codigo = $_SESSION['codigo'];


$contSenha = strlen($nova_senha);//contando os caracteres.

if($nova_senha == $repita_senha && $contSenha >= 8){ 
       
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

  $senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);
    
  $sql = "UPDATE usuario SET senha='$senha_hash' WHERE codigo = '$codigo';";

   $retorno = mysqli_query($conexao, $sql);
   
    unset($_SESSION['codigo']);
    
    header('Location: form_login.php');
    exit();
       
} else {
    
     $_SESSION['erroCount'] = "Dados nao conferem!";
     
      unset($_SESSION['codigo']);
    header('Location: form_recSenha.php');
    
}
  
header('Location: form_recSenha.php');


} else {
    
         $_SESSION['erroCount'] = "Dados nao conferem!";

            unset($_SESSION['codigo']);
    header('Location: form_recSenha.php');
}
