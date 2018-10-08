<?php
$query_grafico = "select dados_meta.*, meta.* from dados_meta join meta on dados_meta.meta_id = meta.id where meta.usuario_id = ".$_SESSION['id']." and meta.status='ativa' order by dados_meta.data_add";
$resultado_grafico = mysqli_query($conexao, $query_grafico);

$query_grafico_anual ="select meta.peso_final, meta.peso_inicial, meta.data_inicial, meta.data_final, sum(dados_meta.peso_add) as pesoTotal, MONTH(dados_meta.data_add) as mes, count(dados_meta.id) as quant, dados_meta.data_add from dados_meta join meta on dados_meta.meta_id = meta.id where meta.usuario_id = ".$_SESSION['id']." and meta.status='ativa' group by mes";
$resultado_grafico_anual = mysqli_query($conexao, $query_grafico_anual);

$query_grafico_meta = "select * from meta where usuario_id=".$_SESSION['id']." and status = 'ativa'";
$resultado_grafico_meta = mysqli_query($conexao, $query_grafico_meta);
$linha_grafico_meta = mysqli_fetch_array($resultado_grafico_meta);

$data_meta = date('d/M', dataParse($linha_grafico_meta['data_inicial']));
$meta_inicio = $linha_grafico_meta['peso_inicial']*1;
$meta_fim = $linha_grafico_meta['peso_final']*1;
$data_meta_fim = date('d/M', dataParse($linha_grafico_meta['data_final']));
?>
<?php
//          $mes = 0;
//            while ($linha_grafico = mysqli_fetch_array($resultado_grafico)){
//                echo "['.$linha_grafico[data_add].', ".$linha_grafico[peso_add].", ". str_replace(".", ",", $linha_grafico[peso_add], 2, '.', ',')."],";
//                $mes = $mes+1;
//            }
//          ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Peso', 'Meta'],
          <?php          
            echo "['$data_meta', $meta_inicio, $meta_fim],";
            while ($linha_grafico = mysqli_fetch_array($resultado_grafico)){                 
                $peso = $linha_grafico['peso_add']*1; 
                $meta = $linha_grafico['peso_final']*1;
                $data_add = date('d/M', dataParse($linha_grafico['data_add']));
                echo "['$data_add', $peso, $meta],";
            }
          ?>
        ]);

        var options = {
          title: 'Progresso Meta Atual',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('mensal_chart'));

        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Peso', 'Meta'],
          <?php  
            echo "['$data_meta', $meta_inicio, $meta],";
            while ($linha_grafico_anual = mysqli_fetch_array($resultado_grafico_anual)){                
                $peso_mensal = ($linha_grafico_anual['pesoTotal']*1)/$linha_grafico_anual['quant']; 
                $meta_anual = $linha_grafico_anual['peso_final']*1;
                $mes = date('M', dataParse($linha_grafico_anual['data_add']));
                echo "['$mes', $peso_mensal, $meta_anual],";
            }
          ?>
        ]);

        var options = {
          title: 'Progresso Meta Atual',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('anual_chart'));

        chart.draw(data, options);
      }
    </script>
    
