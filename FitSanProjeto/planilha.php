<?php
$pagina = "Planilha";
require_once './template/cabecalho.php';

if (!tipoLogado("profissional")){
    header('Location: pagina1.php');
    exit;
}

// Iniciando variaveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$id = (!empty($_GET['id']) ? $_GET['id'] : null); //obtendo id de alteração
$erros = array();

//referente a inclusão/alteração no banco.
if (($acao == 'incluir') || ($acao == 'alterar')){
    if (!empty($_POST)) {
        $grupo = (!empty($_POST['grupo']) ? $_POST['grupo'] : null);
        $grupo_muscular = (!empty($_POST['grupo_muscular']) ? $_POST['grupo_muscular'] : null);
        $exercicio = (!empty($_POST['exercicio']) ? $_POST['exercicio'] : null);
        $series = (!empty($_POST['series']) ? $_POST['series'] : null);
        $repeticoes = (!empty($_POST['repeticoes']) ? $_POST['repeticoes'] : null);
        $carga = (!empty($_POST['carga']) ? $_POST['carga'] : null);
        $intervalo = (!empty($_POST['intervalo']) ? $_POST['intervalo'] : null);
        $tempo = (!empty($_POST['tempo']) ? $_POST['tempo'] : null);
        if (empty($grupo)) $erros[] = "Preencha o grupo.";
        if (empty($grupo_muscular)) $erros[] = "Preencha o grupo muscular.";
        if (empty($exercicio)) $erros[] = "Preencha o exercicio.";
    }
    if (empty($erros) && !empty($grupo)) {
        if ($id === null) {
            $query = "insert into planilha_tabela ( grupo, musculo_cardio_id , exercicio_id, series, repeticoes, carga, intervalo, tempo, profissional_id) values (" . mysqliEscaparTexto($grupo) . ", " . mysqliEscaparTexto($grupo_muscular) . ", " . mysqliEscaparTexto($exercicio) . ", " . mysqliEscaparTexto($series) . ", " . mysqliEscaparTexto($repeticoes) . ", " . mysqliEscaparTexto($carga) . ", " . mysqliEscaparTexto($intervalo) . ", " . mysqliEscaparTexto($tempo) . ", " . mysqliEscaparTexto($_SESSION['id']) . " )";
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $id = mysqli_insert_id($conexao);
        } else {
            $query = "update planilha_tabela set grupo = " . mysqliEscaparTexto($grupo) . ", musculo_cardio_id = " . mysqliEscaparTexto($grupo_muscular) . ", exercicio_id = " . mysqliEscaparTexto($exercicio) . ", series = " . mysqliEscaparTexto($series) . ", repeticoes = " . mysqliEscaparTexto($repeticoes) . ", carga = " . mysqliEscaparTexto($carga) . ", intervalo = " . mysqliEscaparTexto($intervalo) . ", tempo = " . mysqliEscaparTexto($tempo) . " where id = " . mysqliEscaparTexto($id) . " and profissional_id = " . mysqliEscaparTexto($_SESSION['id']);
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
        }
        header('Location: ' . basename(__FILE__));
        exit();
    }
} elseif ($acao == 'excluir') {
    if ($id !== null) {
        $query = "delete from planilha_tabela where id= " . mysqliEscaparTexto($id) . " and profissional_id = " . mysqliEscaparTexto($_SESSION['id']);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
    }
    header('Location: ' . basename(__FILE__));
    exit();
}

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from planilha_tabela where profissional_id = " . mysqliEscaparTexto($_SESSION['id']) . " and id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
    $linha_alterar = ($resultado_alterar?mysqli_fetch_array($resultado_alterar):array());
} else {
    $linha_alterar = array();
}

//referente aos grupos
$query_grupos = "select distinct grupo from planilha_tabela where planilha_id is null and profissional_id = " . mysqliEscaparTexto($_SESSION['id']) . " order by grupo";
$resultado_grupos = mysqli_query($conexao, $query_grupos) or die_mysql($query_grupos, __FILE__, __LINE__);
$grupos = array();
while ($linha_grupo = mysqli_fetch_array($resultado_grupos)) $grupos[] = $linha_grupo['grupo'];
mysqli_free_result($resultado_grupos);

//referente à consulta
$query = "select
    p.*,
    g.nome grupomusc,
    e.nome exercicio,
    e.descricao exercicio_desc,
    e.foto exercicio_foto,
    u.nome,
    u.sobrenome,
    u.foto
from
    planilha_tabela p join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = p.exercicio_id and e.musculo_cardio_id = g.id join
    usuario u on u.id=p.profissional_id
where
    p.planilha_id is null and
    u.id= " . mysqliEscaparTexto($_SESSION['id']) . "
order by
    p.grupo,
    u.nome
";
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Planilha</h1>
    </section><br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Prescrição de treino</h3>
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
            <div class="table" id="adicionar_novo">
                <div class="col-lg-1">
                 <input type="text" class="form-control" name= "grupo" placeholder="Grupo" value="<?php echo htmlentities($linha_alterar['grupo'])?>">   
                </div>
                <div class="col-lg-2">
