<?php
$pagina = "Atividades Extras";
require_once './template/cabecalho.php';

if (!tipoLogado("aluno")){
    header('Location: pagina1.php');
    exit;
}

// Iniciando variraveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$id = (!empty($_GET['id']) ? $_GET['id'] : null); //obtendo id de alteração
$erros = array();

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from ativ_extras where aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . " and id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
    $linha_alterar = ($resultado_alterar?mysqli_fetch_array($resultado_alterar):array());
    $query_exe_alterar = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
    $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die_mysql($query_exe_alterar, __FILE__, __LINE__);
    $linha_alterar['exercicios'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicio'];
} else {
    $linha_alterar = array();
}

//referente a inclusão/alteração no banco.
if (($acao == 'incluir') || ($acao == 'alterar')){
    if (!empty($_POST)) {
        $titulo = (!empty($_POST['titulo']) ? $_POST['titulo'] : null);
        $texto = (!empty($_POST['texto']) ? $_POST['texto'] : null);
        $exercicios = (!empty($_POST['exercicios']) ? $_POST['exercicios'] : null);
        if (empty($titulo)) $erros[] = "Preencha o Título.";
        if (empty($texto)) $erros[] = "Preencha o Texto.";
        if (empty($exercicios)){
            $erros[] = "Escolha os exercícios.";
        } else {
            foreach ($exercicios as $exercicio) {
                if (empty($exercicio)) $erros[] = "Exercício inválido.";
            }
        }
    }
    if (empty($erros) && !empty($titulo) && !empty($texto) && !empty($exercicios)) {
        if ($id === null) {
            $query = "insert into ativ_extras ( datahora, titulo , texto, aluno_id) values ( now(), " . mysqliEscaparTexto($titulo) . ", " . mysqliEscaparTexto($texto) . ", " . mysqliEscaparTexto($_SESSION['id']) . " )";
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $id = mysqli_insert_id($conexao);
        } else {
            $query = "update ativ_extras set titulo=" . mysqliEscaparTexto($titulo) . ",  texto= " . mysqliEscaparTexto($texto) . " where id= " . mysqliEscaparTexto($id);
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $query = "delete from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
        }
        foreach ($exercicios as $exercicio) {
            $query1 = "insert into ativ_extras_exercicios ( ativ_extras_id, exercicio ) values ( " . mysqliEscaparTexto($id) . ", " . mysqliEscaparTexto($exercicio) . " )";
            mysqli_query($conexao, $query1) or die_mysql($query1, __FILE__, __LINE__);
        }
        header('Location: '.basename(__FILE__));
        exit();
    }
} elseif ($acao == 'excluir') {
    if ($id !== null) {
        $query = "delete from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
        $query = "delete from ativ_extras where id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
    }
    header('Location: '.basename(__FILE__));
    exit();
} elseif ($acao == 'visualizacao') {
    if ($id !== null) {
        $visualizacao = (isset($linha_alterar['visualizacao']) ? $linha_alterar['visualizacao'] : 'PRIVADO');
        if (!strcasecmp($visualizacao, 'PUBLICO')){
            $visualizacao = 'PRIVADO';
        } else {
            $visualizacao = 'PUBLICO';
        }
        $query = "update ativ_extras set visualizacao = " . mysqliEscaparTexto($visualizacao) . " where id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
    }
    header('Location: '.basename(__FILE__));
    exit();
}

//referente à paginação
$query_pagina = "select count(ativ_extras.id) as total from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']);
$resultado_pagina = mysqli_query($conexao, $query_pagina) or die_mysql($query_pagina, __FILE__, __LINE__);
$pagina = ($resultado_pagina?mysqli_fetch_array($resultado_pagina):array());
$pagina = array_merge(array(
    'total' => 0,
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
), array_map('intval', (array)$pagina));
$pagina['offset'] = (($pagina['pagina'] - 1) * $pagina['quantidade']);
$pagina['paginas'] = ceil($pagina['total'] / $pagina['quantidade']);

//referente à consulta
$query = "select ativ_extras.*, usuario.nome, usuario.sobrenome, usuario.foto from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " order by ativ_extras.datahora desc, ativ_extras.titulo limit " . $pagina['quantidade'] . " offset " . $pagina['offset'];
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1>Atividades Extras</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Minhas Atividades</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>

