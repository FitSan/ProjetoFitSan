<?php
require_once './autenticacao.php';

$query_anual = "select meta.*, dados_meta.data_add, MONTH(meta.data_final) as mes_final, sum(dados_meta.peso_add) as pesoTotal, MONTH(dados_meta.data_add) as mes, count(dados_meta.id) as quant_dados from dados_meta join meta on meta.id=dados_meta.meta_id where meta.usuario_id = ".$_SESSION['id']." and meta.status='ativa' group by mes";
$resultado_anual = mysqli_query($conexao, $query_anual);

$datas = array();
$pesos = array();
$meta = array();
while ($linha_anual = mysqli_fetch_array($resultado_anual)){
    if(mysqli_num_rows($resultado_anual)===1){
        $datas[] = '';
        $pesos[] = round($linha_anual['pesoTotal']/$linha_anual['quant_dados'],3);
        $meta[] = $linha_anual['peso_final'];
    }
    $datas[] = ($linha_anual['mes_final']==$linha_anual['mes'])? 'Fim: '.date('M', dataParse($linha_anual['data_add'])):date('M', dataParse($linha_anual['data_add'])) ;
    $pesos[] = round($linha_anual['pesoTotal']/$linha_anual['quant_dados'], 3);
    $meta[] = $linha_anual['peso_final'];
}

?>


<canvas id="chartAnual"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
                    var ctx = document.getElementById('chartAnual').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'line',

                        // The data for our dataset
                        data: {
                                labels: [<?php foreach ($datas as $data){                                    
                                    echo "'".$data."', ";
                                }                
                                ?>],
                            datasets: [{
                                label: "Peso",
                                backgroundColor: 'transparent',
                                borderColor: 'rgb(70, 120, 450)',
                                data: [<?php foreach ($pesos as $peso){
                                    echo $peso.", ";
                                }
?>]
                            },
                            {
                                label: "Meta",
                                backgroundColor:' transparent',
                                borderColor: 'rgb(255, 99, 132)',
                                data: [<?php foreach ($meta as $meta_x){
                                    echo $meta_x.", ";
                                }?>]
                            }]
                        }
                    });
</script>
