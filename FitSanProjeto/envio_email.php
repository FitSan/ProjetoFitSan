
<?php
ini_set('display_errors',true);
include './bancodedados/conectar.php';
include './autenticacao.php';

$email = $_POST['email'];

$query = "select email from usuario";
$resultado_email = mysqli_query($conexao, $query);

while($linha = mysqli_fetch_array($resultado_email)){
    if($linha['email']==$email){
        $existe = true;
        break;
    }else {
        $existe = false;
    }
}
if($existe == FALSE){
    
    $_SESSION['erroEmail'] = "Dados nao conferem!";
    header('Location: form_recEmail.php'); 
    
} else {
   
    $email_para = $email ;
    $assunto = "Recuperando senha FitSan";
    $link_email =  ' <a href="#####">Crie sua nova senha</a>' ;/// link que vai para o email do usuario. 
                                                             /// O link irá encaminhar o usuario para uma página onde o mesmo poderá cadastrar uma senha nova.
    $header = "MIME-Version: 1.0\n";
    $header .= "Content-type: text/html; charset-iso-8859-1\n";
    $header .= "From: $email\n";
    
    mail($email_para, $assunto, $link_email, $header);
    

    
    $_SESSION['sucesso'] = "Dados conferem!";
    
    header('Location: form_recEmail.php'); 
    
    
//(Estava pensando em mostrar a senha do usuário em seu email porém n sei se dá para descriptografar a senha hash para mandar para o eamil do usuario)
//
//   $sql = "select usuario.senha from usuario where email = '$email'";
//   $retorno_senha = mysqli_query($conexao, $sql);
//   $resultado_senha = mysqli_fetch_array($retorno_senha);
    
    
}