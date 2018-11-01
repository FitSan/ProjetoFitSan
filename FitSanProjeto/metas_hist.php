<h3>Histótico Metas - pesos e medidas</h3>
<?php
$query_all_meta = "select * from meta where status = 'finalizada' and usuario_id=" . $_SESSION['id'] . " order by data_final desc";
$retorno_all = mysqli_query($conexao, $query_all_meta);
$linha_all = array();
if (mysqli_num_rows($retorno_all) === 0) { ?>
    <div class="text-center"><h3><b>Não foi finalizada nenhuma meta até o momento.</b></h3></div>
    <?php
} else {
    while ($linha_all_meta = mysqli_fetch_array($retorno_all)) {
        array_push($linha_all, $linha_all_meta);
    }
    foreach ($linha_all as $linha) {
        $query_anos = "select EXTRACT(YEAR FROM data_add) as anos from dados_meta join meta on dados_meta.meta_id = meta.id where meta.id=" . $linha['id'] . " group by anos";
        $resultado_anos = mysqli_query($conexao, $query_anos);
        if (mysqli_num_rows($resultado_anos) > 1) {
            $anos = true;
        } else {
            $anos = false;
        }
        ?>
        <ul class="timeline timeline-inverse">
            <li class="time-label">
                <span class="bg-red">
                    <?= date('d/m/Y', dataParse($linha['data_final'])) ?>
                </span>
            </li>    
            <li>
                <i class="fa fa-thumbs-o-up bg-blue"></i>

                <div class="timeline-item">               
                    <span class="time"><?='<b>Peso inicial: '. $linha['peso_inicial'].'kg  |  Meta: '.$linha['peso_final'] .'kg</b>'?></span>
                    <h3 class="timeline-header"><strong><?= date('d M Y', dataParse($linha['data_inicial'])) . ' - ' . date('d M Y', dataParse($linha['data_final'])) ?></strong> <b class="label label-danger"><?php echo htmlentities($linha['tipo']) ?></b></h3>


                    <div class="timeline-body">

                        <table class="table table-striped planilha dataTable">
                            <tr>
                                <th>Mês</th>
                                <th>Avanço peso</th>
                                <th>Avanço meta</th>
                            </tr>                      
                            <?php
                            $query_meta = "select EXTRACT(YEAR_MONTH FROM data_add) as month, MAX(dados_meta.data_add) as max_data_add, dados_meta.data_add from meta join dados_meta on meta.id = dados_meta.meta_id"
                                    . " where meta.id=" . $linha['id'] . " group by EXTRACT(YEAR_MONTH FROM data_add)";
                            $resultado_meta = mysqli_query($conexao, $query_meta);
                            while ($linha_meta = mysqli_fetch_array($resultado_meta)) {
                                $query_max = "select peso_add - meta.peso_inicial as peso_inicial_dif, peso_add - meta.peso_final as meta_dif from dados_meta join meta on dados_meta.meta_id = meta.id where data_add='$linha_meta[max_data_add]' and meta_id=$linha[id]";
                                $resultado_max = mysqli_query($conexao, $query_max);
                                $linha_max = mysqli_fetch_array($resultado_max);
//        if($linha_meta['mes_dif']==0){
//            $alcancado = 'style = "background-color: 	#8FBC8F"';
//        }else{
//            $alcancado = '';
//        }
                                ?>

                                <tr>
                                    <td><?= ($anos) ? date('M/Y', dataParse($linha_meta['data_add'])) : date('M', dataParse($linha_meta['data_add'])) ?></td>
                                    <td><?=($linha_max['peso_inicial_dif']>0)?'+':'' ?><?= ($linha_max['peso_inicial_dif'] == 0) ? '<b>Medida inicial: </b>' . $linha['peso_inicial'] . 'kg' : $linha_max['peso_inicial_dif'] . 'kg' ?></td>
                                    <td><?= ($linha_max['meta_dif'] == 0) ? '<b>Meta alcançada</b>' : $linha_max['meta_dif'] . 'kg' ?></td>
                                </tr>


                            <?php }
                            ?>
                        </table>
                    </div>
                </div>
            </li>
        </ul>
        <?php
    }
}
?>