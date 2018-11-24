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

    $query_verificar = "select * from avaliacao where id=" . $id_avaliacao . " and profissional_id=" . $_SESSION['id'];
    $resultado_verificar = mysqli_query($conexao, $query_verificar);

    if (mysqli_num_rows($resultado_verificar) == 0) {

        header('Location: ' . URL_SITE . 'pagina1.php');
    }
}

if (tipoLogado("aluno")) {

    $query_verificar = "select * from avaliacao where id=" . $id_avaliacao . " and aluno_id=" . $_SESSION['id'];
    $resultado_verificar = mysqli_query($conexao, $query_verificar);

    if (mysqli_num_rows($resultado_verificar) == 0) {

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
        <h1> Avaliação do aluno <strong><?php
                echo $nome_aluno;
                echo $sobrenome_aluno;
                ?></strong></h1>
        <br>
        <?php if (tipoLogado("profissional")) { ?>


            <a href="<?= URL_SITE ?>form_historico_avaliacao_profissional.php" class="btn btn-app"><i class="fa fa-mail-reply"></i> Voltar </a>               

            <a href="<?= URL_SITE ?>alterar_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>" class="btn btn-app"><i class="fa fa-refresh"></i> Alterar </a>               
               
            <a type="button"  data-toggle="modal" data-target="#modal-excluir-avaliacao"  class="btn btn-app"><i class="fa fa-close"></i> Excluir </a>               
               

            <?php
        }
        if (tipoLogado("aluno")) {
            ?>

            <a href="<?= URL_SITE ?>historico.php" class="btn btn-app"><i class="fa fa-mail-reply"></i> Voltar </a>               
               
               
  
            <?php
        }
        ?>
    </section>
    <section class="content">
        <form method="post" action="">


            <?php 
                $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'resp_performance');
                ?>


                <div class="nav-tabs-custom">

                    <?php
                

                if ($linha[desempenho] == null && $linha[frequencia] == null && $linha[grupo_cumpriu] == null && $linha[grupo_duvida] == null && $linha[grupo_dificuldade] == null && $linha[consideracoes] == null) {
                    ?> <ul class="nav nav-tabs">

                  
                        <li <?php if ($aba == 'resp_avaliacao_corporal') echo ' class="active"'; ?>><a href="#resp_avaliacao_corporal" data-toggle="tab"> Avaliação corporal </a></li>

                    </ul>

                    <?PHP
                } else {
                    
                       if ($linha[musculatura] == null && $linha[lesao] == null && $linha[queimacao] == null && $linha[caimbras] == null && $linha[tontura] == null && $linha[consideracoes_corporal] == null) {
                       ?>
                           
                           <ul class="nav nav-tabs">

                        <li <?php if ($aba == 'resp_performance') echo ' class="active"'; ?>><a href="#resp_performance" data-toggle="tab"> Performance </a></li>

                    </ul>
                         <?php  
                           
                       } else {
                           ?>
                     <ul class="nav nav-tabs">

                        <li <?php if ($aba == 'resp_performance') echo ' class="active"'; ?>><a href="#resp_performance" data-toggle="tab"> Performance </a></li>
                        <li <?php if ($aba == 'resp_avaliacao_corporal') echo ' class="active"'; ?>><a href="#resp_avaliacao_corporal" data-toggle="tab"> Avaliação corporal </a></li>

                    </ul>
                           <?php
                       }
                    
                    ?>

                  
                    <div class="tab-content">

                        <div class="tab-pane<?php if ($aba == 'resp_performance') echo ' active'; ?>" id="resp_performance">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Pergunta</th>
                                        <th>Resposta</th>
                                    </tr>

                                    <tr>
    <?php if ($linha[desempenho] != null) { ?>

                                            <td>Desempenho do aluno com as atividades</td>
                                            <td><?= $linha[desempenho] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[frequencia] != null) { ?>

                                            <td>Frequência do aluno com as atividades</td>
                                            <td><?= $linha[frequencia] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[grupo_cumpriu] != null) { ?>

                                            <td>Cumpriu com os objetivos estipulados?</td>
                                            <td><?= $linha[grupo_cumpriu] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[grupo_duvida] != null) { ?>

                                            <td>O aluno tira dúvida com o professor?</td>
                                            <td><?= $linha[grupo_duvida] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[grupo_dificuldade] == 'Sim') { ?>

                                            <td>Dificuldade apresentada em uma determinada atividade.</td>
                                            <td><?= $linha[caso_sim] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                        $consi = $linha[consideracoes];
                                        if (strlen($consi) != null) {
                                            ?>

                                            <td>Considerações gerais</td>
                                            <td><?= $linha[consideracoes] ?></td>

    <?php } ?>
                                    </tr>



                                </table>
                            </div>
                        </div> 


                        <?php
                    }
                    if ($linha[musculatura] == null && $linha[lesao] == null && $linha[queimacao] == null && $linha[caimbras] == null && $linha[tontura] == null && $linha[consideracoes_corporal] == null) {
                        
                    } else {
                        ?>
                        <!--                                <div class="tab-pane" id="avaliacao_corporal"> -->
                        <div class="tab-pane<?php if ($aba == 'resp_avaliacao_corporal') echo ' active'; ?>" id="resp_avaliacao_corporal">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                     <tr>
                                        <th>Pergunta</th>
                                        <th>Resposta</th>
                                    </tr>
                                    <tr>
    <?php if ($linha[musculatura] != null) { ?>

                                            <td>O aluno desenvolveu musculatura ?</td>
                                            <td><?= $linha[musculatura] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[lesao] != null) { ?>

                                            <td>O aluno sofreu alguma lesão? </td>
                                            <td><?= $linha[lesao] ?></td>

    <?php } ?>
                                    </tr>

                                    <tr>
    <?php if ($linha[queimacao] != null) { ?>

                                            <td> O aluno já sentiu queimação? </td>
                                            <td><?= $linha[queimacao] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[caimbras] != null) { ?>

                                            <td> O aluno já sentiu caimbras?</td>
                                            <td><?= $linha[caimbras] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
    <?php if ($linha[tontura] != null) { ?>

                                            <td> O aluno perdeu seu equilíbrio por causa de tontura? </td>
                                            <td><?= $linha[tontura] ?></td>

    <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php
                                        $conside = $linha[consideracoes_corporal];
                                        if (strlen($conside) != null) {
                                            ?>

                                            <td> Considerações gerais </td>
                                            <td><?= $linha[consideracoes_corporal] ?></td>

    <?php } ?>
                                    </tr>
                                </table>


                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </div>
             
            </div>
            

<div class="modal fade" id="modal-excluir-avaliacao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Excluindo avaliação</h4>
            </div>
            <div class="modal-body">
               
                <p>Você tem certeza disso ?</p>          
           

            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            
                <a href="<?= URL_SITE ?>excluir_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>" class="btn btn-primary">  Excluir  </a> 
       
           
            
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

        </form>
    </section>
</div> 




<?php
require_once './template/rodape_especial.php';

