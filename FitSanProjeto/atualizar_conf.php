<?php
include './autenticacao.php';

if (!tipoLogado("admin")){
$atu_email = (!empty($_POST['novo_email']) ? $_POST['novo_email'] : null);
}

$senha = (!empty($_POST['insira_senha']) ? $_POST['insira_senha'] : null);
$repita_senha = (!empty($_POST['repita_senha']) ? $_POST['repita_senha'] : null);
$nova_senha = (!empty($_POST['nova_senha']) ? $_POST['nova_senha'] : null);



$sql = "select senha from usuario where id=$_SESSION[id]";
$retorno = mysqli_query($conexao, $sql);

$linha = mysqli_fetch_array($retorno);

   if (password_verify($senha, $linha['senha'])) {


    if (!tipoLogado("admin")){
        $query = "update usuario set email = '$atu_email' where id=$_SESSION[id]";
      mysqli_query($conexao, $query);
    }


  logar($atu_email, $_SESSION['tipo'] , $atu_nome, $_SESSION['id']) ;

        if (empty($nova_senha && $repita_senha)) {
            $_SESSION['atualizado'] = "Dados conferem!";
            header('Location:'.URL_SITE.'form_conf.php');
        } else {

            if ($nova_senha == $repita_senha) {
                $senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);
                $query_alt = "update usuario set senha = '$senha_hash' where id=$_SESSION[id]";
                mysqli_query($conexao, $query_alt);
                header('Location:'.URL_SITE.'form_login.php');
            } else {
                $_SESSION['diver_senha'] = "Dados nao conferem!";
                header('Location:'.URL_SITE.'form_conf.php');
            }
        }
    } else {

        $_SESSION['errosenha'] = "Dados nao conferem!";
        header('Location:'.URL_SITE.'form_conf.php');
    }
