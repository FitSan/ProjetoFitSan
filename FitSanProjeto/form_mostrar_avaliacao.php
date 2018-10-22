<?php
$pagina = " Avaliações ";
require_once './template/cabecalho.php';
ini_set('display_errors', true);


$id_avaliacao = $_GET['id_avaliacao'];

$query = "select * from `avaliacao` where id= $id_avaliacao";
$resultado = mysqli_query($conexao, $query);
$linha = (mysqli_fetch_array($resultado));
?>
<style>

</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Avaliação  </h1>
    </section>
    <section class="content">
        <form method="post" action="">

            <div class="box box-primary">



                <div class="box-body">           
                    <div class="col-lg-10" >
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
                            <br>Apresentou algum tipo de dificuldade em uma determinada atividade? <font color="red" ><h5><?= $linha[grupo_dificuldade]?> , <?= $linha[caso_sim]  ?></h5></font> 

                        <?php } ?>
                            
                        <?php
                        if ($linha[consideracoes] != null) {
                            ?>
                            <br> <strong>Considerações gerais</strong> <font color="red" ><h5><?= $linha[consideracoes] ?></h5></font>
                        <?php } ?>


                        </section>
                        <!--</div>-->

<?php
require_once './template/rodape_especial.php';
