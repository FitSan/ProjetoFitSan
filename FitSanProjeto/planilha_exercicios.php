<?php
$pagina = "Novos Exercícios";
require_once './template/cabecalho.php';

if (tipoLogado("aluno")) {
    header('Location: pagina1.php');
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
        $descricao = (!empty($_POST['descricao']) ? $_POST['descricao'] : null);
        $musculo_cardio_id = (!empty($_POST['musculo_cardio_id']) ? $_POST['musculo_cardio_id'] : null);

        if (!empty($_FILES['foto']['name'])) {
            $uploaddir = '/uploads/exercicios/';
            $dir = (rtrim(dirname(__FILE__), '\\/') . $uploaddir); // Obtém a pasta do arquivo do site
            if (!@is_writable($dir))
                mkdir($dir, 0777, true); // Cria a pasta de uploads se não existir
            $arquivo = strtolower(preg_replace('{[^a-z0-9_\-\.]+}i', '_', $_FILES['foto']['name'])); // Limpa o nome da imagem removendo caracteres não permitidos
            $caminho = ($dir . $arquivo); // Monta o endereço da imagem
            $foto = ( // Monta a url da imagem
                    'http' .
                    ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 's' : '') .
                    '://' .
                    $_SERVER['HTTP_HOST'] .
                    rtrim(dirname($_SERVER['REQUEST_URI']), '\\/') .
                    $uploaddir . $arquivo
                    );
            if (!empty($_FILES['foto']['error']))
                die('Erro ao fazer upload'); // Para se deu erro no envio do arquivo
            if (empty($_FILES['foto']['tmp_name']))
                die('Upload não enviado'); // Para se não foi encontrado o arquivo temporário
            if (!@is_readable($_FILES['foto']['tmp_name']))
                die('Upload não encontrado'); // Para se não foi encontrado o arquivo temporário
            move_uploaded_file($_FILES['foto']['tmp_name'], $caminho) or die('Upload não copiado'); // Move o arquivo enviado para a pasta de uploads
        } else {
            $foto = null;
        }

        if (empty($nome))
            $erros[] = "Preencha o nome do novo exercício.";
        if (empty($descricao))
            $erros[] = "Preencha a descrição do exercício.";
        if (empty($musculo_cardio_id))
            $erros[] = "Preencha a descrição do músculo.";
        if (!tipoLogado("admin")) {
            if (($id !== null) && ($id <= 86))
                $erros[] = "Não é possível alterar os exercícios padrões.";
        } // TODO: mudar quando colocar todos os exercicios.
    }
    if (empty($erros) && !empty($nome) && !empty($descricao) && !empty($musculo_cardio_id)) {
        if ($id === null) {
            $query = "insert into planilha_exercicio ( nome, descricao , musculo_cardio_id, foto, profissional_id) values ( " . mysqliEscaparTexto($nome) . ", " . mysqliEscaparTexto($descricao) . ", " . mysqliEscaparTexto($musculo_cardio_id) . ", " . mysqliEscaparTexto($foto) . ", " . mysqliEscaparTexto(tipoLogado("admin") ? null : $_SESSION['id']) . " )";
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
            $id = mysqli_insert_id($conexao);
        } else {
            $query = "update planilha_exercicio set nome=" . mysqliEscaparTexto($nome) . ", descricao= " . mysqliEscaparTexto($descricao) . ", musculo_cardio_id= " . mysqliEscaparTexto($musculo_cardio_id) . " where id= " . mysqliEscaparTexto($id);
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
            if ($foto) {
                $query = "update planilha_exercicio set foto= " . mysqliEscaparTexto($foto) . " where id= " . mysqliEscaparTexto($id);
                mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
            }
        }
        header('Location: ' . basename(__FILE__));
        exit();
    }
} elseif ($acao == 'excluir') {
    if (!tipoLogado("admin")) {
        if (($id !== null) && ($id <= 86))
            $erros[] = "Não é possível excluir os exercícios padrões.";
        // TODO: mudar quando colocar todos os exercicios.
    }
    if (empty($erros) && ($id !== null)) {
        $query = "delete from planilha_exercicio where id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
        header('Location: ' . basename(__FILE__));
        exit();
    }
}

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from planilha_exercicio where id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_alterar . PHP_EOL . print_r(debug_backtrace(), true));
    $linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
} else {
    $linha_alterar = array();
}

//referente à paginação
$query_pagina = "select count(e.id) as total from planilha_exercicio e";
if (tipoLogado("admin")) $query_pagina .= " where e.profissional_id is null";
elseif (tipoLogado("profissional")) $query_pagina .= " where e.profissional_id = ".mysqliEscaparTexto($_SESSION['id']);
//elseif (tipoLogado("profissional")) $query_pagina .= " where e.profissional_id is null or e.profissional_id = ".mysqliEscaparTexto($_SESSION['id']);
$resultado_pagina = mysqli_query($conexao, $query_pagina) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_pagina . PHP_EOL . print_r(debug_backtrace(), true));
$pagina = ($resultado_pagina ? mysqli_fetch_array($resultado_pagina) : array());
$pagina = array_merge(array(
    'total' => 0,
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
        ), array_map('intval', (array) $pagina));
$pagina['offset'] = (($pagina['pagina'] - 1) * $pagina['quantidade']);
$pagina['paginas'] = ceil($pagina['total'] / $pagina['quantidade']);

