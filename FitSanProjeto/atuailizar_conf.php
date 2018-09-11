<?php

include './autenticacao.php';
include 'form_conf.php';

ini_set('display_errors', true);

$atu_nome = $_POST['atu_nome'];
$atu_sobnome = $_POST['atu_sobnome'];
$atu_email = $_POST['atu_email'];

$atusenha = $_POST['atusenha'];
$novasenha = $_POST['novasenha'];


$sql = "select senha from usuario where id=$_SESSION[id]";

$retorno = mysqli_query($conexao, $sql);

$linha = mysqli_fetch_array($retorno);

if (empty($atusenha)) {

    $_SESSION['semsenha'] = "Dados nao conferem!";
    header('Location:form_conf.php');
} else {

    if (password_verify($atusenha, $linha['senha'])) {



        $query = "update usuario set nome = '$atu_nome' , sobrenome = '$atu_sobnome', email = '$atu_email' where id=$_SESSION[id]";

        mysqli_query($conexao, $query);



        logar($atu_email, $_SESSION['tipo'], $atu_nome, $_SESSION['id']);

        if (empty($novasenha)) {

            $_SESSION['atualizado'] = "Dados conferem!";
            header('Location:form_conf.php');
        } else {

            if ($atusenha) {
                $senha_hash = password_hash($novasenha, PASSWORD_BCRYPT);
                $query_alt = "update usuario set senha = '$senha_hash' where id=$_SESSION[id]";
                mysqli_query($conexao, $query_alt);
            } else {
                $_SESSION['errosenha'] = "Dados nao conferem!";
                header('Location:form_conf.php');
            }
        }
    } else {
        
    

    $_SESSION['errosenha'] = "Dados nao conferem!";
    header('Location:form_conf.php');
    
    
    }
}