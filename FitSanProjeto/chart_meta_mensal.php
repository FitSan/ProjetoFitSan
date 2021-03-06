<?php
require_once './autenticacao.php';
//header('Content-Type: application/json');
//$mes_dado = 10;

if (isset($_POST['meta_id'])) {
    $query_meta = "select *, MONTH(data_final) as mes_final from meta where id=" . $_POST['meta_id'];
} else {
    $query_meta = "select *, MONTH(data_final) as mes_final from meta where usuario_id = " . $_SESSION['id'] . " and status='ativa'";
}

$resultado_meta = mysqli_query($conexao, $query_meta) or die_mysql($query_meta, __FILE__, __LINE__);
$linha_meta = mysqli_fetch_array($resultado_meta);

if (isset($_POST['dado_mes'])) {
    $mes_dado = $_POST['dado_mes'];
} else {
    $query_mes_dado = "select EXTRACT(YEAR_MONTH FROM data_add) as meses from dados_meta where meta_id= $linha_meta[id] group by meses order by meses desc";
    $resultado_mes_dado = mysqli_query($conexao, $query_mes_dado);
    $linha_mes_dado = mysqli_fetch_array($resultado_mes_dado);
    $mes_dado = $linha_mes_dado['meses'];
}
//echo $query_meta;
//$ultimo_dado = array();
//if($mes_dado == $linha_meta['mes_final']){
//    $ultimo_dado[data_add] = 'Fim: '.$linha_meta['data_final'];
//    $ultimo_dado[peso_add] = $linha_meta['peso_final'];
//}
//$query_anual = "select data_add, peso_add, sum(peso_add) as pesoTotal, MONTH(data_add) as mes, count(id) as quant_dados from dados_meta where meta_id = ".$linha_meta['id'];
//$resultado_anual = mysqli_query($conexao, $query_anual);

$query_mensal = "select dados_meta.data_add, dados_meta.peso_add, meta.peso_final from dados_meta join meta on dados_meta.meta_id=meta.id where EXTRACT(YEAR_MONTH FROM data_add) = $mes_dado and meta_id=" . $linha_meta['id'] . " order by dados_meta.data_add asc";
$resultado_mensal = mysqli_query($conexao, $query_mensal);
//echo $query_mensal;

$datas = array();
$pesos = array();
$meta = array();
while ($linha_mensal = mysqli_fetch_array($resultado_mensal)) {
    if (mysqli_num_rows($resultado_mensal) == 1) {
        $datas[] = '';
        $pesos[] = $linha_mensal['peso_add'];
        $meta[] = $linha_meta['peso_final'];
    }
    $datas[] = ($linha_mensal['data_add'] == $linha_meta['data_final']) ? 'Fim: ' . date('d/M', dataParse($linha_mensal['data_add'])) : date('d/M', dataParse($linha_mensal['data_add']));
    $pesos[] = $linha_mensal['peso_add'];
    $meta[] = $linha_meta['peso_final'];
}

$query_meses = "select data_add, EXTRACT(YEAR_MONTH FROM data_add) as meses from dados_meta where meta_id= " . $linha_meta['id'] . " group by meses order by meses desc";
$resultado_meses = mysqli_query($conexao, $query_meses);
?>
<canvas id="chartMensal"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('chartMensal').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: [<?php
            foreach ($datas as $data) {
                echo "'" . $data . "', ";
            }
            ?>],
            datasets: [{
                    label: "Peso",
                    backgroundColor: 'transparent',
                    borderColor: 'rgb(70, 120, 450)',
                    data: [<?php
            foreach ($pesos as $peso) {
                echo $peso . ", ";
            }
            ?>]
                },
                {
                    label: "Meta",
                    backgroundColor: 'transparent',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [<?php
            foreach ($meta as $meta_x) {
                echo $meta_x . ", ";
            }
            ?>]
                }]
        }
    });
</script>
