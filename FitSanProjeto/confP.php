<?php
require_once './autenticacao.php';
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$query = "update usuario set nome='$nome', email='$email', senha='$senha' where id=$_SESSION[id]";

mysqli_query($conexao, $query);
logar(['email' => $email, 'tipo' => $_SESSION['tipo'], 'nome' => $nome, 'id' => $_SESSION['id']]);
header('Location: pagina1.php');
