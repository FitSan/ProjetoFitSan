<?php
include './autenticacao.php'; 
ini_set('display_errors', true);

                    $email = $_GET['perfil_email'];

                    $_SESSION['codigo'] = $email;

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
if(  $existe = true){
    
    $query="update usuario set status='ativado' where email ='$email'";
     mysqli_query($conexao, $query);
     header('Location: ' . URL_SITE . 'form_login.php');
}

?>
