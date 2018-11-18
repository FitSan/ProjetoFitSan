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

$lendo = "update avaliacao set status='lido' where id=$id_avaliacao";
$consequência = mysqli_query($conexao, $lendo);

?>
<style>

</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Avaliação do aluno <strong><?php echo $nome_aluno ;echo  $sobrenome_aluno ;?></strong></h1>
        

    </section>
    <section class="content">
        <form method="post" action="">

            <div class="box box-primary" align="center">
                
                                <a href="<?=URL_SITE?>excluir_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao;?>">  
                                        <button type="button" class="btn btn-primary btn-flat"> Excluir </button>
                                    </a>
                                
                                   <a href="<?=URL_SITE?>alterar_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao;?>">  
                                        <button type="button" class="btn btn-primary btn-flat"> Alterar </button>
                                    </a>
                <?php
                if($linha[desempenho] == null && $linha[frequencia] == null && $linha[grupo_cumpriu] == null  && $linha[grupo_duvida] == null && $linha[grupo_dificuldade] == null && $linha[consideracoes] == null){
                    
                }else {
                                       
                                   
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
                            if ($linha[grupo_dificuldade] == 'sim') {
                                ?>
                                <br>Apresentou algum tipo de dificuldade em uma determinada atividade? <font color="red" ><h5><?= $linha[grupo_dificuldade] ?> , <?= $linha[caso_sim] ?></h5></font> 

                            <?php } ?>

                            <?php
                            if ($linha[consideracoes] != null) {
                                ?>
                                <br> <strong>Considerações gerais</strong> <font color="red" ><h5><textarea name="consideracoes_corporal"   cols="80" rows="10" disabled ><?= $linha[consideracoes] ?></textarea></h5></font>
                            <?php } ?>

                        </div>

                    </div>
                </div>
                
<?php 
}
if($linha[musculatura] == null && $linha[lesao] == null && $linha[queimacao] == null && $linha[caimbras] == null && $linha[tontura] == null && $linha[consideracoes_corporal] == null ){
    
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
                            if ($linha[consideracoes_corporal] != null) {
                                ?>
                                <br> <strong>Considerações gerais</strong> <font color="red" ><h5><textarea name="consideracoes_corporal"   cols="80" rows="10" disabled > <?= $linha[consideracoes_corporal] ?></textarea></h5></font>
                            <?php } ?>

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
