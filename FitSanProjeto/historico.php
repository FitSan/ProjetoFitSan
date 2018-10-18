<?php
$pagina = "Histórico";
require_once './template/cabecalho.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php
            if (estaLogado()) {
                echo 'Histórico de ' . exibirName();
            }
            ?>
        </h1>
    </section>
    <br>
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#exercicios" data-toggle="tab"> Exercicios </a></li>
                <li><a href="#avaliacoes" data-toggle="tab"> Avaliações </a></li>
                <li><a href="#pesosMedidas" data-toggle="tab"> Pesos e Medidas </a></li>
                <li><a href="#ativExtra" data-toggle="tab"> Atividades Extras </a></li>
            </ul>
            <div class="tab-content">               
                <div class="active tab-pane" id="exercicios">
                    <?php
                $query = array();
                $query['select'] = array(
                    'a.planilha_id',
                    'p.profissional_id',
                    'p.musculo_cardio_id',
                    'p.exercicio_id',
                    'p.grupo',
                    'p.series',
                    'p.repeticoes',
                    'p.carga',
                    'p.intervalo',
                    'p.tempo',
                    'g.nome grupomusc',
                    'e.nome exercicio',
                    'e.descricao exercicio_desc',
                    'e.foto exercicio_foto',
                    'f.datahora',
                    'z.planilha_feito_id',
                );
                $query['from'] = "
    planilha_aluno a join
    planilha_tabela p on p.planilha_id = a.planilha_id join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = p.exercicio_id and e.musculo_cardio_id = g.id join
    planilha_aluno_feito f on f.planilha_aluno_id = a.planilha_id join
    planilha_aluno_exercicio z on z.planilha_feito_id = f.id and z.exercicio = e.id
";
                $query['where'] = array(
                    "a.aluno_id = " . mysqliEscaparTexto($_SESSION['id']),
                );
                $query['order'] = "
    p.grupo
";

                $resultado = dbquery($query);
                ?> 
                    <!-- Post -->
                    <h3 class="box-title">Exercícios Feitos</h3>
                    <br>
                    <?php if (!empty($resultado)) { ?>
                        <div class="tab-pane" id="timeline">
                            <ul class="timeline timeline-inverse">
                                <?php
                                $dataanterior = $grupo_atual = '';
                                $anterior = null;
                                foreach ($resultado as $linha) {
                                    $dataatual = date('d/m/Y', dataParse($linha['datahora']));
                                    if ($grupo_atual && (($dataanterior != $dataatual) || ($grupo_atual != $linha['grupo']))) {
                                        ?>
                                        </table>
                                </div>
                </div>
                            </li> 
                            
                            <?php
                        }
                        if ($dataanterior != $dataatual) {
                            ?>
                            <li class="time-label">
                                <span class="bg-red">
                                    <?= $dataatual ?>
                                </span>
                            </li>
                               <?php
                            $dataanterior = $dataatual;
                            $grupo_atual = '';
                        }
                        if ($grupo_atual != $linha['grupo']) {
                            $grupo_atual = $linha['grupo'];
                            ?>         
                            <li>                               
                                <i class="fa fa-thumbs-o-up bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i:s', dataParse($linha['datahora'])) ?></span>
                                    <h3 class="timeline-header"><strong><?php echo htmlspecialchars($linha['grupo']); ?></strong> Exercícios Feitos</h3>
                                    <div class="timeline-body">
                                        <table class="table table-striped planilha dataTable">
                                            <tr>
                                                <th>Exercício</th>
                                                <th>Séries</th>
                                                <th>Repetições</th>                      
                                                <th>Carga(Kg)</th>
                                                <th>Intervalo</th>
                                                <th>Tempo</th>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($linha['exercicio']) ?><b class="label label-danger"><?php echo htmlentities($linha['grupomusc']) ?></b></td>
                                            <td><?php echo htmlentities($linha['series']) ?></td>
                                            <td><?php echo htmlentities($linha['repeticoes']) ?></td>
                                            <td><?php echo htmlentities($linha['carga']) ?></td>
                                            <td><?php echo htmlentities($linha['intervalo']) ?></td>
                                            <td><?php echo htmlentities($linha['tempo']) ?></td>
                                        </tr>
                                        <?php
                                        $anterior = $linha;
                                    }
                                    if ($grupo_atual) {
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </li> 
                        <?php
                    }
                    ?>
                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>   
                    </ul>
                </div>
            <?php } else { ?>
                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Não foi realizado nenhum exercício ainda.</b></h3></div>
            <?php } ?>

            <!-- /.post -->
        </div>
        
        <div class="tab-pane" id="avaliacoes">
            <!-- Post -->
            Postar o histórico de avaliações realizadas
            <!-- /.post -->
        </div>
        <div class="tab-pane" id="pesosMedidas">
            <!-- Post -->
            Postar o historico de dados retirado de Metas
            <!-- /.post -->
        </div>
        
        <div class="tab-pane" id="ativExtra">
            <!-- Post -->
            <ul class="timeline timeline-inverse">             
<?php

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from ativ_extras where aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . " and id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query_alterar.PHP_EOL.print_r(debug_backtrace(), true));
    $linha_alterar = ($resultado_alterar?mysqli_fetch_array($resultado_alterar):array());
    $query_exe_alterar = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
    $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query_exe_alterar.PHP_EOL.print_r(debug_backtrace(), true));
    $linha_alterar['exercicios'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicio'];
} else {
    $linha_alterar = array();
}

