<?php
require_once './autenticacao.php';

$nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
$sobrenome = (!empty($_POST['sobrenome']) ? $_POST['sobrenome'] : null);
$datanasc = (!empty($_POST['dataNasc']) ? $_POST['dataNasc'] : null);
$sexo = (!empty($_POST['sexo']) ? $_POST['sexo'] : null);
$email = (!empty($_POST['email']) ? $_POST['email'] : null);
$senha = (!empty($_POST['senha']) ? $_POST['senha'] : null);
$confSenha = (!empty($_POST['confSenha']) ? $_POST['confSenha'] : null);
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
$resultado_usuario = mysqli_query($conexao, $query_usuario) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query_usuario.PHP_EOL.print_r(debug_backtrace(), true));

while($linha = mysqli_fetch_array($resultado_usuario)){
    if($linha['email']==$email){
        $existe = true;
        break;
    }else {
        $existe = false;
    }
}

if ($senha != $confSenha) {
           ?>
        <script>
            alert('Senhas Divergentes');
            window.location.href='form_cadastrar.php';
        </script>
       <?php
    
} else {
    

    
if($existe){
       ?>
        <script>
            alert('E-mail ja cadastrado!');
            window.location.href='form_cadastrar.php';
        </script>
       <?php
    }else{
        $query = "insert into usuario (id, nome, sobrenome, datanasc, sexo, senha, email, tipo_id) values (default, " . mysqliEscaparTexto($nome) . "," . mysqliEscaparTexto($sobrenome) . "," . mysqliEscaparTexto($datanasc, 'date') . "," . mysqliEscaparTexto($sexo) . "," . mysqliEscaparTexto($senha_hash) . ", " . mysqliEscaparTexto($email) . ", " . mysqliEscaparTexto($tipo_usuario) . ")";
        mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));

        header('Location: form_login.php');
    }
    
    }