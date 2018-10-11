<?php
$pagina = "Prescrição de treino";
require_once './template/cabecalho.php';

if (!tipoLogado("aluno")) {
    header('Location: pagina1.php');
    exit;
}

// Iniciando variaveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$id = (!empty($_GET['id']) ? $_GET['id'] : null); //obtendo id de alteração
$erros = array();

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
    "a.aluno_id = " . mysqliEscaparTexto($_SESSION['id'])
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
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Prescrição de treino</h3>
            <br><br>
            <div class="box-body" >
            <ul class="nav nav-tabs">
<?php foreach ($grupos as $i => $grupo){ ?>
                <li class="<?php if (!$i) echo 'active'; ?>"><a href="#grupo<?php echo ($i + 1); ?>" data-toggle="tab"><?php echo htmlspecialchars($grupo); ?></a></li>
<?php } ?>
            </ul>
            <div class="tab-content">            
<?php
$grupo_atual = ''; $grupo_id = 0;
foreach ($resultado as $linha) {
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
    </div>
        </div>   
    </div>
</div>


<?php
require_once './template/rodape_especial.php';