<?php
$grupoMuscuCardio = array();
$query2 = "select * from planilha_grupoMuscuCardio order by nome";
if ($resultado2 = mysqli_query($conexao, $query2)) {
    while ($linha2 = mysqli_fetch_array($resultado2)) {
        foreach ($linha2 as $key => $val){
            if (is_numeric($key)) unset($linha2[$key]);
        }
        $linha2['exercicios'] = array();
        $query3 = ("select * from planilha_exercicio where musculo_cardio_id = " . mysqliEscaparTexto((int)$linha2['id']));
        if (tipoLogado("profissional")) $query3 .= " and (profissional_id is null or profissional_id = ".mysqliEscaparTexto((int)$_SESSION['id']) . ")";
        $query3 .= (" order by nome");
        if ($resultado3 = mysqli_query($conexao, $query3)) {
            while ($linha3 = mysqli_fetch_array($resultado3)){
                foreach ($linha3 as $key => $val){
                    if (is_numeric($key)) unset($linha3[$key]);
                }
                $linha2['exercicios'][$linha3['id']] = $linha3;
            }
        }
        $grupoMuscuCardio[$linha2['id']] = $linha2;
        mysqli_free_result($resultado3);
    }
    mysqli_free_result($resultado2);
}
if ($grupoMuscuCardio){
?>
                    <script>
                        var grupomusccard = <?php echo json_encode($grupoMuscuCardio) ?>;
                    </script>
<?php
}
?>
                    <select class="form-control select2 " name="grupo_muscular" data-selected="<?php echo htmlentities($linha_alterar['musculo_cardio_id'])?>">
                            <option value="">Grupo Muscular/Cár</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-control select2" name="exercicio" data-selected="<?php echo htmlentities($linha_alterar['exercicio_id'])?>">
                        <option value="">Exercício</option>
                    </select>
                </div> 
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "series" placeholder="Séries" value="<?php echo htmlentities($linha_alterar['series'])?>">
                </div>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "repeticoes" placeholder="Repetições" value="<?php echo htmlentities($linha_alterar['repeticoes'])?>">
                </div>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "carga" placeholder="Carga(Kg)" value="<?php echo htmlentities($linha_alterar['carga'])?>">
                </div>
                 <div class="col-lg-1">
                    <input type="text" class="form-control" name= "intervalo" placeholder="Intervalo" value="<?php echo htmlentities($linha_alterar['intervalo'])?>">
                </div>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "tempo" placeholder="Tempo(Min)" value="<?php echo htmlentities($linha_alterar['tempo'])?>">
                </div>
                <div class="col-lg-1">
                    <button type="submit" class="btn btn-info btn-flat duplicador-mais"><i class="fa fa-fw fa-plus"></i></button>
                </div>
            </div><br> 
            </form>
        </div> 
       
        <!--        final do box header-->
        <div class="box-body" >
            <ul class="nav nav-tabs">
<?php foreach ($grupos as $i => $grupo){ ?>
                <li class="<?php if (!$i) echo 'active'; ?>"><a href="#grupo<?php echo ($i + 1); ?>" data-toggle="tab"><?php echo htmlspecialchars($grupo); ?></a></li>
<?php } ?>
            </ul>
            <div class="tab-content">            
<?php
$grupo_atual = ''; $grupo_id = 0;
while ($linha = mysqli_fetch_array($resultado)) {
    if ($grupo_atual != $linha['grupo']){
        if ($grupo_id){
?>                               
                        </table></div>
                </div>
<?php
        }
        $class = array('tab-pane');
        if (!$grupo_id) $class[] = 'active';
        $grupo_id++; $grupo_atual = $linha['grupo'];
?>            
                <div class="<?php echo implode(' ', $class) ?>" id="grupo<?php echo $grupo_id; ?>">                                   
                    <div class="table-responsive">
                    <table class="table table-striped planilha dataTable">
                            <tr>
                                <th>Exercício</th>
                                <th>Séries</th>
                                <th>Repetições</th>                      
                                <th>Carga(Kg)</th>
                                <th>Intervalo</th>
                                <th>Tempo</th>
                                <th><i class="fa fa-cog"></i></th> 
                                <th><i class="fa fa-trash-o"></i></th>
                            </tr>                      
<?php
    }
?>
                            <tr>
                                <td><?php echo htmlentities($linha['exercicio']) ?> <b class="label label-danger"><?php echo htmlentities($linha['grupomusc']) ?></b></td>
                                <td><?php echo htmlentities($linha['series']) ?></td>
                                <td><?php echo htmlentities($linha['repeticoes']) ?></td>
                                <td><?php echo htmlentities($linha['carga']) ?></td>
                                <td><?php echo htmlentities($linha['intervalo']) ?></td>
                                <td><?php echo htmlentities($linha['tempo']) ?></td>
                                <td><a class=" " href="<?php echo basename(__FILE__) ?>?acao=alterar&id=<?= htmlentities($linha['id']) ?>" title="Atualizar"><i class="fa fa-edit"></i></a></td>
                                <td><a class=" " href="<?php echo basename(__FILE__) ?>?acao=excluir&id=<?= htmlentities($linha['id']) ?>" title="Excluir"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
<?php
}
if ($grupo_id){
?>
                                     
                    </table></div>
                </div>
<?php
} else {
?>
            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Sua planilha esta vazia</b></h3></div>
<?php
}
?>
            </div>
</div>
<div class="box-footer">
    <div class="form-group col-lg-12">
        <div class="pull-left">
            <a class="btn btn-app" type="button" data-toggle="modal" data-target="#modal-lista" id="modal-lista-button"><i class="fa fa-users"></i> Enviar </a>

        </div>
        <div class="pull-right">
            <a href="planilha_exercicios.php" class="btn btn-app"><span class="badge bg-aqua">Novos</span><i class="fa fa-bicycle"></i> Exercícios </a>  
            <a href="planilhas_salvas.php" class="btn btn-app"><span class="badge bg-aqua">Histórico</span><i class="fa fa-calendar"></i> Planilhas </a>               
        </div>
    </div>
</div>
<!--    </div>-->
</div>

<?php
require_once './template/rodape_especial.php';
