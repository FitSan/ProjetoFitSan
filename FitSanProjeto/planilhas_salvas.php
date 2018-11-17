<?php
$pagina = "Planilha Salvas";
require_once './template/cabecalho.php';
require_once './template/menu.php';

if (!tipoLogado("profissional")){
    header('Location: '.URL_SITE.'pagina1.php');
    exit;
}


//referente à consulta
$query = "select distinct
    p.*
from
    planilha p join
    planilha_tabela t on t.planilha_id = p.id
where
    t.profissional_id = " . mysqliEscaparTexto($_SESSION['id']) . "
order by
    p.datahora desc,
    p.titulo
";
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Planilha Salvas</h1>
    </section>
    <div class="box">
        <div class="box-body" >
            <div class="table-responsive">
                <table class="table table-striped planilha">
                    <tbody>
                        <tr>
                            <th>Planilha</th>
                            <th>Data</th>
                            <th><i class="fa fa-users"></i></th> 
                        </tr>  
<?php
while ($linha = mysqli_fetch_array($resultado)) {
?>                               
                        <tr>
                            <td><?php echo htmlentities($linha['titulo']) ?></td>
                            <td><?php echo htmlentities(date('d/m/Y H:i:s', dataParse($linha['datahora']))) ?></td>
                            <td><a class="btn btn-app" type="button" data-toggle="modal" data-target="#modal-lista" id="modal-lista-button" data-id="<?php echo htmlentities($linha['id']) ?>"><i class="fa fa-users"></i> Reenviar </a></td>
                        </tr>
<?php
}
?>
                    </tbody>
                    
                </table>
                
            </div><br>
            <div class="pull-right">
                <a href="<?=URL_SITE?>planilha.php" class="btn btn-danger pull-right"> Voltar </a>
            </div>
        </div>
    </div>
</div>

<?php
require_once './template/rodape_especial.php';

