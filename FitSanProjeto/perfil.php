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

                            <img class="profile-user-img img-responsive img-circle" style="height: 150px; width: 150px;" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">

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

                            <?php if (!tipoLogado("admin")) { ?>
                                <a href="<?= URL_SITE ?>form_perfil.php" class="btn btn-primary btn-block"><b>Alterar</b></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    if (tipoLogado("aluno")) {

                        //referente ao formulário
                        $query_alterar = "select * from informacoes_adicionais where aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
                        $resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
                        $linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
                        if (!empty($linha_alterar['id'])) {
                            $query_cont_alterar = "select * from informacoes_adicionais_contatos where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_cont_alterar = mysqli_query($conexao, $query_cont_alterar) or die_mysql($query_cont_alterar, __FILE__, __LINE__);
                            $linha_alterar['contatos'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_cont_alterar))
                                $linha_alterar['contatos'][] = $linha2;
                            $query_exe_alterar = "select * from informacoes_adicionais_exercicios where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die_mysql($query_exe_alterar, __FILE__, __LINE__);
                            $linha_alterar['exercicios'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_exe_alterar))
                                $linha_alterar['exercicios'][] = $linha2['exercicios'];
                            $query_med_alterar = "select * from informacoes_adicionais_medidas where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_med_alterar = mysqli_query($conexao, $query_med_alterar) or die_mysql($query_med_alterar, __FILE__, __LINE__);
                            $linha_alterar['medidas'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_med_alterar))
                                $linha_alterar['medidas'][] = $linha2;
                        }
                        ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informações Adicionais</h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-fw fa-medkit margin-r-5"></i>Ficha médica</strong><br><br>
                                <b>Problemas de saúde:</b> <?php echo htmlspecialchars(!empty($linha_alterar['saude']) ? $linha_alterar['saude'] : '(Não informado)') ?> <br>
                                <b>Notas médicas:</b> <?php echo htmlspecialchars(!empty($linha_alterar['medico']) ? ($linha_alterar['medico']) : '(Não informado)') ?> <br>
                                <b>Alergias e reações:</b> <?php echo htmlspecialchars(!empty($linha_alterar['alergia']) ? ($linha_alterar['alergia']) : '(Não informado)') ?> <br>
                                <b>Medicamentos:</b> <?php echo htmlspecialchars(!empty($linha_alterar['medicamento']) ? ($linha_alterar['medicamento']) : '(Não informado)') ?> <br>
                                <b>Grupo sanguíneo:</b> <?php echo htmlspecialchars(!empty($linha_alterar['gruposangue']) ? ($linha_alterar['gruposangue']) : '(Não informado)') ?> <br>
                                <i class="fa fa-fw fa-heart-o"></i><b>Doador de Orgão:</b> <?php echo htmlspecialchars(!empty($linha_alterar['doador']) ? ($linha_alterar['doador']) : '(Não informado)') ?> <br>

                                <hr>
                                <strong><i class="fa fa-fw fa-phone"></i> Contato de emergência</strong><br><br>
                                <?php
                                if (!empty($linha_alterar['contatos'])) {
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

                                <b>Altura:</b> <?php echo!empty($linha_alterar['medidas'][0]['altura']) ? numeroFormatar($linha_alterar['medidas'][0]['altura'], -2) : '(Não informado)' ?><br>
                                <b>Peso:</b><?php echo!empty($linha_alterar['medidas'][0]['peso']) ? numeroFormatar($linha_alterar['medidas'][0]['peso'], -3) : '(Não informado)' ?> <br>
                                <b>Massa magra:</b><?php echo!empty($linha_alterar['medidas'][0]['massa_magra']) ? numeroFormatar($linha_alterar['medidas'][0]['massa_magra'], -3) : '(Não informado)' ?> <br>
                                <b>Gordura corporal:</b><?php echo!empty($linha_alterar['medidas'][0]['gordura_corporal']) ? numeroFormatar($linha_alterar['medidas'][0]['gordura_corporal'], -3) : '(Não informado)' ?> <br>
                                <b>IMC:</b><?php echo (!empty($linha_alterar['medidas'][0]['peso']) && !empty($linha_alterar['medidas'][0]['altura'])) ? numeroFormatar($linha_alterar['medidas'][0]['peso'] / pow($linha_alterar['medidas'][0]['altura'], 2), -2) : '(Não informado)' ?>

                                <hr>
                                <strong><i class="fa fa-fw fa-diamond margin-r-5"></i>Academia</strong><br><br>

                                <b>Academias já frequentadas:</b> <?php echo htmlspecialchars(!empty($linha_alterar['academia_frequentada']) ? ($linha_alterar['academia_frequentada']) : '(Não informado)' ) ?> <br>
                                <b>Academia atual:</b><?php echo htmlspecialchars(!empty($linha_alterar['academia_atual']) ? ($linha_alterar['academia_atual']) : '(Não informado)' ) ?> 

                                <hr>
                                <strong><i class="fa fa-fw fa-bicycle margin-r-5"></i>Esportes Praticados </strong><br><br>

                                <?php
                                $classes = array('label-danger', 'label-success', 'label-info', 'label-warning', 'label-primary');
                                $clsindice = 0;
                                if (!empty($linha_alterar['exercicios'])) {
                                    foreach ($linha_alterar['exercicios'] as $exercicio) {
                                        $classe = $classes[$clsindice++];
                                        if ($clsindice >= count($classes))
                                            $clsindice = 0;
                                        ?>
                                        <span class="label <?php echo $classe ?>"><?php echo htmlspecialchars($exercicio) ?></span>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    Não informado <br>
                                <?php }
                                ?>

                                <hr>

                                <?php if (!tipoLogado("admin")) { ?>
                                    <a href="<?= URL_SITE ?>informacoes_adicionais.php" class="btn btn-primary btn-block"><b>Alterar</b></a>
                                <?php } ?>
                            </div>                    
                        </div> 
                    <?php } ?>

                    <?php if (tipoLogado("profissional")) { ?>
                        <div class="box box-primary">

                            <?php
                            $query = "select * from usuario join vinculo on usuario.id = vinculo.aluno_id where vinculo.status = 'aprovado' and usuario.status = 'ativado' and vinculo.profissional_id = " . $_SESSION[id];
                            if ($resultado = mysqli_query($conexao, $query)) {
                                ?>
                                <div class="box-header with-border">
                                    <h3 class="box-title">Meus alunos</h3>
                                </div>

                                <div class="box-body no-padding">
                                    <ul class="users-list clearfix">
                                        <?php while ($linha = mysqli_fetch_array($resultado)) { ?>
                                            <li>                          
                                                <img class="img-responsive" src=" <?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" style="width: 100px">
                                                <a href="<?= URL_SITE ?>perfil_externo.php?id=<?= $linha['aluno_id'] ?>"><?= htmlspecialchars($linha['nome']) ?></a>
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

                <?php
                if (tipoLogado("aluno")) {
                    $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'atividadesExtras');
                    ?>

                    <!-- inicio do perfil aluno -->                

                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
        <!--                            <li<?php if ($aba == 'timeline') echo ' class="active"'; ?>><a href="#timeline" data-toggle="tab">Linha do tempo</a></li> -->
                                <li<?php if ($aba == 'atividadesExtras') echo ' class="active"'; ?>><a href="#atividadesExtras" data-toggle="tab">Atividades Extras</a></li>
                                <li<?php if ($aba == 'pesosMedidas') echo ' class="active"'; ?>><a href="#pesosMedidas" data-toggle="tab">Pesos e Medidas</a></li>
                                <li<?php if ($aba == 'treinosPlanilha') echo ' class="active"'; ?>><a href="#treinosPlanilha" data-toggle="tab">Treinos da Planilha</a></li>
                                <li<?php if ($aba == 'avaliacoes') echo ' class="active"'; ?>><a href="#avaliacoes" data-toggle="tab">Avaliações</a></li>
                            </ul>
                            <div class="tab-content">
        <!--                            <div class="tab-pane<?php if ($aba == 'timeline') echo ' active'; ?>" id="timeline">
                                    Post 
                                   
                                   Linha do Tempo
                                   
                                    /.post 
                                </div>-->

                                <div class="tab-pane<?php if ($aba == 'atividadesExtras') echo ' active'; ?>" id="atividadesExtras">
                                    <!-- Post -->

                                    <?php
//referente ao formulário
                                    if (!empty($id)) {
                                        $query_alterar = "select * from ativ_extras where aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . " and id= " . mysqliEscaparTexto($id);
                                        $resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
                                        $linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
                                        $query_exe_alterar = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
                                        $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die_mysql($query_exe_alterar, __FILE__, __LINE__);
                                        $linha_alterar['exercicios'] = array();
                                        while ($linha2 = mysqli_fetch_array($resultado_exe_alterar))
                                            $linha_alterar['exercicios'][] = $linha2['exercicio'];
                                    } else {
                                        $linha_alterar = array();
                                    }

//referente à paginação
                                    $query_pagina = "
select
    count(ativ_extras.id) as total
from
    ativ_extras join
    usuario on usuario.id=ativ_extras.aluno_id
where
    usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " 
";
                                    $resultado_pagina = mysqli_query($conexao, $query_pagina) or die_mysql($query_pagina, __FILE__, __LINE__);
                                    $paginacao = ($resultado_pagina ? mysqli_fetch_array($resultado_pagina) : array());
                                    $paginacao = array_merge(array(
                                        'total' => 0,
                                        'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
                                        'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
                                            ), array_map('intval', (array) $paginacao));
                                    $paginacao['offset'] = (($paginacao['pagina'] - 1) * $paginacao['quantidade']);
                                    $paginacao['paginas'] = ceil($paginacao['total'] / $paginacao['quantidade']);

                                    if ($paginacao['total'] > 0) {
                                        ?>
                                        <ul class="timeline timeline-inverse"> 
                                            <?php
//referente à consulta
                                            $query = "
select
    ativ_extras.*,
    usuario.nome,
    usuario.sobrenome,
    usuario.foto
from 
    ativ_extras join
    usuario on usuario.id=ativ_extras.aluno_id
where
    usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " 
order by
    ativ_extras.datahora desc
limit
    " . $paginacao['quantidade'] . "
offset
    " . $paginacao['offset']
                                            ;
                                            $resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);



                                            $dataanterior = '';
                                            while ($linha = mysqli_fetch_array($resultado)) {
                                                $dataatual = date('d/m/Y', dataParse($linha['datahora']));
                                                if ($dataanterior != $dataatual) {
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
                $query2 = "
select
    *
from
    ativ_extras_exercicios
where 
    ativ_extras_id= " . mysqliEscaparTexto($linha['id'])
                ;
                if ($resultado2 = mysqli_query($conexao, $query2)) {
                    while ($linha2 = mysqli_fetch_array($resultado2)) {
                        ?>
                                                                    <span class="label label-info col-md-2 col-xs-4 col-sm-3 pull-right "><?= htmlspecialchars($linha2['exercicio']) ?></span>
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

                <?php
            }
            if ($dataanterior) {
                ?>

                                                <li>
                                                    <i class="fa fa-clock-o bg-gray"></i>
                                                </li>
            <?php } ?>
                                        </ul> 
                                            <?php if ($paginacao['paginas'] > 1) { ?>
                                            <div class="box-footer clearfix">
                                                <ul class="pagination pagination-sm no-margin">
                                                    <li class="<?php echo (($paginacao['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?= URL_SITE ?><?php echo basename(__FILE__) ?>?aba=atividadesExtras">&laquo;</a></li>
                <?php for ($pag = 1; $pag <= $paginacao['paginas']; $pag++) { ?>
                                                        <li class="<?php echo (($paginacao['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?= URL_SITE ?><?php echo basename(__FILE__) ?>?aba=atividadesExtras&pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
                                                    <?php } ?>
                                                    <li class="<?php echo (($paginacao['pagina'] == $paginacao['paginas']) ? 'disabled' : '') ?>"><a href="<?= URL_SITE ?><?php echo basename(__FILE__) ?>?aba=atividadesExtras&pagina=<?php echo $paginacao['paginas'] ?>">&raquo;</a></li>
                                                </ul>
                                            </div>
            <?php } ?>  
                                    <?php } else { ?>
                                        <div class="text-center"><h3><b>Não foi realizado nenhuma atividade extra ainda.</b></h3></div>
                                    <?php } ?>           


                                    <!-- /.post -->
                                </div>

                                <div class="tab-pane<?php if ($aba == 'pesosMedidas') echo ' active'; ?>" id="pesosMedidas">
                                    <!-- Post -->

                                    Pesos e Medidas

                                    <!-- /.post -->
                                </div>

                                <div class="tab-pane<?php if ($aba == 'treinosPlanilha') echo ' active'; ?>" id="treinosPlanilha">
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
            'u.nome as profissional_nome',
            'u.sobrenome as profissional_sobrenome',
            'u.email as profissional_email',
        );
        $query['from'] = "
    planilha_aluno a join
    planilha_aluno_feito f on f.planilha_aluno_id = a.id join
    planilha_aluno_exercicio z on z.planilha_feito_id = f.id join
    planilha_tabela p on p.planilha_id = a.planilha_id and p.id = z.planilha_tabela_id join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = z.exercicio join
    usuario u on u.id = p.profissional_id
";
        $query['where'] = array(
            "a.aluno_id = " . mysqliEscaparTexto($_SESSION['id']),
        );

//referente à paginação
        $query_pagina = $query;
        $query_pagina['select'] = "count(*) as total";
        $resultado_pagina = dbquery($query_pagina);
        $paginacao2 = ($resultado_pagina ? $resultado_pagina[0] : array());
        $paginacao2 = array_merge(array(
            'total' => 0,
            'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
            'pagina' => (!empty($_GET['pagina2']) ? $_GET['pagina2'] : 1),
                ), array_map('intval', (array) $paginacao2));
        $paginacao2['offset'] = (($paginacao2['pagina'] - 1) * $paginacao2['quantidade']);
        $paginacao2['paginas'] = ceil($paginacao2['total'] / $paginacao2['quantidade']);


        $query['order'] = "f.datahora desc,p.grupo,exercicio";
        $query['outro'] = "limit " . $paginacao2['quantidade'] . " offset " . $paginacao2['offset'];



        $resultado = dbquery($query);
        ?>

                                    <section class="content-header">   
                                        <h3 class="box-title">Exercícios Feitos</h3>
                                    </section><br>
        <?php if (!empty($resultado)) { ?>
                                        <div class="tab-pane" id="timeline">
                                            <ul class="timeline timeline-inverse">
            <?php
            $dataanterior = $grupo_atual = $prof_atual = '';
            $anterior = null;
            foreach ($resultado as $linha) {
                $dataatual = date('d/m/Y', dataParse($linha['datahora']));
                if ($grupo_atual && (
                        ($dataanterior != $dataatual) ||
                        ($prof_atual != $linha['profissional_id']) ||
                        ($grupo_atual != $linha['grupo'])
                        )) {
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
                                            $prof_atual = $grupo_atual = '';
                                        }
                                        if (($prof_atual != $linha['profissional_id']) || ($grupo_atual != $linha['grupo'])) {
                                            $grupo_atual = $linha['grupo'];
                                            $prof_atual = $linha['profissional_id'];
                                            ?>            
                                            <li>
                                                <i class="fa fa-thumbs-o-up bg-blue"></i>

                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i:s', dataParse($linha['datahora'])) ?></span>

                                                    <h3 class="timeline-header"><strong><?php echo htmlspecialchars($linha['grupo']); ?></strong> - por <?php echo htmlspecialchars($linha['profissional_nome'] . ' ' . $linha['profissional_sobrenome']); ?></h3>


                                                    <div class="timeline-body">
                                                        <div class="table-responsive">
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

                                            </div>
                                        </li> 
                                        <li>
                                            <i class="fa fa-clock-o bg-gray"></i>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    </ul>
                                    <?php if ($paginacao2['paginas'] > 1) { ?>
                                        <div class="box-footer clearfix">
                                            <ul class="pagination pagination-sm no-margin">
                                                <li class="<?php echo (($paginacao2['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?= URL_SITE ?><?php echo basename(__FILE__) ?>?aba=treinosPlanilha">&laquo;</a></li>
                                                <?php for ($pag = 1; $pag <= $paginacao2['paginas']; $pag++) { ?>
                                                    <li class="<?php echo (($paginacao2['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?= URL_SITE ?><?php echo basename(__FILE__) ?>?aba=treinosPlanilha&pagina2=<?php echo $pag ?>"><?php echo $pag ?></a></li>
                                                <?php } ?>
                                                <li class="<?php echo (($paginacao2['pagina'] == $paginacao2['paginas']) ? 'disabled' : '') ?>"><a href="<?= URL_SITE ?><?php echo basename(__FILE__) ?>?aba=treinosPlanilha&pagina2=<?php echo $paginacao2['paginas'] ?>">&raquo;</a></li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <div class="text-center"><h3><b>Não foi realizado nenhum exercício ainda.</b></h3></div>
                            <?php } ?> 

                            <!-- /.post -->
                        </div>

                        <div class="tab-pane<?php if ($aba == 'avaliacoes') echo ' active'; ?>" id="avaliacoes">
                            <!-- Post -->

                            Postar avaliações

                            <!-- /.post -->
                        </div>

                    </div>
                </div>

        </div>

        <!-- /.fim do perfil aluno -->

    <?php
    }

    if (tipoLogado("profissional")) {
        $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'dicas');
//                     
        ?>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs ">
        <!--                                    <li<?php if ($aba == 'timeline') echo ' class="active"'; ?>><a href="#timeline" data-toggle="tab">Linha do tempo</a></li>                    -->
                    <li<?php if ($aba == 'dicas') echo ' class="active"'; ?>><a href="#dicas" data-toggle="tab">Dicas</a></li>

                </ul>
                <div class="tab-content">
        <!--                                    <div class="tab-pane<?php if ($aba == 'timeline') echo ' active'; ?>" id="timeline">
                        
                         post 
                        PostarLinha do tempo
                         /.post 
                        
                    </div>-->
                    <div class="tab-pane<?php if ($aba == 'dicas') echo ' active'; ?>" id="dicas">
                        <!-- Post -->
                        <?php
                        $query = "select dica.*, usuario.nome, usuario.sobrenome, usuario.foto from dica join usuario on usuario.id = dica.profissional_id";
                        if (tipoLogado("profissional")) {
                            $query .= " where dica.profissional_id = " . $_SESSION['id'];
                        } elseif (tipoLogado("aluno")) {
                            if (!empty($aluno_profissional))
                                $query .= " where dica.profissional_id = " . $aluno_profissional;
                        }
                        $query .= " order by data_envio desc";
                        $resultado = mysqli_query($conexao, $query);
                        while ($linha = mysqli_fetch_array($resultado)) {
                            ?>
                            <div style="margin: 0 auto; width: 80%;">      
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <div class="user-block">
                                            
                                            <img class="img-circle img-bordered-sm" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">
                                            <span class="username">
                                                <?= $linha['profissional_nome'] ?><i style="font-size: 15px;">postou a dica</i> <b><?= $linha['titulo'] ?></b><i style="font-size: 15px;">.</i>
                                                <button type="button" class="pull-right btn-box-tool" data-toggle="modal" data-target="#excluir-dica" data-id="<?= $linha['id'] ?>"><i class="fa fa-times"></i></button>
                                                    
                                                <!--Fim do icone x-->
                                            </span>
                                            <span class="description"><?= date('d/m/Y H:i:s', dataParse($linha['data_envio'])) ?></span>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" >
                                        <p> <?= nl2br(htmlentities($linha['texto'])) ?> </p> 
                                        <div id="uploads" style="max-height: 500px;">
                                            <ul><?php
                                                $query_dica = "select * from upload_dica where dica_id = $linha[id]";
                                                $resultado_upload = mysqli_query($conexao, $query_dica);
                                                while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                                                    if ($linha_upload['tipo'] != 'img') {
                                                        ?>                          
                                                        <li><video height="70%" style="padding: 5px; min-height: 200px;" controls>
                                                                <source src="<?= URL_SITE ?>uploads/dicas/<?= $linha_upload['nome_arq'] ?>" type="video/mp4">
                                                            </video></li>
                                                        <?php
                                                    } else {
                                                        ?>  
                                                        <li><img src="<?= URL_SITE ?>uploads/dicas/<?= $linha_upload['nome_arq'] ?>" height="80%" style="padding: 5px;"></li>                  

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->

                                </div>
                            </div>              
                           
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
