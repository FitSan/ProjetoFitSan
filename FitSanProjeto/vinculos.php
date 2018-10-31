<?php
$tipo = $_GET['tipo'];
if ($tipo == 'aluno') {
    $pagina = "Profissionais";
} else {
    $pagina = "Alunos";
}
require_once './template/cabecalho.php';

//$pagina = "Vínculos";


if ($tipo == 'aluno') {
//    $pagina = "Profissionais";
    $query = "select * from usuario join vinculo on usuario.id=vinculo.profissional_id where vinculo.status = 'aprovado' and usuario.status = 'ativado' and vinculo.aluno_id=$_SESSION[id]";
} else {
//    $pagina = "Alunos";
    $query = "select * from usuario join vinculo on usuario.id=vinculo.aluno_id where vinculo.status = 'aprovado' and usuario.status = 'ativado' and profissional_id=$_SESSION[id]";
}

$resultado = mysqli_query($conexao, $query);
$resultados = mysqli_num_rows($resultado);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $pagina ?></h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Meus <?= $pagina ?></h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table id="meus" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            
                            <th>Nome</th> 
                            <th>E-mail</th>                                
                            <th>Status</th>                         
                        </tr>  
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_array($resultado)) {
                            ?>
                            <tr>
                                
                                <td style="width: 300px"> <a href="<?=URL_SITE?>perfil_externo.php?id=<?= $linha['id'] ?>"><?= $linha['nome'] . ' ' . $linha['sobrenome'] ?></td>
                                <td style="width: 300px"><?= $linha['email'] ?></td>
                                <?php
                                if ($linha[$usuario_busca] == $_SESSION['id']) {
                                    ?>
                                    <td style="width: 100px"><a href="<?=URL_SITE?>desvincular.php?id=<?= $linha['id'] ?>"><span class="label label-danger">Deixar de seguir</span></a></td>               
                                    <?php
                                } elseif ($linha['status'] === 'aprovado') {
                                    ?>
                                    <td style="width: 100px"><a href="<?=URL_SITE?>desvincular.php?id=<?= $linha['id'] ?>"><span class="label label-danger">Deixar de seguir</span></a></td>                
                                    <?php
                                } elseif ($linha['status'] === 'espera') {
                                    if (tipoLogado($linha['solicitante'])) {
                                        ?>
                                        <td style="width: 100px"><span class="label label-warning">Aguardando...</span></td>                
                                        <?php
                                    } else {
                                        ?>
                                        <td style="width: 100px"><a href="<?=URL_SITE?>status_vinculo.php?id=<?= $linha['id'] ?>&status=aprovado"><span class="label label-success">Aceitar</span></a> <a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=negado"><span class="label label-danger">Negar</span></a></td>                
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <td style="width: 100px"><a href="<?=URL_SITE?>vincular.php?id=<?= $linha['id'] ?>"><span class="label label-primary">Seguir</span></a></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <?php
                if ($resultados == 0) {
                    if (tipoLogado('aluno')){
                        echo '<h3 class="text-center">Seus profissionais aparecerão aqui!</h3>';
                    } else {
                        echo '<h3 class="text-center">Seus alunos aparecerão aqui!</h3>';
                    }
                }
                ?>
            </div>
        </div>
    </section>
</div>
<?php
include './template/rodape_especial.php';
