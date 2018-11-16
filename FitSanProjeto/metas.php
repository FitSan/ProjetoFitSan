<?php
$pagina = 'Metas';
require_once './template/cabecalho.php';
require_once './template/menu.php';

if (!tipoLogado("aluno")){
    header('Location: '.URL_SITE.'pagina1.php');
    exit;
}

$query = "select * from meta where usuario_id=" . $_SESSION['id'] . " and status='ativa'";
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
$linha = mysqli_fetch_array($resultado);

$query_all = "select * from meta where usuario_id=" . $_SESSION['id'] . " order by data_inicial desc";
$resultado_all = mysqli_query($conexao, $query_all) or die_mysql($query_all, __FILE__, __LINE__);



if (mysqli_num_rows($resultado) === 0) {
    $novaMeta = true;
//                      formulário inserção meta
} else {
    $novaMeta = false;
//                      mostrar meta atual e campo para cancelamento da meta
}
if (mysqli_num_rows($resultado_all) === 0) {
    $infoMeta = false;
} else {
    $infoMeta = true;
}
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1><?= $pagina ?></h1>
    </section>    
    <section class="content">
        <div class="col-md-12">
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
        }
        if (!empty($_SESSION['erro_data'])) {
            ?>
            <div class="alert alert-danger alert-dismissible" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo htmlspecialchars($_SESSION['erro_data']) ?>
            </div>
            <?php
            unset($_SESSION['erro_data']);
        }
        if (!empty($_SESSION['erro_peso'])) {
            ?>
            <div class="alert alert-danger alert-dismissible" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo htmlspecialchars($_SESSION['erro_peso']) ?>
            </div>
            <?php
            unset($_SESSION['erro_peso']);
        }
        ?>        
            <div class="box box-primary ">            
                <form class="form-inline" role="form" id="form_meta" method="post" action="<?=URL_SITE?>addMeta.php">
                    <div class="box-header with-border">
                        <?php if (!$novaMeta) {
                            ?> 
                            <div class="pull-right" style="margin-bottom: 5px;">                            
                                <button style="margin: 2px;" type="button" class="btn btn-sm" id="btnAlterarMeta" onclick="alterarMeta()"><b><i class="fa fa-edit" style="font-size:22px"></i></b></button>
                                <a data-toggle="modal" data-target="#deleteMeta" data-meta_id="<?= $linha['id'] ?>" data-dado_id="" class="btn btn-google" style="margin: 2px;"><i class="fa fa-trash" style="font-size:20px; padding: 0 3px"></i></a>
                                <a data-toggle="modal" data-target="#fimMeta" data-meta_id="<?= $linha['id'] ?>" class="btn btn-success" style="margin: 2px;">Finalizar Meta</a>
                            </div>

                            <?php
                        }
                        ?>
                        <h2 class="box-title" style="padding-right: 5px; "><b><?= ($novaMeta) ? 'Nova Meta' : 'Meta Atual' ?></b></h2> 
                        <select name="meta_tipo" id="meta_tipo" class="form-control" <?= $novaMeta ? '' : 'readonly' ?>>      
                            <option value="">Tipo da meta</option>
                            <option value="MANTER" <?php if ($linha['tipo'] == 'MANTER') echo ' selected'; ?>>Manter Peso</option>
                            <option value="PERDER" <?php if ($linha['tipo'] == 'PERDER') echo ' selected'; ?>>Perder Peso</option>
                            <option value="GANHAR" <?php if ($linha['tipo'] == 'GANHAR') echo ' selected'; ?>>Ganhar Peso</option>                                
                        </select>
                        <?php
                        if (!empty($_SESSION['erro_meta'])) {
                            ?>
                            <div>
                                <?php echo htmlspecialchars($_SESSION['erro_meta']) ?>
                            </div>
                            <?php
                            unset($_SESSION['erro_meta']);
                        }
                        ?>
                    </div>
                    <div class="box-body">   
                        <div class="form-inline">                        
                            <div class="form-group" style="padding: 5px;">
                                <label>Data inicial:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>                                    
                                    </div>
                                    <input type="text" class="form-control pull-right data_meta" id="data_inicial" name="data_inicial" autocomplete="off" value="<?= ($novaMeta) ? '' : date('d/m/Y', dataParse($linha['data_inicial'])) ?>" <?= $novaMeta ? '' : 'readonly' ?>>

                                </div>
                                <?php
                                if (!empty($_SESSION['erro_dataI'])) {
                                    ?>
                                    <div>
                                        <?php echo htmlspecialchars($_SESSION['erro_dataI']) ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['erro_dataI']);
                                }
                                ?>
                            </div>
                            <div class="form-group" style="padding: 5px;">
                                <label>Data término:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>                                    
                                    </div>
                                    <input type="text" class="form-control pull-right data_meta" id="data_final" name="data_final" autocomplete="off" value="<?= ($novaMeta) ? '' : date('d/m/Y', dataParse($linha['data_final'])) ?>" <?= $novaMeta ? '' : 'readonly' ?>>

                                </div>
                                <?php
                                if (!empty($_SESSION['erro_dataF'])) {
                                    ?>
                                    <div>
                                        <?php echo htmlspecialchars($_SESSION['erro_dataF']) ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['erro_dataF']);
                                }
                                ?>
                            </div>
                            <div class="form-group" style="padding: 5px;">
                                <label style="padding: 4px 3px 4px 0;">Peso atual:</label> 
                                <div class="form-group">                                                               
                                    <input type="number" class="form-control" id="peso_inicial" name="peso_inicial" step="0.001" min="0" value="<?= ($novaMeta) ? '' : $linha['peso_inicial'] ?>" <?= $novaMeta ? '' : 'readonly' ?>>
                                </div>
                                <?php
                                if (!empty($_SESSION['erro_pesoI'])) {
                                    ?>
                                    <div>
                                        <?php echo htmlspecialchars($_SESSION['erro_pesoI']) ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['erro_pesoI']);
                                }
                                ?>
                            </div>
                            <div class="form-group" style="padding: 5px;">
                                <label style="padding: 4px 3px 4px 0;">Meta de peso:</label> 
                                <div class="form-group">                                                      
                                    <input type="number" class="form-control" id="peso_final" name="peso_final" step="0.001" min="0" value="<?= ($novaMeta) ? '' : $linha['peso_final'] ?>" <?= $novaMeta ? '' : 'readonly' ?>>
                                </div>
                                <?php
                                if (!empty($_SESSION['erro_pesoF'])) {
                                    ?>
                                    <div>
                                        <?php echo htmlspecialchars($_SESSION['erro_pesoF']) ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['erro_pesoF']);
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                        if ($novaMeta) {
                            ?>
                            <div class="pull-right" style="padding: 5px;">
                                <button type="submit" class="btn btn-block btn-adn" style=" padding: 15px 35px">Iniciar Meta</button>
                            </div>
                        <?php } ?>
                        <div class="form-inline pull-right" id="btnSubmit" style="padding: 5px; display: none;">
                            <div class="form-group">
                                <button type="reset" class="btn btn-block btn-danger" style="padding: 15px" onclick="cancelAlteracao()">Cancelar</button>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-info" style="padding: 15px 35px;" onclick="submitAlteracao()">Salvar Meta</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="col-md-3">
            <?php if (!$novaMeta) { ?>

                <div class="box box-primary">
                    <form role="form" method="post" action="<?=URL_SITE?>add_dados_meta.php">
                        <div class="box-header with-border">
                            <h2 class="box-title" style="padding: 7px;"><b>Adicionar dados</b></h2> 
                        </div>
                        <div class="box-body">  
                            <input type="hidden" name="meta_id" value="<?= $linha['id'] ?>">
                            <div class="form-inline">
                                <div class="form-group" style="padding: 5px;">
                                    <label>Data:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>                                    
                                        </div>
                                        <input type="text" class="form-control data_meta" id="data_dado_meta" autocomplete="off" name="data_dado_meta">
                                    </div>
                                </div>
                                <div class="form-group" style="padding: 5px;">
                                    <label style="padding: 4px 3px 4px 0;">Peso:</label>                            
                                    <input type="number" class="form-control" id="peso" name="peso" step="0.001" min="0">
                                </div>
                            </div>
                            <div class="form-group"  style="padding: 5px;" id="active_desc_dado"> 
                                <input type="checkbox" id="check_desc_dado" onclick="descricaoDado()" style="display: none;"><label for="check_desc_dado"><b><i class="fa fa-angle-down" style="padding: 5px;"></i></b>Descrição</label>

                                <textarea name="descricao_dado" class="form-control round" id="desc_dado" style="display: none;" rows="2" ></textarea>                                        
                            </div>
                            <div class="form-group">
                                <input type="submit" style="margin-top: 10px; padding: 10px" class="btn btn-block btn-google pull-right" value="Adicionar dado à meta">
                            </div>
                        </div>
                    </form>
                </div>
                <?php
            }
            ?>
        </div> 
        <?php
        if ($infoMeta) {
            ?>
            <div class="col-md-6">
                <div class="box box-primary" id="metasDiv" style="height: auto; <?php if ($novaMeta) echo 'display: none;' ?>">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right ui-sortable-handle">
                            <li class="active"><a href="#mensal"  data-toggle="tab">Mensal</a></li>
                            <li class=""><a href="#anual"  data-toggle="tab">Anual</a></li>
                            <li class="pull-left header"><i class="fa fa-inbox"></i>Gráfico Meta</li>
                        </ul>
                        <div class="tab-content no-padding">    

                            <div class="tab-pane active" id="mensal">
                                <div id="mensal_select">
                                    <?php
                                    include 'select_mes_grafico_meta.php';
                                    ?> 
                                </div>
                                <div id="mensal_chart">
                                    <?php
                                    include 'chart_meta_mensal.php';
                                    ?> 
                                </div>
                            </div>
                            <div class="tab-pane " id="anual">
                                <?php
                                include 'chart_meta_anual.php';
                                ?>                     
                            </div>
                        </div>
                    </div>                       
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title" style="padding: 7px;"><b>Visualizar dados</b></h2> 
                    </div>
                    <div class="box-body">  
                        <form class="form-inline" role="form" method="post">
                            <input type="hidden" id="id_atual" value="<?= $linha['id'] ?>">
                            <label style="padding: 4px 3px 4px 0;">Histórico: </label>
                            <select name="meta_id" id="meta_id" class="form-control">
                                <option value="<?= $linha['id'] ?>">Selecione uma meta</option>
                                <?php
                                while ($linha_all = mysqli_fetch_array($resultado_all)) {
                                    ?>
                                    <option value="<?= $linha_all['id'] ?>"><?= ($linha_all['status'] != 'ativa') ? date('d M', dataParse($linha_all['data_inicial'])) . ' - ' . date('d M', dataParse($linha_all['data_final'])) : 'Meta atual' ?></option>
                                    <?php
                                }
                                ?>  
                            </select>
                            <br>
                            <!--                                SELECIONAR VER OU NÃO O GRÁFICO DO HISTÓRICO-->
                            <!--                                <div id="check_grafico" style="display: none;"><label for="graficoDados" class="pull-right" style="cursor: pointer;"><i class="fa fa-angle-down" style="padding: 5px;"></i><b><i class="fa fa-line-chart" style="padding: 4px 6px 0 6px; font-size: 20px"></i></b></label><input type="checkbox" class="icheckbox_minimal-grey pull-right" id="graficoDados" onclick="descricaoDado()" style="display: none;"></div>-->



                            <!--                            <div class="form-group">
                                                            <input type="submit" id="view_dados" style="padding: 10px; margin: 5px 0;" class="pull-right btn btn-block btn-google " value="Visualizar">
                                                        </div>-->

                        </form>
                    </div>
                </div> 

                <div id="dados_meta">

                </div>
            </div>
        <?php }
        ?>
    </section>

    <?php
    include './template/rodape_especial.php';
    ?>