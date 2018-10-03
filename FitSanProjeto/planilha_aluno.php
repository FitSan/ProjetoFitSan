<?php
$pagina = "Prescrição de treino";
require_once './template/cabecalho.php';

if (!tipoLogado("aluno")){
    header('Location: pagina1.php');
    exit;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Prescrição de Treino</h1>
    </section><br>
</div>


<?php
require_once './template/rodape_especial.php';