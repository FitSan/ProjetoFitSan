<?php
$pagina = "Planilha";
require_once './template/cabecalho.php';

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
        $repeticoes = (!empty($_POST['repeticoes']) ? $_POST['repeticoes'] : null);
        $carga = (!empty($_POST['carga']) ? $_POST['carga'] : null);
        $intervalos = (!empty($_POST['intervalos']) ? $_POST['intervalos'] : null);
        if (empty($grupo)) $erros[] = "Preencha o grupo.";
        if (empty($grupo_muscular)) $erros[] = "Preencha o grupo muscular.";
        if (empty($exercicio)) $erros[] = "Preencha o exercicio.";
        if (empty($repeticoes)) $erros[] = "Preencha as repetições.";
        if (empty($carga)) $erros[] = "Preencha a carga em Kg.";
        if (empty($intervalos)) $erros[] = "Preencha o intervalo de cada exercício.";
    }
    if (empty($erros) && !empty($grupo)) {
        if ($id === null) {
            $query = "insert into planilha ( datahora, titulo , texto, aluno_id) values ( now(), " . mysqliEscaparTexto($titulo) . ", " . mysqliEscaparTexto($texto) . ", " . mysqliEscaparTexto($_SESSION['id']) . " )";
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
            $id = mysqli_insert_id($conexao);
        } else {
            $query = "update ativ_extras set titulo=" . mysqliEscaparTexto($titulo) . ",  texto= " . mysqliEscaparTexto($texto) . " where id= " . mysqliEscaparTexto($id);
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
            $query = "delete from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
            mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
        }
        foreach ($exercicios as $exercicio) {
            $query1 = "insert into ativ_extras_exercicios ( ativ_extras_id, exercicio ) values ( " . mysqliEscaparTexto($id) . ", " . mysqliEscaparTexto($exercicio) . " )";
            mysqli_query($conexao, $query1) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query1 . PHP_EOL . print_r(debug_backtrace(), true));
        }
        header('Location: atividadesExtras.php');
        exit();
    }
} elseif ($acao == 'excluir') {
    if ($id !== null) {
        $query = "delete from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
        $query = "delete from ativ_extras where id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
    }
    header('Location: atividadesExtras.php');
    exit();
}

//referente ao formulário
if (!empty($id)) {
    $query_alterar = "select * from ativ_extras where aluno_id = " . mysqliEscaparTexto($_SESSION['id']) . " and id= " . mysqliEscaparTexto($id);
    $resultado_alterar = mysqli_query($conexao, $query_alterar) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query_alterar.PHP_EOL.print_r(debug_backtrace(), true));
    $linha_alterar = ($resultado_alterar?mysqli_fetch_array($resultado_alterar):array());
    $query_exe_alterar = "select * from ativ_extras_exercicios where ativ_extras_id= " . mysqliEscaparTexto($id);
    $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query_exe_alterar.PHP_EOL.print_r(debug_backtrace(), true));
    $linha_alterar['exercicios'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicio'];
} else {
    $linha_alterar = array();
}

//referente à consulta
$query = "select ativ_extras.*, usuario.nome, usuario.sobrenome, usuario.foto from ativ_extras join usuario on usuario.id=ativ_extras.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']) . " order by ativ_extras.datahora desc";
$resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Planilha</h1>
    </section><br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Prescrição de treino</h3>
            <br><br>
            <div class="table" id="adicionar_novo">
                <div class="col-lg-1">
                 <input type="text" class="form-control" name= "grupo" placeholder="Grupo">   
                </div>
                <div class="col-lg-2">
                    <select class="form-control select2 " name="areas">
                            <option value="">Grupo Muscular/Cár</option>
<?php
$query2 = "select * from planilha_grupoMuscuCardio";
if ($resultado2 = mysqli_query($conexao, $query2)) {
    while ($linha2 = mysqli_fetch_array($resultado2)) {
?>
                            <option value="<?= htmlspecialchars($linha2['id']) ?>"><?= htmlspecialchars($linha2['nome']) ?></option>
<?php
    }
    mysqli_free_result($resultado2);
}
?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select class="form-control select2" name="exercicios">
                        <option value="">Exercícios</option>
<?php
$query2 = "select * from planilha_exercicio";
if ($resultado2 = mysqli_query($conexao, $query2)) {
    while ($linha2 = mysqli_fetch_array($resultado2)) {
?>
                            <option value="<?= htmlspecialchars($linha2['id']) ?>" data-id="<?= htmlspecialchars($linha2['musculo_cardio_id']) ?>"><?= htmlspecialchars($linha2['nome']) ?></option>
<?php
    }
    mysqli_free_result($resultado2);
}
?>
                    </select>
                </div> 
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "series" placeholder="Séries">
                </div>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "repeticoes" placeholder="Repetições">
                </div>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "carga" placeholder="Carga(Kg)">
                </div>
                 <div class="col-lg-1">
                    <input type="text" class="form-control" name= "intervalo" placeholder="Intervalo">
                </div>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name= "tempo" placeholder="Tempo(Min)">
                </div>
                <div class="col-lg-1">
                    <button type="button" class="btn btn-info btn-flat duplicador-mais"><i class="fa fa-fw fa-plus"></i></button>
                </div>
            </div><br> 
        </div> 
        
        <script>
            $(function(){
                var grupo = $(['#adicionar_novo [name="areas"]']);
                var exercicios = $(['#adicionar_novo [name="exercicios"]']);
                var lista = exercicios.find('options');
                grupo.on('change keyup', function(){
                    exercicios.find('option[data-id]').remove();
                    exercicios.append(lista.filter('[data-id="' + $(this).val() + '"]'));
                });
            })
        </script>

        <!--        final do box header-->
        <div class="box-body">
            <table class="table table-bordered table-striped planilha">

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab"> Grupo A </a></li>
                    <li><a href="#breve" data-toggle="tab"> Grupo B </a></li>
                    <li><a href="#settings" data-toggle="tab"> <i class="fa fa-fw fa-plus"></i> </a></li> 
                </ul>
                <thead>

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
                </thead>
                <tbody>
                    <tr>
                        <td>Supino enclinado com barra <b class="label label-danger"> Peito</b></td>
                        <td>3x</td>
                        <td>12, 10, 9</td>
                        <td>30, 40, 60</td>
                        <td>15 seg</td>
                        <td>  - </td>
                        <td><i class="fa fa-cog"></i></td>
                        <td><i class="fa fa-trash-o"></i></td>
                    </tr>
                    <tr>
                        <td>Esteira <b class="label label-danger"> Cárdio</b></td>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                        <td>  30 min </td>
                        <td><i class="fa fa-cog"></i></td>
                        <td><i class="fa fa-trash-o"></i></td>
                    </tr>
                </tbody>              
            </table><br>

        </div>
        <div class="box-footer">
            <div class="form-group">
                <div class="col-sm-3">
                    <br><span><label>Enviar para:</label></span>
                    <div class="input-group">                        
                        <span class="input-group-addon">@</span>
                        <input type="text" class="form-control" placeholder="nome...">
                        <span class="input-group-addon"><a href="#" data-toggle="tab"><i class="fa fa-search"></i></a></span>
                    </div>                 
                </div><br><br><br>
                <div class="col-sm-1 pull-right">
                    <a href="planilha_exercicios.php" class="btn btn-info">Novos Exercicios</a><br><br>


                </div>
                <div class="col-sm-1 pull-right">
                    <button type="submit" class="btn btn-default ">Lista</button>
                </div>
            </div>


        </div>
    </div>
</div>

<?php
require_once './template/rodape_especial.php';
