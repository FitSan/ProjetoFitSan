<?php
$pagina = "Prescrição de treino";
require_once './template/cabecalho.php';

if (!tipoLogado("aluno")) {
    header('Location: pagina1.php');
    exit;
}

if (isset($_GET['notificacao'])){
    echo leituraNotificacao($_GET['notificacao']);
    echo '<script>window.location = ' . json_encode(url_param_add(url_current(), 'notificacao', null)). ';</script>';
    exit;
}

// Iniciando variaveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$id = (!empty($_GET['id']) ? $_GET['id'] : null); //obtendo id de alteração
$profissional = (!empty($_GET['profissional']) ? $_GET['profissional'] : ''); //obtendo profissional atual
$erros = array();

$resultado = dbquery("select p.id, a.id as planilha_aluno_id from planilha p join planilha_aluno a on a.planilha_id = p.id where a.aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . " order by datahora desc limit 1");
if (!empty($resultado)){
    $planilha_id = $resultado[0]['id'];
    $planilha_aluno_id = $resultado[0]['planilha_aluno_id'];
} else {
    $planilha_id = null;
    $planilha_aluno_id = null;
}

//referente a inclusão/alteração no banco.
if ($acao == 'checkin'){
    if (!empty($_POST)) {
        $ativ_feita = (!empty($_POST['ativ_feita']) ? $_POST['ativ_feita'] : null);
        if (empty($ativ_feita)) $erros[] = "Selecione o exercício realizado.";
    }
    if (empty($erros) && !empty($ativ_feita)) {
        $anterior = '';
        foreach ((array)$ativ_feita as $check){
            list($planilha_tabela_id, $exercicio, $grupo) = explode('|', $check, 3);
            if ($anterior != $grupo){
                $query = "insert into planilha_aluno_feito ( planilha_aluno_id, datahora) values (" . mysqliEscaparTexto($planilha_aluno_id) . ", now() )";
                mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
                $id = mysqli_insert_id($conexao);
                $anterior = $grupo;
            }
            $query = "insert into planilha_aluno_exercicio ( planilha_feito_id, planilha_tabela_id, exercicio) values (" . mysqliEscaparTexto($id) . ", " . mysqliEscaparTexto($planilha_tabela_id) . ", " . mysqliEscaparTexto($exercicio) . "  )";
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
        }
        header('Location: ' . basename(__FILE__));
        exit();
    }
} elseif ($acao == 'excluir') {
    if ($id !== null){
        $query = "delete from planilha_aluno_exercicio where planilha_feito_id = " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
        $query = "delete from planilha_aluno_feito where id = " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
    }
    header('Location: '.basename(__FILE__));
    exit();
}

$profissionais = dbquery("select
    u.*
from
    vinculo v join
    usuario u on u.id = v.profissional_id
where
    u.status = 'ativado' and
    v.status = 'aprovado' and
    v.aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . "
order by
    u.nome
");
if (empty($profissionais)) $profissionais = array();

//monta o sql de consulta
$query = array();
$query['select'] = array(
    'p.*',
    'g.nome grupomusc',
    'e.nome exercicio',
    'e.descricao exercicio_desc',
    'e.foto exercicio_foto'
);
$query['from'] = "
    planilha_aluno a join
    planilha_tabela p on p.planilha_id = a.planilha_id join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = p.exercicio_id and e.musculo_cardio_id = g.id
";
$query['where'] = array(
    "a.aluno_id = " . mysqliEscaparTexto($_SESSION['id']),
    "a.planilha_id = " . mysqliEscaparTexto($planilha_id),
    "p.profissional_id = " . mysqliEscaparTexto($profissional),
);
$query['order'] = "
    p.grupo
";

//referente aos grupos
$query_grupos = array_merge($query, array('select' => "distinct grupo", 'order' => "grupo"));
$resultado_grupos = dbquery($query_grupos);
$grupos = array();
foreach ($resultado_grupos as $linha_grupo) $grupos[] = $linha_grupo['grupo'];

//referente à consulta
$resultado = dbquery($query);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Prescrição de Treino</h1>
    </section><br>
    <div class="box"><br>
        <form action="" method="GET"><select class="select2-dropdown"name="profissional" onchange="this.form.submit();" onkeyup="this.form.submit();">
                <option value="">(Selecione um profissional)</option>
<?php foreach ($profissionais as $value){ ?>
                <option value="<?php echo htmlspecialchars($value['id']); ?>"<?php if ($value['id'] == $profissional) echo ' selected="selected"' ?>><?php echo htmlspecialchars($value['nome'] . ' ' . $value['sobrenome']); ?></option>
<?php } ?>
        </select></form>
        <div class="box-header"><form class="form-horizontal" action="<?php echo basename(__FILE__) ?>?acao=checkin" method="POST" enctype="multipart/form-data">
            <h3 class="box-title">Prescrição de treino</h3>
            <br><br>
<!--            <div class="box-body" >-->
            <ul class="nav nav-tabs">
<?php foreach ($grupos as $i => $grupo){ ?>
                <li class="<?php if (!$i) echo 'active'; ?>"><a href="#grupo<?php echo ($i + 1); ?>" data-toggle="tab"><?php echo htmlspecialchars($grupo); ?></a></li>
<?php } ?>
            </ul>
            <div class="tab-content">          
<?php
$grupo_atual = ''; $grupo_id = 0;
foreach ($resultado as $i => $linha) {
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
                                <th class="text-center"><i class="fa fa-eye"></i></th> 
                                <th class="text-center"><i class="fa fa-check-square"></i></th>
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
                                <td class="text-center">
                                    <a data-toggle="modal" data-target="#modal-exercicio-<?php echo $i ?>" id="modal-exercicio-<?php echo $i ?>-button" title="Visualizar"><i class="fa fa-eye"></i></a>
                                    <div class="modal fade" id="modal-exercicio-<?php echo $i ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title"><?php echo htmlentities($linha['exercicio']) ?></h4>
                                                </div>
                                                <div class="modal-body">
<?php if (!empty($linha['exercicio_foto'])){ ?>
                                                    <p><img style="width: 100%;" src="<?php echo htmlentities($linha['exercicio_foto']) ?>"></p>
<?php } ?>
                                                    <p><?php echo htmlentities($linha['exercicio_desc']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><input type="checkbox" class="flat-red" name="ativ_feita[<?php echo $i ?>]" value="<?php echo htmlentities($linha['id']) ?>|<?php echo htmlentities($linha['exercicio_id']) ?>|<?php echo htmlentities($linha['grupo']) ?>"></td>
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
            <div class="pull-left"><br>       
    <button class="button btn-app" type="submit" href="#"><i class="fa fa-paper-plane-o"></i> Enviar </button></form>
        </div></div>
        </div>

    <!--</div>-->
        <!--</div>-->   
    <!--</div>-->
</div>
<?php
$query = array();
$query['select'] = array(
    'a.planilha_id',
    'p.profissional_id',
    'p.musculo_cardio_id',
    'p.exercicio_id',
    'p.grupo',
    'p.series',
    'p.repeticoes',
    'p.carga',
    'p.intervalo',
    'p.tempo',
    'g.nome grupomusc',
    'e.nome exercicio',
    'e.descricao exercicio_desc',
    'e.foto exercicio_foto',
    'f.datahora',
    'z.planilha_feito_id',
    'u.nome as profissional_nome',
    'u.sobrenome as profissional_sobrenome',
    'u.email as profissional_email',
);
$query['from'] = "
    planilha_aluno a join
    planilha_aluno_feito f on f.planilha_aluno_id = a.id join
    planilha_aluno_exercicio z on z.planilha_feito_id = f.id join
    planilha_tabela p on p.planilha_id = a.planilha_id and p.id = z.planilha_tabela_id join
    planilha_grupoMuscuCardio g on g.id = p.musculo_cardio_id join
    planilha_exercicio e on e.id = z.exercicio join
    usuario u on u.id = p.profissional_id
";
$query['where'] = array(
    "a.aluno_id = " . mysqliEscaparTexto($_SESSION['id']),
);

//referente à paginação
$query_pagina = $query;
$query_pagina['select'] = "count(*) as total";
$resultado_pagina = dbquery($query_pagina);
$paginacao = ($resultado_pagina?$resultado_pagina[0]:array());
$paginacao = array_merge(array(
    'total' => 0,
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
), array_map('intval', (array)$paginacao));
$paginacao['offset'] = (($paginacao['pagina'] - 1) * $paginacao['quantidade']);
$paginacao['paginas'] = ceil($paginacao['total'] / $paginacao['quantidade']);

$query['order'] = "
    f.datahora desc,
    p.grupo,
    exercicio
";
$query['outro'] = "limit " . $paginacao['quantidade'] . " offset " . $paginacao['offset'];

$resultado = dbquery($query);
?>

<section class="content-header">   
<h3 class="box-title">Exercícios Feitos</h3>
</section><br>
<?php if (!empty($resultado)){ ?>
<div class="tab-pane" id="timeline">
    <ul class="timeline timeline-inverse">
        <?php
$dataanterior = $grupo_atual = ''; $anterior = null;
foreach ($resultado as $linha) {
    $dataatual = date('d/m/Y', dataParse($linha['datahora']));
    if ($grupo_atual && (($dataanterior != $dataatual) || ($grupo_atual != $linha['grupo']))){
?>
                    </table>
                    
                   
                    
                </div>
                <div class="timeline-footer">
                    <a href="<?php echo basename(__FILE__) ?>?acao=excluir&id=<?= htmlentities($anterior['planilha_feito_id']) ?>" class="btn btn-social-icon btn-danger"><i class="fa fa-trash-o"></i></a>
                    
                </div>
            </div>
        </li> 
<?php
    }
    if ($dataanterior != $dataatual){
?>

        <li class="time-label">
            <span class="bg-red">
                <?= $dataatual ?>
            </span>
        </li>
            
<?php
        $dataanterior = $dataatual;
        $grupo_atual = '';
    }
    if ($grupo_atual != $linha['grupo']){
        $grupo_atual = $linha['grupo'];
?>            
        <li>
            <i class="fa fa-thumbs-o-up bg-blue"></i>

            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i:s', dataParse($linha['datahora'])) ?></span>

                <h3 class="timeline-header"><strong><?php echo htmlspecialchars($linha['grupo']); ?></strong> - por <?php echo htmlspecialchars($linha['profissional_nome'] . ' ' . $linha['profissional_sobrenome']); ?></h3>
                

                <div class="timeline-body">
                    
                    <table class="table table-striped planilha dataTable">
                        <tr>
                            <th>Exercício</th>
                            <th>Séries</th>
                            <th>Repetições</th>                      
                            <th>Carga(Kg)</th>
                            <th>Intervalo</th>
                            <th>Tempo</th>
                        </tr>
<?php
    }
?>
                        <tr>
                            <td><?php echo htmlentities($linha['exercicio']) ?><b class="label label-danger"><?php echo htmlentities($linha['grupomusc']) ?></b></td>
                            <td><?php echo htmlentities($linha['series']) ?></td>
                            <td><?php echo htmlentities($linha['repeticoes']) ?></td>
                            <td><?php echo htmlentities($linha['carga']) ?></td>
                            <td><?php echo htmlentities($linha['intervalo']) ?></td>
                            <td><?php echo htmlentities($linha['tempo']) ?></td>
                        </tr>
<?php
    $anterior = $linha;
}
if ($grupo_atual){
?>
                    </table>
                    
                   
                    
                </div>
                <div class="timeline-footer">
                    <a href="<?php echo basename(__FILE__) ?>?acao=excluir&id=<?= htmlentities($anterior['planilha_feito_id']) ?>" class="btn btn-social-icon btn-danger"><i class="fa fa-trash-o"></i></a>
                    
                </div>
            </div>
        </li> 
        <?php
}
        ?>
        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>
    
    </ul>
<?php if ($paginacao['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($paginacao['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $paginacao['paginas']; $pag++){ ?>
                <li class="<?php echo (($paginacao['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($paginacao['pagina'] == $paginacao['paginas']) ? 'disabled' : '') ?>"><a href="<?php echo basename(__FILE__) ?>?pagina=<?php echo $paginacao['paginas'] ?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>
</div>
<?php } else { ?>
<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Não foi realizado nenhum exercício ainda.</b></h3></div>
<?php } ?>


<?php
require_once './template/rodape_especial.php';
