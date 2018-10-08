<?php
$pagina = 'Metas';
include './template/cabecalho.php';

$query = "select * from meta where usuario_id=" . $_SESSION['id'] . " and status='ativa'";
$resultado = mysqli_query($conexao, $query);
$linha = mysqli_fetch_array($resultado);

$query_all = "select * from meta where usuario_id=" . $_SESSION['id'] . " order by data_inicial desc";
$resultado_all = mysqli_query($conexao, $query_all);

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
    <div class="col-md-12">
    <section class="content-header">
        <h1><?= $pagina ?></h1>
    </section>    
    <section class="content">
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
            <form class="form-inline" role="form" method="post" action="addMeta.php">
                <div class="box-header with-border">
                    <?php if (!$novaMeta) {
                        ?> 
                        <div class="pull-right" style="margin-bottom: 5px;">                            
<!--                            <a href="form_alterarMeta.php?id=<?= $linha['id'] ?>"><button style="margin: 2px;" type="button" class="btn btn-sm" ><b><i class="fa fa-edit" style="font-size:22px"></i></b></button></a>-->
                            <a href="cancelMeta.php?id=<?= $linha['id'] ?>" class="btn btn-google" style="margin: 2px;">Cancelar Meta</a>
                        </div>

                        <?php
                    }
                    ?>
                    <h2 class="box-title" style="padding-right: 5px; "><b><?= ($novaMeta) ? 'Nova Meta' : 'Meta Atual' ?></b></h2> 
                    <select name="meta_tipo" class="form-control" <?= $novaMeta ? '' : 'disabled' ?>>                                             
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
                                <input type="text" class="form-control pull-right data_meta" id="data_inicial" name="data_inicial" value="<?= ($novaMeta) ? '' : date('d/m/Y', dataParse($linha['data_inicial'])) ?>" <?= $novaMeta ? '' : 'disabled' ?>>
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
                        </div>
                        <div class="form-group" style="padding: 5px;">
                            <label>Data término:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>                                    
                                </div>
                                <input type="text" class="form-control pull-right data_meta" id="data_final" name="data_final" value="<?= ($novaMeta) ? '' : date('d/m/Y', dataParse($linha['data_inicial'])) ?>" <?= $novaMeta ? '' : 'disabled' ?>>
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
                        </div>
                        <div class="form-group" style="padding: 5px;">
                            <label style="padding: 4px 3px 4px 0;">Peso atual:</label>                            
                            <input type="number" class="form-control pull-right" id="peso_inicial" name="peso_inicial" step="0.001" min="0" value="<?= ($novaMeta) ? '' : $linha['peso_inicial'] ?>" <?= $novaMeta ? '' : 'disabled' ?>>
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
                        </div>kg
                        <div class="form-group" style="padding: 5px;">
                            <label style="padding: 4px 3px 4px 0;">Meta de peso:</label>                            
                            <input type="number" class="form-control pull-right" id="peso_finial" name="peso_final" step="0.001" min="0" value="<?= ($novaMeta) ? '' : $linha['peso_final'] ?>" <?= $novaMeta ? '' : 'disabled' ?>>
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
                        </div>kg

                    </div>
                    <?php
                    if ($novaMeta) {
                        ?>
                        <div class="pull-right" style="padding: 5px;">
                            <button type="submit" class="btn btn-block btn-adn" style=" padding: 15px 35px">Iniciar Meta</button>
                        </div>
                    <?php } ?>
                </div>

            </form>
        </div>

        <?php if (!$novaMeta) { ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <form role="form" method="post" action="add_dados_meta.php">
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
                                        <input type="text" class="form-control pull-right data_meta" id="data_dado_meta" name="data_dado_meta">
                                    </div>
                                </div>
                                <div class="form-group" style="padding: 5px;">
                                    <label style="padding: 4px 3px 4px 0;">Peso:</label>                            
                                    <input type="number" class="form-control pull-right" id="peso" name="peso" step="0.001" min="0">
                                </div>kg
                            </div>
                            <div class="form-group">
                                <input type="submit" style="margin-top: 10px; padding: 10px" class="btn btn-block btn-google pull-right" value="Adicionar dado à meta">
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                        include 'grafico_meta.php';
                     
                        ?>
                <div class="box box-primary">
                    
                    <div class="nav-tabs-custom" style="cursor: move;">
                        <ul class="nav nav-tabs pull-right ui-sortable-handle">
                            <li class="active"><a href="#mensal_chart" data-toggle="tab">Mensal</a></li>
                            <li class=""><a href="#anual_chart" data-toggle="tab">Anual</a></li>
                            <li class="pull-left header"><i class="fa fa-inbox"></i>Gráfico Meta Atual</li>
                        </ul>
                        <div class="tab-content no-padding">          
                            <div class="tab-pane active" id="mensal_chart" style="height: 250px"></div>
                            <div class="tab-pane " id="anual_chart" style="height: 250px"></div>
                        </div>
                        
                    </div>
                </div>
            </div>  
            <?php
        }
        if ($infoMeta) {
            ?>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title" style="padding: 7px;"><b>Visualizar dados</b></h2> 
                    </div>
                    <div class="box-body">  
                        <form class="form-inline" role="form" method="post" action="<?php echo basename(__FILE__) ?>">
                            <label style="padding: 4px 3px 4px 0;">Histórico: </label>
                            <select name="meta_id" class="form-control">
                                <?php
                                while ($linha_all = mysqli_fetch_array($resultado_all)) {
                                    ?>
                                    <option value="<?= $linha_all['id'] ?>"><?= ($linha_all['status'] != 'ativa') ? date('M', dataParse($linha_all['data_inicial'])) . '-' . date('M', dataParse($linha_all['data_final'])) : 'Meta atual' ?></option>
                                    <?php
                                }
                                ?>  
                            </select>    
                            <div class="form-group">
                                <input type="submit" style="padding: 10px; margin: 5px 0;" class="pull-right btn btn-block btn-google " value="Visualizar">
                            </div>

                        </form>
                    </div>
                </div>
            </div>     
            <?php
            if (!empty($_POST['meta_id'])) {
                $query_meta_id = "select * from meta where id=$_POST[meta_id]";
                $resultado_meta_id = mysqli_query($conexao, $query_meta_id);
                $linha_meta_id = mysqli_fetch_array($resultado_meta_id);
                $query_dados = "select * from dados_meta where meta_id=$_POST[meta_id] order by data_add";
                $resultado_dados = mysqli_query($conexao, $query_dados);
                ?>
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h2 class="box-title" style="padding: 7px;"><b><?= date('d M Y', dataParse($linha_meta_id['data_inicial'])) . ' - ' . date('d M Y', dataParse($linha_meta_id['data_final'])) ?></b></h2> 
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                                        title="Minimizar">
                                    <i class="fa fa-minus" style="font-size: 8px;"></i></button>                            

                                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                        title="Fechar">
                                    <i class="fa fa-times" style="font-size: 8px;"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td style="padding: 5px;"><?= date('d M Y', dataParse($linha_meta_id['data_inicial'])) ?></td>
                                    <td style="padding: 5px;"><?= $linha_meta_id['peso_inicial'] ?>kg</td>
                                </tr>
                                <?php 
                                    while ($linha_dados = mysqli_fetch_array($resultado_dados)) {
                                        ?>
                                        <tr>
                                            <td style="padding: 5px;"><?= date('d M Y', dataParse($linha_dados['data_add'])) ?></td>
                                            <td style="padding: 5px;"><?= $linha_dados['peso_add'] ?>kg</td>
                                        </tr>
                                        <?php
                                    }                                
                                ?>
                            </table>    
                            <div class="box-footer">

                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        <?php } ?>
    </section>
</div>
    <?php
    include './template/rodape_especial.php';
    ?>