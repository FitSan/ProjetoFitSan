<?php
$pagina = 'Minhas Dicas';

require_once './template/cabecalho.php';

$query = "select * from dica where profissional_id=$_SESSION[id] order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
?>
<div class="container">
    <h1 style="padding: 10px"><?=$pagina?></h1>
    <br><br><a href='envio_dica.php'><input type="button" class="btn-info" value="Nova dica"></a>
    <table cellpadding="5">    
    <?php
    while ($linha = mysqli_fetch_array($resultado)){
        ?>
            <tr>
                <td style="width: 500px; height: 70px"><?= $linha['texto'] ?></td>
                <td style="width: 100px; height: 70px"><?= $linha['data_envio'] ?></td> 
                <td><button type="button" class="btn btn-light" data-toggle="modal" data-target="#editar-dica" data-id="<?= $linha['id'] ?>" data-data="<?= $linha['data_envio'] ?>" data-texto="<?= $linha['texto'] ?>"><img src="img/editarDica.png" height="30"></button></td>
                <td><button type="button" class="btn btn-light" data-toggle="modal" data-target="#excluir-dica" data-id="<?= $linha['id'] ?>"><img src="img/excluirDica.png" height="30"></button></td>
            </tr>
                <?php
            }
            ?>
    </table>
    
    
<!--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>-->
    
</div>
	

<?php

include './template/rodape_especial.php';

