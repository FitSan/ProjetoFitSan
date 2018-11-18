<?php
$pagina = "Busca";
require_once './template/cabecalho.php';
require_once './template/menu.php';

if (isset($_POST['busca'])){
    $busca = $_POST['busca'];
    $busca = trim($busca);
    $_SESSION['busca'] = $busca;
} elseif (isset($_SESSION['busca'])){
    $busca = $_SESSION['busca'];
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $pagina ?></h1>
    </section>
 
    <section class="content">
        <div class="box" style="overflow-x: auto; white-space: nowrap;">            
            <table class="table table-bordered table-striped buscauser" id="content_busca_user">
            </table>
            <div id='loading_busca_user' style="margin: 0 auto; width: 50px;"></div>
            <table class="table table-bordered table-striped buscadicas" id="content_busca_dica">            
            </table>
            <div id='loading_busca_dica' style="margin: 0 auto; width: 50px;"></div>
        </div>
    </section>
<!--</div>-->

<?php
include './template/rodape_especial.php';

