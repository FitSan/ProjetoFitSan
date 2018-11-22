<?php
$pagina = " Avaliações ";
require_once './template/cabecalho.php';
require_once './template/menu.php';


$id_avaliacao = $_GET['id_avaliacao'];
$nome_aluno = $_GET['nome_aluno'];
$sobrenome_aluno = $_GET['sobrenome_aluno'];

$query = "select * from `avaliacao` where id= $id_avaliacao";
$resultado = mysqli_query($conexao, $query);
$linha = (mysqli_fetch_array($resultado));

if (tipoLogado("profissional")) {

$query_verificar = "select * from avaliacao where id=".$id_avaliacao." and profissional_id=".$_SESSION['id'];
$resultado_verificar = mysqli_query($conexao, $query_verificar);

if(mysqli_num_rows($resultado_verificar)==0){
   
    header('Location: ' . URL_SITE . 'pagina1.php');
}
}

if (tipoLogado("aluno")) {

$query_verificar = "select * from avaliacao where id=".$id_avaliacao." and aluno_id=".$_SESSION['id'];
$resultado_verificar = mysqli_query($conexao, $query_verificar);

if(mysqli_num_rows($resultado_verificar)==0){
   
    header('Location: ' . URL_SITE . 'pagina1.php');
}
}




if (tipoLogado("aluno")) {
    $lendo = "update avaliacao set status='lido' where id=$id_avaliacao";
    $consequência = mysqli_query($conexao, $lendo);
}
?>
<style>

</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Avaliação do aluno <strong><?php echo $nome_aluno;
echo $sobrenome_aluno; ?></strong></h1>
<?php if (tipoLogado("profissional")) { ?>

                <a  href="<?= URL_SITE ?>form_historico_avaliacao_profissional.php" >  
                        <button  type="button" class="btn btn-primary btn-flat"> Voltar </button>
                    </a>
<?php }
        if (tipoLogado("aluno")) {
                    ?>

                    <a href="<?= URL_SITE ?>historico.php">  
                        <button type="button" class="btn btn-primary btn-flat"> Voltar </button>
                    </a>

                    <?php
                }
?>
    </section>
    <section class="content">
        <form method="post" action="">

            <div class="box box-primary" align="center">
<?php if (tipoLogado("profissional")) { ?>



                <a href="<?= URL_SITE ?>alterar_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>">  
                        <button type="button" class="btn btn-primary btn-flat"> Alterar </button>
                    </a>

                    <a  href="<?= URL_SITE ?>excluir_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>">  
                        <button type="button" class="btn btn-primary btn-flat"> Excluir </button>
                    </a>

                    <?php
                }
                
                if ($linha[desempenho] == null && $linha[frequencia] == null && $linha[grupo_cumpriu] == null && $linha[grupo_duvida] == null && $linha[grupo_dificuldade] == null && $linha[consideracoes] == null) {
                    
                } else {
                    ?>
                    <div class="nav-tabs-custom"  >
                        <h2>Avaliação da Performance</h2>
                        <div class="box-body">           
                            <div>
                                <?php
                                if ($linha[desempenho] != null) {
                                    ?>
                                    <br>Desempenho do aluno com as atividades <font color="red" ><h5><?= $linha[desempenho] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[frequencia] != null) {
                                    ?>
                                    <br>Frequência do aluno com as atividades <font color="red" ><h5><?= $linha[frequencia] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[grupo_cumpriu] != null) {
                                    ?>
                                    <br>Cumpriu com os objetivos estipulados? <font color="red" ><h5><?= $linha[grupo_cumpriu] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[grupo_duvida] != null) {
                                    ?> 
                                    <br>O aluno tira dúvida com o professor? <font color="red" ><h5><?= $linha[grupo_duvida] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[grupo_dificuldade] == 'Sim') {
                                    ?>
                                    <br>Dificuldade apresentada em uma determinada atividade. <font color="red" ><h5> <?= $linha[caso_sim] ?></h5></font> 

                                <?php } ?>

                                <?php
                                $consi = $linha[consideracoes];
                                if (strlen($consi) != null) {
                                    ?>
                                    <br> <strong>Considerações gerais</strong> <font color="red" ><h5><textarea name="consideracoes_corporal"   cols="50" rows="3" disabled  ><?= $linha[consideracoes] ?></textarea></h5></font>
                                <?php } ?>

                            </div>

                        </div>
                    </div>

                    <?php
                }
                if ($linha[musculatura] == null && $linha[lesao] == null && $linha[queimacao] == null && $linha[caimbras] == null && $linha[tontura] == null && $linha[consideracoes_corporal] == null) {
                    
                } else {
                    ?>
                    <div class="nav-tabs-custom"  >
                        <h2>Avaliação Corporal</h2>
                        <div class="box-body">           
                            <div >
    <?php
    if ($linha[musculatura] != null) {
        ?>
                                    <br>O aluno desenvolveu musculatura ?<font color="red" ><h5><?= $linha[musculatura] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[lesao] != null) {
                                    ?>
                                    <br>O aluno sofreu alguma lesão? <font color="red" ><h5><?= $linha[lesao] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[queimacao] != null) {
                                    ?>
                                    <br>
                                    O aluno já sentiu queimação? <font color="red" ><h5><?= $linha[queimacao] ?></h5></font> 
    <?php } ?>
                                <?php
                                if ($linha[caimbras] != null) {
                                    ?> 
                                    <br>O aluno já sentiu caimbras? <font color="red" ><h5><?= $linha[caimbras] ?></h5></font> 
                                <?php } ?>
                                <?php
                                if ($linha[tontura] != null) {
                                    ?> 
                                    <br>O aluno perdeu seu equilíbrio por causa de tontura? <font color="red" ><h5><?= $linha[tontura] ?></h5></font> 
                                <?php } ?>
                                <?php
                                $conside = $linha[consideracoes_corporal];

                                if (strlen($conside) != null) {
                                    ?>
                                    <br> <strong>Considerações gerais</strong> <font color="red" ><h5><textarea   name="consideracoes_corporal"   cols="50" rows="3" disabled ><?= $linha[consideracoes_corporal] ?></textarea></h5></font>
                                <?php } else {
                                    
                                } ?>

                            </div>

                        </div>
                    </div>

                        <?php
                }
                ?>


















            </div>

    </section>
    <!--</div>-->
</div>                   

    <?php
    require_once './template/rodape_especial.php';
    