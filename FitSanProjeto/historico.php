<?php
$pagina = "Histórico";
require_once './template/cabecalho.php';
require_once './template/menu.php';


if (!tipoLogado("aluno")) {
    header('Location: '.URL_SITE.'pagina1.php');
    exit;
}

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php
            if (estaLogado()) {
                echo 'Histórico de ' . exibirName();
                $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'atividadesExtras');
            }
            ?>
        </h1>
    </section>
    <br>
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li<?php if ($aba == 'atividadesExtras') echo ' class="active"'; ?>><a href="#atividadesExtras" data-toggle="tab">Atividades Extras</a></li>
                <li<?php if ($aba == 'pesosMedidas') echo ' class="active"'; ?>><a href="#pesosMedidas" data-toggle="tab">Pesos e Medidas</a></li>
                <li<?php if ($aba == 'treinosPlanilha') echo ' class="active"'; ?>><a href="#treinosPlanilha" data-toggle="tab">Treinos da Planilha</a></li>
                <li<?php if ($aba == 'avaliacoes') echo ' class="active"'; ?>><a href="#avaliacoes" data-toggle="tab">Avaliações</a></li>
                <li<?php if ($aba == 'documentos') echo ' class="active"'; ?>><a href="#documentos" data-toggle="tab"><i class="fa fa-paperclip" style="font-size: 20px;"></i></a></li>
            </ul>
            <div class="tab-content">               
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
    usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " and
    ativ_extras.visualizacao = 'PUBLICO'
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
                    <?php
                    include_once 'metas_hist.php';
                    ?>
                    <!-- /.post -->

                </div>

                <div class="tab-pane<?php if ($aba == 'treinosPlanilha') echo ' active'; ?>" id="treinosPlanilha">

                    <!-- Post -->
                    Postar o historico dos treinos das planilhas.
                    <!-- /.post -->


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

            <?php
            $usuarios = array();
            $query = "select * from avaliacao  where aluno_id=" . $_SESSION['id']." and status='lido' order by avaliacao.`data` desc";

            $retorno = mysqli_query($conexao, $query);
            while ($linhas = mysqli_fetch_array($retorno)) {
                array_push($usuarios, $linhas);
            }


            if ($usuarios == null) {
                ?>
                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Você não possui nenhuma avaliação!</b></h3></div>
                <?php
            } else {

                foreach ($usuarios as $usuario) {

                    $sql = "select * from usuario where id=" . $usuario['profissional_id'];
                    $retorno_usuario = mysqli_query($conexao, $sql);
                    $linha_usuario = (mysqli_fetch_array($retorno_usuario));


                    $id_avaliacao = $usuario['id'];
                    ?>
                    <ul class="timeline timeline-inverse">
                        <li class="time-label">
                            <span class="bg-red">
                                <?= date('d/m/Y', dataParse($usuario['data'])); ?>
                            </span>
                        </li>    
                        <li>

                            <div class="timeline-item">             


                                <div class="timeline-body" align="center">

                                    <table class="table table-striped planilha dataTable" >

                                        <h3 class="timeline-header">Avaliação do profissional <strong><?php echo htmlspecialchars($linha_usuario['nome']) ?> <?= htmlspecialchars($linha_usuario['sobrenome']); ?></strong></h3>


                            
                                                  
                                    <a class="btn btn-app" href="<?=URL_SITE?>form_mostrar_avaliacao.php?id_avaliacao='<?php echo$id_avaliacao;?>' & nome_aluno=<?php echo $nome_aluno; ?> & sobrenome_aluno=<?php echo $sobrenome_aluno; ?>"><i class="fa fa-eye"></i>Conferir</a> 
   

                                        
                                    </table>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php
                }
            }
            ?>

        </div>
         <div class="tab-pane<?php if ($aba == 'documentos') echo ' active'; ?>" id="documentos">
            <?php
        if (!empty($_SESSION['erro'])) {
            ?>
            <div class="alert alert-danger alert-dismissible" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo htmlspecialchars($_SESSION['erro']) ?>
            </div>
            <?php
            unset($_SESSION['erro']);
        }
        if (!empty($_SESSION['info'])) {
            ?>
            <div class="alert alert-info alert-dismissible" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo htmlspecialchars($_SESSION['info']) ?>
            </div>
            <?php
            unset($_SESSION['info']);
        } ?>
            <h3>Meus documentos</h3><hr>
            <?php 
            if(isset($_GET['alterar'])){
                $query_alterar = 'select * from documentos_historico where id='.mysqliEscaparTexto($_GET['alterar']).' and usuario_id='.$_SESSION['id'];
                $resultado_alt = mysqli_query($conexao, $query_alterar);
                if(mysqli_num_rows($resultado_alt)==0){
                    $_SESSION['erro'] = "Erro!";
                    header('Location: ' . URL_SITE . 'historico.php?aba=documentos');
                } else {
                    $linha_alt = mysqli_fetch_array($resultado_alt);
                }
            }
            if($linha_alt){
                echo 'batata';
            }
            
            ?>
            <div class="box">
                <form role="form" method="post" action="<?=URL_SITE?>addAnexo.php" enctype="multipart/form-data" style="padding: 5px;">                        
                                                     
                            <div class="form-inline">
                                <div class="form-group" style="padding: 5px;">
                                    <label for="titulo">Título</label>
                                    <input name="titulo" class="form-control" id="titulo" type="text" maxlength="150" <?= ($linha_alt) ? 'value="'.$linha_alt['titulo'].'"' : '' ?>>
                                </div>
                                <?php if($linha_alt){ ?>
                                <input type="hidden" name="alt_id" value="<?=$linha_alt['id']?>">
                                    <a href="histDoc.php?acao=view&id=<?=$linha_alt['id']?>" target="_blank">
                                                    <?php 
                                                    if($linha_alt['tipo']=='pdf'){
                                                       ?>
                                                    <i class="fa fa-file-pdf-o"></i>
                                                    <?php
                                                    }else if($linha_alt['tipo']=='png'||$linha_alt['tipo']=='jpg'||$linha_alt['tipo']=='jpeg'){
                                                        ?>
                                                    <i class="fa fa-file-image-o"></i>
                                                    <?php
                                                    }else if ($linha_alt['tipo']=='doc'||$linha_alt['tipo']=='txt') {
                                                        ?>
                                                    <i class="fa fa-file-text-o"></i>
                                                    <?php
                                                    }else{
                                                        ?>
                                                    <i class="fa fa-file"></i>
                                                    <?php
                                                    }
                                                    ?>
                                                    </a>
                                                    <?php
                                } ?>
                                <div class="form-group">
                                    <a class="btn btn-file btn-app" style="margin-top: 6px;">
                                         <i class="fa fa-file-o" ></i>
                                         <input type="file" name="anexo" id="anexo" accept=".xlsx,.xls,image/*,.doc, .ppt, .docx,.txt,.pdf"> Anexo </a>
                                </div>
                                <div class="form-group"  style="padding: 5px;" id="active_desc_dado"> 
                                    <input type="checkbox" id="check_desc_anexo" onclick="descricaoAnexo()" style="display: none;"><label for="check_desc_anexo" style="padding: 5px;"><b><i class="fa fa-angle-down" style="padding: 5px;"></i></b>Descrição</label>
                                    <textarea name="descricao" class="form-control" id="desc_anexo" style="display: none;" rows="2" cols="50"><?= ($linha_alt) ? $linha_alt['descricao'] : '' ?></textarea>                                         
                                </div><div class="form-group">
                                <?php if($linha_alt){ ?>
                                    <a href="historico.php?aba=documentos" style="padding: 10px" class="btn btn-block btn-google">Cancelar</a>
                                <?php }else{ ?>                                
                                    <input type="reset" style="padding: 10px" class="btn btn-block btn-google" value="Cancelar">
                                <?php } ?>
                                </div>
                                <div class="form-group">
                                    <input type="submit" style="padding: 10px" class="btn btn-block btn-info" <?= ($linha_alt) ? 'value="Alterar"' : 'value="Anexar"' ?>>
                                </div>
                            </div>
                            
                          
                    </form>
        </div>
            <?php
                $query_doc = "select * from documentos_historico where usuario_id=".$_SESSION['id']." order by data_add desc";
                $resultado_doc = mysqli_query($conexao, $query_doc);
                if(mysqli_num_rows($resultado_doc)==0){
                    ?>
                <div class="text-center"><h3><b>Nenhum documento anexado.</b></h3></div>
                <?php
                }else{
                    ?>
            <form role="form" method="post" action="<?=URL_SITE?>enviar_anexo.php" enctype="multipart/form-data" style="padding: 5px;"> 
            <?php
                $profissionais = dbquery("select
                    u.*
                from
                    vinculo v join
                    usuario u on u.id = v.profissional_id
                where
                    u.status = 'ativado' and
                    v.status = 'aprovado' and
                    v.aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . "
                order by
                    u.nome
                ");
                if (empty($profissionais)) $profissionais = array();
                    echo '<ul class="timeline timeline-inverse">';
                    $dataanterior = '';
                    $id_selecionado = 0;
                while($linha_doc= mysqli_fetch_array($resultado_doc)){
                    $dataatual = date('d/m/Y', dataParse($linha_doc['data_add']));
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
                                <i class="fa fa-folder bg-teal"></i>

                                <div class="timeline-item"> 
                                    <div class="timeline-body">
                                        <div class="table-responsive">
                                        <table class="table table-striped planilha dataTable">
                                            <tr>
                                                <th><i class="fa fa-check-square"></i></th>
                                                <th style="width: 450px;"><?php echo htmlentities($linha_doc['titulo']) ?></th>
                                                <th>Visualizar</th>
                                                <th>Download</th> 
                                                <th><i>Alterar</i></th>
                                                <th><i>Excluir</i></th>
                                                
                                            </tr>                                            
                                        <tr>
                                            <td><input type="checkbox" id="enviar<?php echo ++$id_selecionado?>" name="enviar[]" value="<?=$linha_doc['id']?>"> </td>
                                            <td><?= (!empty($linha_doc['descricao'])) ? htmlentities($linha_doc['descricao']) : '<i>Sem descrição</i>' ?></td>
                                            <td><a href="histDoc.php?acao=view&id=<?=$linha_doc['id']?>" target="_blank">
                                                    <?php 
                                                    if($linha_doc['tipo']=='pdf'){
                                                       ?>
                                                    <i class="fa fa-file-pdf-o"></i>
                                                    <?php
                                                    }else if($linha_doc['tipo']=='png'||$linha_doc['tipo']=='jpg'||$linha_doc['tipo']=='jpeg'){
                                                        ?>
                                                    <i class="fa fa-file-image-o"></i>
                                                    <?php
                                                    }else if ($linha_doc['tipo']=='doc'||$linha_doc['tipo']=='txt') {
                                                        ?>
                                                    <i class="fa fa-file-text-o"></i>
                                                    <?php
                                                    }else{
                                                        ?>
                                                    <i class="fa fa-file"></i>
                                                    <?php
                                                    }
                                                    ?>
                                                    </a></td>
                                            <td><a href="histDoc.php?acao=download&id=<?=$linha_doc['id']?>" ><i class="fa fa-download"></i></a></td>     
                                            <td><a href="historico.php?aba=documentos&alterar=<?=$linha_doc['id']?>"><i class="fa fa-edit"></i></a></td>
                                            <td><a data-toggle="modal" data-target="#deleteDoc" data-doc_id="<?=$linha_doc['id']?>" ><i class="fa fa-trash" style="font-size: 16px;"></i></a></td>
                                        </tr>                                       
                                    </table>
                                        </div>



                                </div>

                            </div>
                        </li> 
                        
                    
                <?php } ?>
                        
                <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li></ul>
            <div class="pull-right">
                        <a class="btn btn-app" type="button" data-toggle="modal" data-target="#modal-enviar_prof" id="modal-enviar_prof-button"><i class="fa fa-users"></i> Enviar </a>
                        </div>
                <?php } ?>
            
            <div class="clearfix"></div>
            <div class="modal fade" id="modal-enviar_prof">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Escolha o profissional</h4>
                        </div>
                        <div class="modal-body">
                            
                            <p><select class="form-control" name="profissional">
                                    <option value="">(Selecione um profissional)</option>
                                    <?php foreach ($profissionais as $value) { ?>
                                        <option value="<?php echo htmlspecialchars($value['id']); ?>"<?php if ($value['id'] == $profissional) echo ' selected="selected"' ?>><?php echo htmlspecialchars($value['nome'] . ' ' . $value['sobrenome']); ?></option>
                                    <?php } ?>
                                </select></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" href="#" role="button">Enviar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            
            
            
            
            
            
            
            </form>
        </div>
    </div>
</div>
</div> 
<!--</div>-->

<?php
require_once './template/rodape_especial.php';

