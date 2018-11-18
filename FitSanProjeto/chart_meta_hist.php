<?php
require_once './autenticacao.php';

if(isset($_POST['meta_id'])){
    $query_meta_id = "select *, MONTH(data_final) as mes_final from meta where id=" . mysqliEscaparTexto($_POST['meta_id']);
}else{
    $query_meta_id = "select *, MONTH(data_final) as mes_final from meta where id=" . $linha['id'];
}
$resultado_meta_id = mysqli_query($conexao, $query_meta_id);
$linha_meta_id = mysqli_fetch_array($resultado_meta_id);
$query_anos = "select EXTRACT(YEAR FROM data_add) as anos from dados_meta join meta on dados_meta.meta_id = meta.id where meta.id=" . $linha_meta_id['id'] . " group by anos";
$resultado_anos = mysqli_query($conexao, $query_anos);
if (mysqli_num_rows($resultado_anos) > 1) {
    $anos = true;
} else {
    $anos = false;
}
$datas = array();
$pesos = array();
$meta = array();

if (!empty($_POST['mes'])) {
    $query_meta = "select dados_meta.data_add, dados_meta.peso_add, meta.peso_final from dados_meta join meta on dados_meta.meta_id=meta.id where EXTRACT(YEAR_MONTH FROM data_add) ='". $_POST['mes']."' and meta_id=" . htmlspecialchars($linha_meta_id['id']) . " order by dados_meta.data_add asc";
    $resultado_meta = mysqli_query($conexao, $query_meta);
    while ($linha_meta = mysqli_fetch_array($resultado_meta)) {
        if (mysqli_num_rows($resultado_meta) == 1) {
            $datas[] = '';
            $pesos[] = htmlspecialchars($linha_meta['peso_add']);
            $meta[] = htmlspecialchars($linha_meta_id['peso_final']);
        }
        $datas[] = (htmlspecialchars($linha_meta['data_add']) == htmlspecialchars($linha_meta_id['data_final'])) ? 'Fim: ' . date('d/M', dataParse(htmlspecialchars($linha_meta['data_add']))) : date('d/M', dataParse(htmlspecialchars($linha_meta['data_add'])));
        $pesos[] = htmlspecialchars($linha_meta['peso_add']);
        $meta[] = htmlspecialchars($linha_meta_id['peso_final']);
        
    }
} else {
    $query_meta = "
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
                meta.id=".htmlspecialchars($linha_meta_id['id'])."
            order by
                mes
            ";
    $resultado_meta = mysqli_query($conexao, $query_meta) or die_mysql($query_meta, __FILE__, __LINE__);
    while ($linha_meta = mysqli_fetch_array($resultado_meta)) {
        if (mysqli_num_rows($resultado_meta) === 1) {
            $datas[] = '';
            $pesos[] = round(numeroParse(htmlspecialchars($linha_meta['pesoMedia'])), 3);
            $meta[] = numeroParse(htmlspecialchars($linha_meta['peso_final']));
        }
        $datas[] = ($anos) ? date('M/Y', dataParse(htmlspecialchars($linha_meta['data_add']))) : date('M', dataParse(htmlspecialchars($linha_meta['data_add'])));
        $pesos[] = round(numeroParse(htmlspecialchars($linha_meta['pesoMedia'])), 3); 
        $meta[] = numeroParse(htmlspecialchars($linha_meta['peso_final']));
    }
}
?>
<canvas id="<?= htmlspecialchars($linha_meta_id['id']).'chart' ?>" style="margin: 0 auto;" class="chart_hist"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('<?= $linha_meta_id['id'].'chart' ?>').getContext('2d');
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
                    label: "Peso Média",
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