<?php
require_once './autenticacao.php';

if (isset($_POST['meta_id'])) {
    $query_meta = "select *, MONTH(data_final) as mes_final from meta where id=" . $_POST['meta_id'];
} else {
    $query_meta = "select *, MONTH(data_final) as mes_final from meta where usuario_id = " . $_SESSION['id'] . " and status='ativa'";
}
$resultado_meta = mysqli_query($conexao, $query_meta) or die_mysql($query_meta, __FILE__, __LINE__);
$linha_meta = mysqli_fetch_array($resultado_meta);
$query_anos = "select EXTRACT(YEAR FROM data_add) as anos from dados_meta join meta on dados_meta.meta_id = meta.id where meta.id=".$linha_meta['id']." group by anos";
$resultado_anos = mysqli_query($conexao, $query_anos);
if(mysqli_num_rows($resultado_anos)>1){
    $anos = true;
}else{
    $anos = false;
}
$query_meses = "select MAX(data_add) as data_add, EXTRACT(YEAR_MONTH FROM data_add) as meses from dados_meta where meta_id= " . (!empty($linha_meta['id']) ? $linha_meta['id'] : 0) . " group by meses order by meses desc";
$resultado_meses = mysqli_query($conexao, $query_meses) or die_mysql($query_meses, __FILE__, __LINE__);
?>
<div class="box-body">  
    <form class="form-inline" role="form" method="post" action="<?=URL_SITE?><?php echo basename(__FILE__) ?>">
        <label style="padding: 4px 3px 4px 0;">Mês: </label>
        <select name="dado_mes" id="dado_mes" class="form-control">
        <?php
        while ($linha_meses = mysqli_fetch_array($resultado_meses)) {
            ?>
            <option value="<?= $linha_meses['meses'] ?>"><?= ($anos) ? date('M - Y', dataParse($linha_meses['data_add'])) : date('M', dataParse($linha_meses['data_add']))?></option>
                <?php
            }
            ?>  
        </select>    
        <!--                                            <div class="form-group">
                                                        <input type="submit" id="view_dados" style="padding: 10px; margin: 5px 0;" class="pull-right btn btn-block btn-google " value="Visualizar">
                                                    </div>-->

    </form>
</div>
<script>
        $('#dado_mes').change(function(){
            var dado_mes = $(this).val();
            var meta_id = $("#meta_id").val();
            $.ajax({
                url: "chart_meta_mensal.php",
                method: "POST",
                data:{dado_mes:dado_mes, meta_id:meta_id},
                success:function(data){
                    $('#mensal_chart').html(data);          
                    
                }
            });            
        });
</script>