<?php if (!empty($erros)){ ?>
                    <div class="alert alert-danger">
                        <ul>
<?php    foreach ($erros as $erro){ ?>
                            <li><?php echo htmlentities($erro); ?></li>
<?php    } ?>
                        </ul>
                    </div>
<?php } ?>

                    <div class="box-body pad">
                        <form method="post" action="<?php echo basename(__FILE__) ?>?acao=<?= !empty($id) ? ('alterar&id='.$id) : 'incluir' ?>">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Título</label>
                                    <input type="text" class="form-control" name="titulo" placeholder="Escolha um título..." value="<?= htmlentities($linha_alterar['titulo']) ?>"><br>
                                </div>
                                <!--começo da caixa de texto-->
                                <div class="col-md-8">
                                    <textarea class="form-control" name="texto" rows="14" cols="80"><?= htmlentities($linha_alterar['texto']) ?></textarea>                                    
                                </div>
                                <!--fim da caixa de texto-->
                                
                                
                                
                                <div class="col-md-4">
                                    <div class="col-sm-12">
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><b>Atividades</b></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-6">
                                                <input type="checkbox" class="flat-red" name="exercicios[]" value="Futebol"<?php if (in_array('Futebol', $linha_alterar['exercicios'])) echo ' checked' ?>> Futebol
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Karatê"<?php if (in_array('Karatê', $linha_alterar['exercicios'])) echo ' checked' ?>> Karatê
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Basquete"<?php if (in_array('Basquete', $linha_alterar['exercicios'])) echo ' checked' ?>> Basquete
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Balé"<?php if (in_array('Balé', $linha_alterar['exercicios'])) echo ' checked' ?>> Balé
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Jiu-jitsu"<?php if (in_array('Jiu-jitsu', $linha_alterar['exercicios'])) echo ' checked' ?>> Jiu-jitsu
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Corrida"<?php if (in_array('Corrida', $linha_alterar['exercicios'])) echo ' checked' ?>> Corrida
                                            </div>
                                            
                                            <div class="col-xs-4 col-sm-6">
                                                <input type="checkbox" class="flat-red" name="exercicios[]" value="Caminhada"<?php if (in_array('Caminhada', $linha_alterar['exercicios'])) echo ' checked' ?>> Caminhada
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Ping-Pong"<?php if (in_array('Ping-Pong', $linha_alterar['exercicios'])) echo ' checked' ?>> Ping-Pong
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Skate"<?php if (in_array('Skate', $linha_alterar['exercicios'])) echo ' checked' ?>> Skate
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Natação"<?php if (in_array('Natação', $linha_alterar['exercicios'])) echo ' checked' ?>> Natação
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Bicicleta"<?php if (in_array('Bicicleta', $linha_alterar['exercicios'])) echo ' checked' ?>> Bicicleta
                                                <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Outros"<?php if (in_array('Outros', $linha_alterar['exercicios'])) echo ' checked' ?>> Outros
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary btn-flat">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div> 
                <!--final do box-->
                

               
                <ul class="timeline timeline-inverse">             
<?php
$dataanterior = '';
while ($linha = mysqli_fetch_array($resultado)) {
    $dataatual = date('d/m/Y', dataParse($linha['datahora']));
    if ($dataanterior != $dataatual){
?>
                    <li class="time-label">
                        <span class="bg-red">
                            <?= $dataatual ?>
                        </span>
                    </li>
                    <!-- /.timeline-label -->
<?php
        $dataanterior = $dataatual;
    }
?>
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-user bg-aqua"></i>

                        <div class="timeline-item bg-danger">
                            <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i:s', dataParse($linha['datahora'])) ?></span>

                            <h3 class="timeline-header"><a href="#"><?= htmlentities($linha['titulo']) ?></a>
<?php
    $query2 = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($linha['id']);
    if ($resultado2 = mysqli_query($conexao, $query2)){
        while ($linha2 = mysqli_fetch_array($resultado2)){
?>
                                <span class="label label-info"><?= htmlspecialchars($linha2['exercicio']) ?></span>
<?php
        }
        mysqli_free_result($resultado2);
    }
?>
                            </h3>

                            <div class="timeline-body">
                                <?= nl2br(htmlentities($linha['texto'])) ?>
                            </div>

                            <div class="timeline-footer">
                                <a class="btn btn-primary btn-xs" href="<?php echo basename(__FILE__) ?>?acao=alterar&id=<?= htmlentities($linha['id']) ?>">Atualizar</a>
                                <a class="btn btn-danger btn-xs" href="<?php echo basename(__FILE__) ?>?acao=excluir&id=<?= htmlentities($linha['id']) ?>">Excluir</a>
                                <a class="btn btn-xs" href="<?php echo basename(__FILE__) ?>?acao=visualizacao&id=<?= htmlentities($linha['id']) ?>"><?php
                                    if ($linha['visualizacao'] == 'PUBLICO'){
                                        ?><i class="fa fa-unlock-alt"></i><?php
                                    } else {
                                        ?><i class="fa fa-lock"></i><?php
                                    }
                                ?></a>
                            </div>
                        </div>
                    </li>
                    
                    <!-- END timeline item -->
<?php
}
if ($dataanterior){
?>
                    
                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
<?php } ?>
                </ul>

              <!-- /.tab-pane -->
<?php if ($pagina['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($pagina['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $pagina['paginas']; $pag++){ ?>
                <li class="<?php echo (($pagina['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($pagina['pagina'] == $pagina['paginas']) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pagina['paginas'] ?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>
                
            </div>
        </div>
    </section>
<!--</div>-->
<?php

require_once './template/rodape_especial.php';




