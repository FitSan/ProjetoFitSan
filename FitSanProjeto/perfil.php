<?php
$pagina = "Meu Perfil";

require_once './template/cabecalho.php';


$query = "select * from usuario where id=" . $_SESSION['id'];
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Meu perfil
            </h1>
            <ol class="breadcrumb">
                <li> <?= breadcrumbs() ?></li>
            </ol>
        </section> 

        <section class="content">

            <div class="row">
                <div class="col-md-3">


                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">

                            <h3 class="profile-username text-center"><?= htmlspecialchars($linha['nome']) ?> <?= htmlspecialchars($linha['sobrenome']) ?></h3>

                            <p class="text-muted text-center"><?= htmlspecialchars($linha['email']) ?></p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b><?= (!empty($linha['sexo']) ? ucfirst($linha['sexo']) : '(Não definido)') ?></b> <a class="pull-right"><?= (!empty($linha['datanasc']) ? calculaidade($linha['datanasc']) : '??') ?> anos</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Data de nascimento</b> <a class="pull-right"><?= (!empty($linha['datanasc']) ? date('d/m/Y', dataParse($linha['datanasc'])) : '(Não definido)') ?></a>
                                </li>
                            </ul>

                            <?php if (!tipoLogado("admin")){ ?>
                            <a href="form_perfil.php" class="btn btn-primary btn-block"><b>Alterar</b></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (tipoLogado("aluno")){

                        //referente ao formulário
                        $query_alterar = "select * from informacoes_adicionais where aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
                        $resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
                        $linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
                        if (!empty($linha_alterar['id'])) {
                            $query_cont_alterar = "select * from informacoes_adicionais_contatos where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_cont_alterar = mysqli_query($conexao, $query_cont_alterar) or die_mysql($query_cont_alterar, __FILE__, __LINE__);
                            $linha_alterar['contatos'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_cont_alterar)) $linha_alterar['contatos'][] = $linha2;
                            $query_exe_alterar = "select * from informacoes_adicionais_exercicios where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die_mysql($query_exe_alterar, __FILE__, __LINE__);
                            $linha_alterar['exercicios'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicios'];
                            $query_med_alterar = "select * from informacoes_adicionais_medidas where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_med_alterar = mysqli_query($conexao, $query_med_alterar) or die_mysql($query_med_alterar, __FILE__, __LINE__);
                            $linha_alterar['medidas'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_med_alterar)) $linha_alterar['medidas'][] = $linha2;
                        }

                        
                        
                        ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informações Adicionais</h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-fw fa-medkit margin-r-5"></i>Ficha médica</strong><br><br>
                                <b>Problemas de saúde:</b> <?php echo htmlspecialchars(!empty($linha_alterar['saude']) ? $linha_alterar['saude'] : '(Não informado)')  ?> <br>
                                <b>Notas médicas:</b> <?php echo htmlspecialchars(!empty($linha_alterar['medico']) ? ($linha_alterar['medico']) : '(Não informado)') ?> <br>
                                <b>Alergias e reações:</b> <?php echo htmlspecialchars(!empty($linha_alterar['alergia']) ? ($linha_alterar['alergia']) : '(Não informado)') ?> <br>
                                <b>Medicamentos:</b> <?php echo htmlspecialchars(!empty($linha_alterar['medicamento']) ? ($linha_alterar['medicamento']) : '(Não informado)') ?> <br>
                                <b>Grupo sanguíneo:</b> <?php echo htmlspecialchars(!empty($linha_alterar['gruposangue']) ? ($linha_alterar['gruposangue']) : '(Não informado)') ?> <br>
                                <i class="fa fa-fw fa-heart-o"></i><b>Doador de Orgão:</b> <?php echo htmlspecialchars(!empty($linha_alterar['doador']) ? ($linha_alterar['doador']) : '(Não informado)') ?> <br>

                                <hr>
                                <strong><i class="fa fa-fw fa-phone"></i> Contato de emergência</strong><br><br>
                                <?php
                                if (!empty($linha_alterar['contatos'])){
                                    foreach ($linha_alterar['contatos'] as $contato) {
                                ?>
                                        <b><?php echo htmlspecialchars($contato['tipo']) ?>:</b> <?php echo htmlspecialchars($contato['nome']) ?> - <?php echo htmlspecialchars($contato['telefone']) ?> <br>
                                <?php
                                    }
                                } else {
                                ?>
                                        Não informado <br>
                                <?php
                                }
                                ?>

                                <hr>
                                <strong><i class="fa fa-fw fa-male margin-r-5"></i>Medidas</strong><br><br>

                                <b>Altura:</b> <?php echo !empty($linha_alterar['medidas'][0]['altura']) ? numeroFormatar($linha_alterar['medidas'][0]['altura'], -2) : '(Não informado)' ?><br>
                                <b>Peso:</b><?php echo  !empty($linha_alterar['medidas'][0]['peso']) ? numeroFormatar($linha_alterar['medidas'][0]['peso'], -3)  : '(Não informado)' ?> <br>
                                <b>Massa magra:</b><?php echo !empty($linha_alterar['medidas'][0]['massa_magra']) ? numeroFormatar($linha_alterar['medidas'][0]['massa_magra'], -3) : '(Não informado)' ?> <br>
                                <b>Gordura corporal:</b><?php echo !empty($linha_alterar['medidas'][0]['gordura_corporal']) ? numeroFormatar($linha_alterar['medidas'][0]['gordura_corporal'], -3) : '(Não informado)' ?> <br>
                                <b>IMC:</b><?php echo (!empty($linha_alterar['medidas'][0]['peso']) && !empty($linha_alterar['medidas'][0]['altura']))? numeroFormatar($linha_alterar['medidas'][0]['peso'] / pow($linha_alterar['medidas'][0]['altura'], 2), -2) : '(Não informado)'?>

                                <hr>
                                <strong><i class="fa fa-fw fa-diamond margin-r-5"></i>Academia</strong><br><br>

                                <b>Academias já frequentadas:</b> <?php echo htmlspecialchars(!empty($linha_alterar['academia_frequentada']) ? ($linha_alterar['academia_frequentada']) : '(Não informado)' ) ?> <br>
                                <b>Academia atual:</b><?php echo htmlspecialchars(!empty($linha_alterar['academia_atual']) ? ($linha_alterar['academia_atual']) : '(Não informado)' ) ?> 

                                <hr>
                                <strong><i class="fa fa-fw fa-bicycle margin-r-5"></i>Esportes Praticados </strong><br><br>
                                
                                <?php
                                $classes = array('label-danger', 'label-success', 'label-info', 'label-warning', 'label-primary'); $clsindice = 0;
                                if (!empty($linha_alterar['exercicios'])){
                                foreach ($linha_alterar['exercicios'] as $exercicio) {
                                    $classe = $classes[$clsindice++];
                                    if ($clsindice >= count($classes)) $clsindice = 0;
                                ?>
                                 <span class="label <?php echo $classe ?>"><?php echo htmlspecialchars($exercicio) ?></span>
                                <?php }
                                } else {
                                ?>
                                        Não informado <br>
                                <?php
                                } ?>

                                 <hr>

                                <?php if (!tipoLogado("admin")){ ?>
                                <a href="informacoes_adicionais.php" class="btn btn-primary btn-block"><b>Alterar</b></a>
                                <?php } ?>
                            </div>                    
                        </div> 
                    <?php }  ?>
                    
                    <?php if (tipoLogado("profissional")){ ?>
                    <div class="box box-primary">
                        
                        <?php
                         $query = "select * from usuario join vinculo on usuario.id = vinculo.aluno_id where vinculo.status = 'aprovado' and usuario.status = 'ativado' and vinculo.profissional_id = " . $_SESSION[id] ;
                                if ($resultado = mysqli_query($conexao, $query)){
        
                                
                        ?>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Meus alunos</h3>
                                </div>
                                
                        <div class="box-body no-padding">
                            <ul class="users-list clearfix">
                                <?php while ($linha = mysqli_fetch_array($resultado)){ ?>
                                <li>                          
                                    <img class="img-responsive" src=" <?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>">
                                    <a href="perfil_externo.php?id=<?= $linha['aluno_id'] ?>"><?= htmlspecialchars($linha['nome']) ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php }
                ?>
                        
                            </div>
                   
               <?php }
                ?>
                </div>
                
                
                
                
                <!-- Inicio do histórico publico-->
                
                <?php if (tipoLogado("aluno")){
                    $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'timeline');
                ?>
                                
                                
                
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li<?php if ($aba == 'timeline') echo ' class="active"'; ?>><a href="#timeline" data-toggle="tab">Linha do tempo</a></li> 
                            <li<?php if ($aba == 'ativExtra') echo ' class="active"'; ?>><a href="#ativExtra" data-toggle="tab">Atividades Realizadas</a></li>
                            <li<?php if ($aba == 'treinos_realizados') echo ' class="active"'; ?>><a href="#treinos_realizados" data-toggle="tab">Treinos realizados</a></li>
                             <li<?php if ($aba == 'avaliacoes') echo ' class="active"'; ?>><a href="#avaliacoes" data-toggle="tab">Avaliações</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane<?php if ($aba == 'timeline') echo ' active'; ?>" id="timeline">
                               <!-- Post -->
                               Postar todas as atualizações da plataforma
                               <!-- /.post -->
                            </div>
                            <div class="tab-pane<?php if ($aba == 'ativExtra') echo ' active'; ?>" id="ativExtra">
                                <!-- Post -->
                                <ul class="timeline timeline-inverse"> 
                                <?php
                                

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from ativ_extras where aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . " and id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
    $linha_alterar = ($resultado_alterar?mysqli_fetch_array($resultado_alterar):array());
    $query_exe_alterar = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
    $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die_mysql($query_exe_alterar, __FILE__, __LINE__);
    $linha_alterar['exercicios'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicio'];
} else {
    $linha_alterar = array();
}

//referente à paginação
$query_pagina = "select count(ativ_extras.id) as total from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']);
$resultado_pagina = mysqli_query($conexao, $query_pagina) or die_mysql($query_pagina, __FILE__, __LINE__);
$paginacao = ($resultado_pagina?mysqli_fetch_array($resultado_pagina):array());
$paginacao = array_merge(array(
    'total' => 0,
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
), array_map('intval', (array)$paginacao));
$paginacao['offset'] = (($paginacao['pagina'] - 1) * $paginacao['quantidade']);
$paginacao['paginas'] = ceil($paginacao['total'] / $paginacao['quantidade']);

//referente à consulta
$query = "select ativ_extras.*, usuario.nome, usuario.sobrenome, usuario.foto from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " order by ativ_extras.datahora desc limit " . $paginacao['quantidade'] . " offset " . $paginacao['offset'];
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);



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
                    