//referente à consulta
$query = "select e.*, m.nome as musculo_nome from planilha_exercicio e left join planilha_grupoMuscuCardio m on m.id=e.musculo_cardio_id";
if (tipoLogado("admin")) $query .= " where e.profissional_id is null";
elseif (tipoLogado("profissional")) $query .= " where e.profissional_id = ".mysqliEscaparTexto($_SESSION['id']);
//elseif (tipoLogado("profissional")) $query .= " where e.profissional_id is null or e.profissional_id = ".mysqliEscaparTexto($_SESSION['id']);
$query .= " order by e.nome limit " . $pagina['quantidade'] . " offset " . $pagina['offset'];
$resultado = mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Novos exercícios</h1>
    </section>
    <br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Insira aqui um novo exercício</h3>
            <br><br>

<?php if (!empty($erros)) { ?>
                <div class="alert alert-danger">
                    <ul>
    <?php foreach ($erros as $erro) { ?>
                            <li><?php echo htmlentities($erro); ?></li>
    <?php } ?>
                    </ul>
                </div>
<?php } ?>

            <form class="form-horizontal" action="<?php echo basename(__FILE__) ?>?acao=<?= !empty($id) ? ('alterar&id=' . $id) : 'incluir' ?>" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Nome: </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nome" placeholder="Exercício ..." value="<?= htmlentities($linha_alterar['nome']) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Descrição: </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="descricao" rows="5" placeholder="Descreva seu exercício ..."><?= htmlentities($linha_alterar['descricao']) ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Área de atuação: </label>
                        <div class="col-sm-10">
                            <select class="form-control select2 " name="musculo_cardio_id">
                                <option value="">(Selecione)</option>
                                <?php
                                $query2 = "select * from planilha_grupoMuscuCardio order by nome";
                                if ($resultado2 = mysqli_query($conexao, $query2)) {
                                    while ($linha2 = mysqli_fetch_array($resultado2)) {
                                        ?>
                                        <option value="<?= htmlspecialchars($linha2['id']) ?>"<?php if ($linha_alterar['musculo_cardio_id'] == $linha2['id']) echo ' selected="selected"' ?>><?= htmlspecialchars($linha2['nome']) ?></option>
        <?php
    }
    mysqli_free_result($resultado2);
}
?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto" class="col-sm-1 control-label">Foto</label>
                        <div class="col-sm-10">
<?php if (!empty($linha_alterar['foto'])) { ?>
                                <img class="profile-user-img img-responsive" style="margin: 0;margin-bottom: 2px" src="<?= htmlspecialchars($linha_alterar['foto']) ?>" alt="User profile picture">
<?php } ?>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                    </div>

                    <div class="box-footer">                        
                        <button type="reset" class="btn btn-default">Limpar</button>                        
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <a href="planilha.php" class="btn btn-danger pull-right">Voltar</a><br><br>

                    </div>
                </div>
            </form>
        </div>
        
        <br><br>
        <div class="table-responsive table-box">
            <table class="table table-hover table-striped">
                <tbody>
                    <tr>
                        <th><i class="fa fa-star text-blue"></i></th>
                        <th><i class="fa fa-image"></i></th>
                        <th>Nome</th>
                        <th>Área</th>
                        <th>Descrição</th>
                        <th style="width: 40px"><i class="fa fa-edit"></i></th>
                        <th style="width: 40px"><i class="fa fa-trash-o"></i></th>
                    </tr>
<?php
while ($linha = mysqli_fetch_array($resultado)) {
?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
    <?php if (!empty($linha['foto'])) { ?>
                                    <a href="<?= htmlspecialchars($linha['foto']) ?>" rel="lightbox"><img class="profile-user-img img-responsive" style="margin: 0;margin-bottom: 2px" src="<?= htmlspecialchars($linha['foto']) ?>" alt="User profile picture"></a>
                        <?php } else { ?>
                                    <img class="profile-user-img img-responsive" style="margin: 0;margin-bottom: 2px" src="img/user-avatar-placeholder.png" alt="User profile picture">
                        <?php } ?>
                            </td>
                            <td><?= htmlentities($linha['nome']) ?></td>
                            <td><?= htmlentities($linha['musculo_nome']) ?></td>
                            <td><p><?= nl2br(htmlentities($linha['descricao'])) ?></p></td>
                            <td><?php
                            if (tipoLogado("admin") || (tipoLogado("profissional") && ($linha['profissional_id'] == $_SESSION['id']))){
                                ?><a class=" " href="<?php echo basename(__FILE__) ?>?acao=alterar&id=<?= htmlentities($linha['id']) ?>" title="Atualizar"><i class="fa fa-edit"></i></a><?php
                            } else {
                                ?><span title="Atualizar"><i class="fa fa-edit"></i></span><?php
                            } ?></td>
                            <td><?php
                            if (tipoLogado("admin") || (tipoLogado("profissional") && ($linha['profissional_id'] == $_SESSION['id']))){
                                ?><a class=" " href="<?php echo basename(__FILE__) ?>?acao=excluir&id=<?= htmlentities($linha['id']) ?>" title="Excluir"><i class="fa fa-trash-o"></i></a><?php
                            } else {
                                ?><span title="Excluir"><i class="fa fa-trash-o"></i></span><?php
                            } ?></td>
                        </tr>
<?php
}
if ($pagina['total'] > 1) {
?>
                
<?php
}
?>
                </tbody>
            </table>
        </div>
        <?php if ($pagina['paginas'] > 1) { ?>
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin">
                    <li class="<?php echo (($pagina['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>">&laquo;</a></li>
        <?php for ($pag = 1; $pag <= $pagina['paginas']; $pag++) { ?>
                        <li class="<?php echo (($pagina['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
        <?php } ?>
                    <li class="<?php echo (($pagina['pagina'] == $pagina['paginas']) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pagina['paginas'] ?>">&raquo;</a></li>
                </ul>
            </div>
<?php } ?>
    </div>       
<?php
require_once './template/rodape_especial.php';
?>
