<?php
date_default_timezone_set('America/Sao_Paulo');
require_once 'autenticacao.php';

$id = mysqli_escape_string($conexao, $_POST['id']); //escape de caracteres estranhos dentro do id mudar todos que tenham post ou get.
$dica = $_POST['texto'];
//$data_envio = $_POST['data_envio'];
$now = new DateTime();
$data_envio = $now->format('d-m-Y H:i:s');


if(!trim($dica)){
    ?>
        <script>
            alert('Dica não alterada!');
            window.location.href='minhas_dicas.php';
        </script>
       <?php
}else{    
    $query = "update dica set texto='$dica', data_envio='$data_envio', profissional_nome='$_SESSION[nome]', profissional_id=$_SESSION[id] where id=$id";
    mysqli_query($conexao, $query);
    header('Location: pagina1.php');
}
