<?php
$pagina = "Musculos/Cárdio";
require_once './template/cabecalho.php';

if (!tipoLogado("admin")){
    header('Location: perfil.php');
    exit;
}


// Iniciando variaveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$id = (!empty($_GET['id']) ? $_GET['id'] : null); //obtendo id de alteração
$erros = array();

//referente a inclusão/alteração no banco.
if (($acao == 'incluir') || ($acao == 'alterar')) {
    if (!empty($_POST)) {
        $nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
        if (empty($nome))
            $erros[] = "Preencha o nome do músculo";
    }
    if (empty($erros) && !empty($nome)) {
        if ($id === null) {
            $query = "insert into planilha_grupoMuscuCardio ( nome) values ( " . mysqliEscaparTexto($nome) . ")";
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
            $id = mysqli_insert_id($conexao);
        } else {
            $query = "update planilha_grupoMuscuCardio set nome=" . mysqliEscaparTexto($nome) . " where id= " . mysqliEscaparTexto($id);
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
        }
        header('Location: ' . basename(__FILE__));
        exit();
    }
} elseif ($acao == 'excluir') {
    if (empty($erros) && ($id !== null)) {
        $query = "delete from planilha_grupoMuscuCardio where id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
        header('Location: ' . basename(__FILE__));
        exit();
    }
}

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from planilha_grupoMuscuCardio where id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_alterar . PHP_EOL . print_r(debug_backtrace(), true));
    $linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
} else {
    $linha_alterar = array();
}

//referente à consulta
$query = "select * from planilha_grupoMuscuCardio order by nome";
$resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Músculos e Cádio</h1>
    </section>
    <br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Insira aqui as áreas de atuação </h3>
            <br><br>
            <form class="form-horizontal" action="<?php echo basename(__FILE__) ?>?acao=<?= !empty($id) ? ('alterar&id=' . $id) : 'incluir' ?>" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Nome: </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nome" placeholder="Preencha o campo com as áreas de atuação ..." value="<?= htmlentities($linha_alterar['nome']) ?>">
                        </div>
                    </div>

                    <div class="box-footer">                        
                        <button type="reset" class="btn btn-default">Limpar</button>                        
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <a href="area_admin.php" class="btn btn-danger pull-right">Voltar</a><br><br>

                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px"><input type="checkbox"></th>
                <th>Nome</th>
                <th style="width: 40px"><i class="fa fa-edit"></i></th>
                <th style="width: 40px"><i class="fa fa-trash-o"></i></th>
            </tr>
            <?php 
                    while ($linha = mysqli_fetch_array($resultado)) { 
                ?>
                <tr>
                    <td><input type="checkbox"></td>
                    <td><?= htmlspecialchars($linha['nome']) ?></td>           
                    <td><a class="" href="<?php echo basename(__FILE__) ?>?acao=alterar&id=<?= htmlentities($linha['id']) ?>" title="Atualizar"><i class="fa fa-edit "></i></a></td>
                    <td><a class="" href="<?php echo basename(__FILE__) ?>?acao=excluir&id=<?= htmlentities($linha['id']) ?>" title="Excluir"><i class="fa fa-trash-o"></i></a></td>
                </tr>
                <?php
            } 
            ?>



        </table>
    </div>       

<?php
require_once './template/rodape_especial.php';
?>