//referente à paginação
$query_pagina = "select count(ativ_extras.id) as total from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']);
$resultado_pagina = mysqli_query($conexao, $query_pagina) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query_pagina.PHP_EOL.print_r(debug_backtrace(), true));
$pagina = ($resultado_pagina?mysqli_fetch_array($resultado_pagina):array());
$pagina = array_merge(array(
    'total' => 0,
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
), array_map('intval', (array)$pagina));
$pagina['offset'] = (($pagina['pagina'] - 1) * $pagina['quantidade']);
$pagina['paginas'] = ceil($pagina['total'] / $pagina['quantidade']);

//referente à consulta
$query = "select ativ_extras.*, usuario.nome, usuario.sobrenome, usuario.foto from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " order by ativ_extras.datahora desc limit " . $pagina['quantidade'] . " offset " . $pagina['offset'];
$resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));



$dataanterior = '';
while ($linha = mysqli_fetch_array($resultado)) {
    $dataatual = date('d/m/Y', dataParse($linha['datahora']));
    if ($dataanterior != $dataatual){
?>
                    <li class="time-label">
                        <span class="bg-red">
                            <?= $dataatual ?>
                        </span>
                    </li>
                    <!-- /.timeline-label -->
<?php
        $dataanterior = $dataatual;
    }
?>
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-user bg-aqua"></i>

                        <div class="timeline-item bg-danger">
                            <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i:s', dataParse($linha['datahora'])) ?></span>

                            <h3 class="timeline-header"><a href="#"><?= htmlentities($linha['titulo']) ?></a>
<?php
    $query2 = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($linha['id']);
    if ($resultado2 = mysqli_query($conexao, $query2)){
        while ($linha2 = mysqli_fetch_array($resultado2)){
?>
                                <span class="label label-info"><?= htmlspecialchars($linha2['exercicio']) ?></span>
<?php
        }
        mysqli_free_result($resultado2);
    }
?>
                            </h3>

                            <div class="timeline-body">
                                <?= nl2br(htmlentities($linha['texto'])) ?>
                            </div>

                            
                        </div>
                    </li>
                    <!-- END timeline item -->
<?php
}
?>
                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li> 

                </ul>
            
  <?php if ($pagina['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($pagina['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $pagina['paginas']; $pag++){ ?>
                <li class="<?php echo (($pagina['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($pagina['pagina'] == $pagina['paginas']) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pagina['paginas'] ?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>          
            <!-- /.post -->
        </div>

    </div>
</div>
</div> 
<!--</div>-->

<?php
require_once './template/rodape_especial.php';
