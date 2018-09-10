<?php
require_once './autenticacao.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$dica = $_POST['dica'];
$data_envio = $_POST['envio'];



if(!trim($dica)){
    ?>
        <script>
            alert('Digite sua dica!');
            window.location.href='envio_dica.php';
        </script>
       <?php
}else{    
    $query = "insert into dica values (default, '$dica', '$data_envio', '$nome', $id)";
    mysqli_query($conexao, $query);
    header('Location: pagina1.php');
}
