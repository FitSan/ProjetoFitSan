<?php
date_default_timezone_set('America/Sao_Paulo');
$pagina = "Envio dica";
require_once './template/cabecalho.php';
if ($_SESSION['tipo'] <> 'profissional') {
    header('Location: pagina1.php');
}

$now = new DateTime();
$datetime = $now->format('d-m-Y H:i:s');
?>
<div class="container">
    <h2 style="padding: 10px"><?=$pagina?></h2>
    <form method="post" action="enviar_dica.php">
        Profissional: <input name="nome" type="text" value="<?= $_SESSION['nome'] ?>" readonly><br><br>
        <input name="id" value="<?= $_SESSION['id'] ?>" hidden>
        <input name="envio" value="<?= $datetime ?>" hidden>
        <textarea style="margin: 0px; width: 239px; height: 78px;" maxlength="255" name="dica" ></textarea><br><br>
        <input type="submit" class="btn-primary" value="Enviar">
        <a href="minhas_dicas.php"><input type="button" class="btn-dark"value="Cancelar"></a>
    </form>
</div>
<?php
include './template/rodape_especial.php';
