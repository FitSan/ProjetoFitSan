<?php
require_once './autenticacao.php';
if (isset($_POST['meta_id'])) {
    $where = " meta.id=" . mysqli_real_escape_string($_POST['meta_id']);
} else {
    $where = " meta.usuario_id = " . $_SESSION['id'] . " and meta.status='ativa'";
}
$query_anos = "select EXTRACT(YEAR FROM data_add) as anos from dados_meta join meta on dados_meta.meta_id = meta.id where " . $where . " group by anos";
$resultado_anos = mysqli_query($conexao, $query_anos);
if (mysqli_num_rows($resultado_anos) > 1) {
    $anos = true;
} else {
    $anos = false;
}

$query_anual = "
            select
                meta.*,
                EXTRACT(YEAR_MONTH FROM data_final) as mes_final,
                d.*
            from
                meta join
                (select
                    dados_meta.meta_id,
                    MAX(dados_meta.data_add) as data_add,
                    AVG(dados_meta.peso_add) as pesoMedia,
                    EXTRACT(YEAR_MONTH FROM data_add) as mes
                from
                    dados_meta
                group by
                    dados_meta.meta_id,
                    mes
                ) as d on meta.id = d.meta_id
            where 
                $where
            order by
                mes
            ";
// O MySQL já faz o cálculo da média dos pesos basta colocar no lugar do SUM a função AVG e assim o cálculo da média abaixo não é necessário.

$resultado_anual = mysqli_query($conexao, $query_anual) or die_mysql($query_anual, __FILE__, __LINE__);

$datas = array();
$pesos = array();
$meta = array();
while ($linha_anual = mysqli_fetch_array($resultado_anual)) {
    if (mysqli_num_rows($resultado_anual) === 1) {
        $datas[] = '';
        $pesos[] = round(numeroParse($linha_anual['pesoMedia']), 3); // Este cálculo nao é necessário se usar o AVG no SQL
        $meta[] = numeroParse($linha_anual['peso_final']);
    }
    $datas[] = ($anos) ? date('M/Y', dataParse($linha_anual['data_add'])) : date('M', dataParse($linha_anual['data_add']));
    $pesos[] = round(numeroParse($linha_anual['pesoMedia']), 3); // Este cálculo nao é necessário se usar o AVG no SQL
    $meta[] = numeroParse($linha_anual['peso_final']);
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
            labels: [<?php
foreach ($datas as $i => $data) {
    if ($i > 0)
        echo ", "; // Isto é necessário para não colocar uma vírgula no final da lista pois da erro em alguns navegadores
    echo json_encode($data); // Esta função já converte o valor em javascript
}
?>],
            datasets: [{
                    label: "Peso",
                    backgroundColor: 'transparent',
                    borderColor: 'rgb(70, 120, 450)',
                    data: [<?php
foreach ($pesos as $i => $peso) {
    if ($i > 0)
        echo ", "; // Isto é necessário para não colocar uma vírgula no final da lista pois da erro em alguns navegadores
    echo json_encode($peso); // Esta função já converte o valor em javascript
}
?>]
                },
                {
                    label: "Meta",
                    backgroundColor: 'transparent',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [<?php
foreach ($meta as $i => $meta_x) {
    if ($i > 0)
        echo ", "; // Isto é necessário para não colocar uma vírgula no final da lista pois da erro em alguns navegadores
    echo json_encode($meta_x); // Esta função já converte o valor em javascript
}
?>]
                }]
        }
    });
</script>
