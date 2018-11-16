<h3>Histótico Metas - pesos e medidas</h3>
<?php
if(isset($_GET['privado'])){
    $query_view = "update meta set visualizacao='PRIVADO' where id='".$_GET['privado']."'";
    mysqli_query($conexao, $query_view);
}
if(isset($_GET['publico'])){
    $query_view = "update meta set visualizacao='PUBLICO' where id='".$_GET['publico']."'";
    mysqli_query($conexao, $query_view);
}
$query_all_meta = "select * from meta where status = 'finalizada' and usuario_id=" . $_SESSION['id'] . " order by data_final desc";
$retorno_all = mysqli_query($conexao, $query_all_meta);
$linha_all = array();
if (mysqli_num_rows($retorno_all) === 0) {
    ?>
    <div class="text-center"><h3><b>Não foi finalizada nenhuma meta até o momento.</b></h3></div>
    <?php
} else {
    while ($linha = mysqli_fetch_array($retorno_all)) {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $query_meses = "select MAX(data_add) as data_add, EXTRACT(YEAR_MONTH FROM data_add) as meses from dados_meta where meta_id= " . $linha['id'] . " group by meses order by meses desc";
        $resultado_meses = mysqli_query($conexao, $query_meses) or die_mysql($query_meses, __FILE__, __LINE__);
        ?>
        <ul class="timeline timeline-inverse col-12">
            <li class="time-label">
                <span class="bg-red">
                    <?= date('d/m/Y', dataParse($linha['data_final'])) ?>
                </span>
            </li>    
            <li>
                <i class="fa fa-thumbs-o-up bg-blue"></i>

                <div class="timeline-item">               
                    <span class="time col-md-5 col-sm-5 col-xs-12"><?= '<b style="float: right;">Peso inicial: ' . $linha['peso_inicial'] . 'kg  |  Meta: ' . $linha['peso_final'] . 'kg</b>' ?></span>
                    <h3 class="timeline-header"><strong><?= date('d M Y', dataParse($linha['data_inicial'])) . ' - ' . date('d M Y', dataParse($linha['data_final'])) ?></strong> <b class="label label-danger"><?php echo htmlentities($linha['tipo']) ?></b><?php
                                    if ($linha['visualizacao'] == 'PUBLICO'){
                                        ?><a class="btn btn-xs" href="?privado=<?= htmlentities($linha['id']) ?>&aba=pesosMedidas"><i class="fa fa-unlock-alt" style="font-size: 16px;"></i><?php
                                    } else {
                                        ?><a class="btn btn-xs" href="?publico=<?= htmlentities($linha['id']) ?>&aba=pesosMedidas"><i class="fa fa-lock" style="font-size: 16px;"></i><?php
                                    }
                                ?></a></h3>
                    

                    <div class="timeline-body col-md-12 col-sm-12 col-xs-12">
                        <div class="col-sm-7 col-md-8 col-xs-12" id="<?= 'div'.$linha['id']?>">                            
                            <?php
                                include 'chart_meta_hist.php';
                            ?>
                        </div>
                        <div class="col-sm-5 col-md-4 col-xs-12" style="overflow-x: auto; white-space: nowrap;">
                            
                                <select name="<?= $linha['id']?>" id="<?= 'mes_hist'.$linha['id']?>" class="form-control mes_hist" >
                                    <option value="">Filtre por mês</option>
                                    <?php
                                    while ($linha_meses = mysqli_fetch_array($resultado_meses)) {
                                        ?>
                                        <option value="<?= $linha_meses['meses'] ?>"><?= ($anos) ? date('M - Y', dataParse($linha_meses['data_add'])) : ucfirst( utf8_encode( strftime("%B", strtotime($linha_meses['data_add']) ) ) ) ?></option>
                                        <?php
                                    }
                                    ?>  
                                </select>
                            <table class="table table-striped planilha dataTable">
                                <tr>
                                    <th>Mês</th>
                                    <th>Avanço peso</th>
                                    <th>Avanço meta</th>
                                </tr>                      
                                <?php
                                $query_dados = "select EXTRACT(YEAR_MONTH FROM data_add) as month, MAX(dados_meta.data_add) as max_data_add, dados_meta.data_add from meta join dados_meta on meta.id = dados_meta.meta_id"
                                    . " where meta.id=" . $linha['id'] . " group by EXTRACT(YEAR_MONTH FROM data_add)";
                                $resultado_dados = mysqli_query($conexao, $query_dados);
                                while ($linha_dados = mysqli_fetch_array($resultado_dados)) {
                                    $query_max = "select peso_add - meta.peso_inicial as peso_inicial_dif, peso_add - meta.peso_final as meta_dif from dados_meta join meta on dados_meta.meta_id = meta.id where data_add='$linha_dados[max_data_add]' and meta_id=$linha[id]";
                                    $resultado_max = mysqli_query($conexao, $query_max);
                                    $linha_max = mysqli_fetch_array($resultado_max);
//        if($linha_meta['mes_dif']==0){
//            $alcancado = 'style = "background-color: 	#8FBC8F"';
//        }else{
//            $alcancado = '';
//        } 
                                    $explode = explode('.', $linha_max['meta_dif']);
                                    if ($explode[1]!==0){
                                       $meta_dif = $explode[0];
                                    }else{
                                        $meta_dif = $linha_max['meta_dif'];
                                    }
                                    $explode = explode('.', $linha_max['peso_inicial_dif']);
                                    if ($explode[1]!==0){
                                       $peso_inicial_dif = $explode[0];
                                    }else{
                                        $peso_inicial_dif = $linha_max['peso_inicial_dif'];
                                    }
                                    ?>

                                    <tr>
                                        <td><?= ($anos) ? date('M/Y', dataParse($linha_dados['data_add'])) : date('M', dataParse($linha_dados['data_add'])) ?></td>
                                        <td><?= ($peso_inicial_dif > 0) ? '+' : '' ?><?= ($peso_inicial_dif == 0) ? '<b style="color: orange">' .'0kg' : $peso_inicial_dif . 'kg' ?><?=($peso_inicial_dif == 0) ? '</b>' : '' ?></td>
                                        <td><?= ($meta_dif == 0) ? '<i class="fa fa-check" style="font-size: 18px; color: green;"></i>' : $meta_dif . 'kg' ?></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <?php
    }
}
?>