<?php
        $dataanterior = $dataatual;
    }
?>
                    
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
            
  <?php if ($paginacao['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($paginacao['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?aba=ativExtra">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $paginacao['paginas']; $pag++){ ?>
                <li class="<?php echo (($paginacao['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?aba=ativExtra&pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($paginacao['pagina'] == $paginacao['paginas']) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?aba=ativExtra&pagina=<?php echo $paginacao['paginas'] ?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>  
                                       
                
                
                                <!-- /.post -->
                            </div>
                            <div class="tab-pane<?php if ($aba == 'treinos_realizados') echo ' active'; ?>" id="treinos_realizados">
                                <!-- Post -->
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


                //referente à paginação
                $query_pagina = $query;
                $query_pagina['select'] = "count(*) as total";
                $resultado_pagina = dbquery($query_pagina);
                $paginacao2 = ($resultado_pagina?$resultado_pagina[0]:array());
                $paginacao2 = array_merge(array(
                    'total' => 0,
                    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
                    'pagina' => (!empty($_GET['pagina2']) ? $_GET['pagina2'] : 1),
                ), array_map('intval', (array)$paginacao2));
                $paginacao2['offset'] = (($paginacao2['pagina'] - 1) * $paginacao2['quantidade']);
                $paginacao2['paginas'] = ceil($paginacao2['total'] / $paginacao2['quantidade']);

                $query['order'] = "
    f.datahora desc
";
                 $query['outro'] = "limit " . $paginacao2['quantidade'] . " offset " . $paginacao2['offset'];
                $resultado = dbquery($query);
                ?> 
                                        <h3 class="box-title">Exercícios Feitos</h3>
                    <br>
                    <?php if (!empty($resultado)) { ?>
                        <div class="tab-pane active" id="timeline">
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
  <?php if ($paginacao2['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($paginacao2['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?aba=treinos_realizados">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $paginacao2['paginas']; $pag++){ ?>
                <li class="<?php echo (($paginacao2['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?aba=treinos_realizados&pagina2=<?php echo $pag ?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($paginacao2['pagina'] == $paginacao2['paginas']) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?aba=treinos_realizados&pagina2=<?php echo $paginacao2['paginas'] ?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>  
                              </div>
            <?php } else { ?>
                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Não foi realizado nenhum exercício ainda.</b></h3></div>
            <?php } ?>
                                       
                                <!-- /.post -->
                            </div>
                            <div class="tab-pane<?php if ($aba == 'avaliacoes') echo ' active'; ?>" id="avaliacoes">
                                <!-- Post -->
                                Postar as ultimas avaliações
                                <!-- /.post -->
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <?php } 
                
                 if (tipoLogado("profissional")){ 
                     $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'timeline');
//                     TODO: as acima das dicas estao aparecendo a timeline. 
                     ?>
                
                <div class="col-md-9">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs ">
                                    <li<?php if ($aba == 'timeline') echo ' class="active"'; ?>><a href="#timeline" data-toggle="tab">Linha do tempo</a></li>                    
                                    <li<?php if ($aba == 'dicas') echo ' class="active"'; ?>><a href="#dicas" data-toggle="tab">Dicas</a></li>

                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane<?php if ($aba == 'timeline') echo ' active'; ?>" id="timeline">
                                        <!-- The timeline -->
                                        <ul class="timeline timeline-inverse">
                                            <!-- timeline time label -->
                                            <li class="time-label">
                                                <span class="bg-red">
                                                    10 Feb. 2014
                                                </span>
                                            </li>
                                            <li>
                                                <i class="fa fa-envelope bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                                    <div class="timeline-body">
                                                        Você enviou uma nova dica.
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a class="btn btn-primary btn-xs">Read more</a>
                                                        <a class="btn btn-danger btn-xs">Delete</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-user bg-aqua"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                                                    <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> Colocar aqui uma mensagem quando receber solicitação de amizade.
                                                    </h3>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-comments bg-yellow"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
                                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                                    <div class="timeline-body">
                                                        Você enviou uma avaliação para ...
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                            <!-- timeline time label -->
                                            <li class="time-label">
                                                <span class="bg-green">
                                                    3 Jan. 2014
                                                </span>
                                            </li>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <li>
                                                <i class="fa fa-camera bg-purple"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>
                                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                                    <div class="timeline-body">
                                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- END timeline item -->
                                            <li>
                                                <i class="fa fa-clock-o bg-gray"></i>
                                            </li>
                                        </ul>
                                    </div>
                            <div class="tab-pane<?php if ($aba == 'dicas') echo ' active'; ?>" id="dicas">
                                <!-- Post -->
                                <?php 

$query = "select dica.*, usuario.nome, usuario.sobrenome, usuario.foto from dica join usuario on usuario.id = dica.profissional_id";
if (tipoLogado("profissional")){
    $query .= " where dica.profissional_id = ".$_SESSION['id'];
} elseif (tipoLogado("aluno")){
    if (!empty($aluno_profissional)) $query .= " where dica.profissional_id = ".$aluno_profissional;
}
$query .= " order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
                while ($linha = mysqli_fetch_array($resultado)) {
                    ?>
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">
                            <span class="username">
                                <a href="perfil_externo.php?id=<?= $linha['profissional_id'] ?>"><?= $linha['profissional_nome'] ?></a> 
                                <?php
                                if($linha['profissional_id']==$_SESSION['id']){
                                ?>
                               
                                
                                <button type="button" class="pull-right btn-box-tool" data-toggle="modal" data-target="#excluir-dica" data-id="<?= $linha['id'] ?>"><i class="fa fa-times"></i></button>
                                <?php
                                }
                                ?>
                                <!--Fim do icone x-->
                            </span>
                            <span class="description"><?= date('d/m/Y H:i:s', dataParse($linha['data_envio'])) ?></span>
                        </div>
                        <p> <?= nl2br(htmlentities($linha['texto'])) ?> </p> 
                        <div id="uploads"><ul><?php
                            $query_dica = "select * from upload_dica where dica_id = $linha[id]";
                            $resultado_upload = mysqli_query($conexao, $query_dica);
                            while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                                if($linha_upload['tipo']!='img'){
                        ?>                          
                        <li><video height="380" style="padding: 5px;" controls>
                                <source src="upload/dica/<?= $linha_upload['nome_arq'] ?>" type="video/mp4">
                            </video></li>
                           <?php 
                                }else{
                                  ?>  
                        <li><img src="upload/dica/<?= $linha_upload['nome_arq'] ?>" height="380" style="padding: 5px;"></li>                  

                           <?php   
                                }

                                }?>
                            </ul>
                        </div>
                        
                        <!--Caso necessario colocar comentário e as opções de compartilhar e gostar -->

                        <!--<ul class="list-inline">
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                        </li>
                                        <li class="pull-right">
                                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                                (5)</a></li>
                                    </ul>
                                    <input class="form-control input-sm" type="text" placeholder="Type a comment">-->

                        <!--final do comentario -->
                    </div>
                    <!-- /.post -->
                    <?php
                }
                ?>
                                <!-- /.post -->
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                
                
                <?php } ?>
              
                
                
               
            </div>       
        </section>
    <!--</div>-->

    <?php
} else {

    echo "Não Foi possivel obter a informação deste usuário.";
}
include './template/rodape_especial.php';
