<?php
$pagina = "Dados da planilha";
require_once './template/cabecalho.php';

?>

<div class="content-wrapper">
    <div class="box-header">
        <h1>Dados da Planilha</h1>
    </div>   
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Escolha onde deseja ir</h3>
        </div>
        <div class="box-body">
            <a href="planilha_areas.php" class="btn btn-app">
                <i class="fa fa-heart"></i> Áreas
            </a>
            <a href="planilha_exercicios.php" class="btn btn-app">
              <i class="fa fa-bicycle"></i> Exercícios  
            </a>
            <a href="planilha.php" class="btn btn-app">
              <i class="fa fa-table"></i> Planilha  
            </a>
        </div>
        <div class="box-footer">        
    </div>
    </div>   
</div>

<?php
require_once './template/rodape_especial.php';
?>
