<?php
$pagina = "Alterar Informações adicionais";
require_once './template/cabecalho.php';


$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$erros = array();

//referente ao formulário
$query_alterar = "select * from informacoes_adicionais where aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
$resultado_alterar = mysqli_query($conexao, $query_alterar) or die_mysql($query_alterar, __FILE__, __LINE__);
$linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
if (!empty($linha_alterar['id'])) {
    $query_cont_alterar = "select * from informacoes_adicionais_contatos where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
    $resultado_cont_alterar = mysqli_query($conexao, $query_cont_alterar) or die_mysql($query_cont_alterar, __FILE__, __LINE__);
    $linha_alterar['contatos'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_cont_alterar)) $linha_alterar['contatos'][] = $linha2;
    $query_exe_alterar = "select * from informacoes_adicionais_exercicios where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
    $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die_mysql($query_exe_alterar, __FILE__, __LINE__);
    $linha_alterar['exercicios'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicios'];
    $query_med_alterar = "select * from informacoes_adicionais_medidas where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
    $resultado_med_alterar = mysqli_query($conexao, $query_med_alterar) or die_mysql($query_med_alterar, __FILE__, __LINE__);
    $linha_alterar['medidas'] = array();
    while ($linha2 = mysqli_fetch_array($resultado_med_alterar)) $linha_alterar['medidas'][] = $linha2;
}

//referente a inclusão/alteração no banco.
if (($acao == 'incluir') || ($acao == 'alterar')) {
    if (!empty($_POST)) {
        $saude = (!empty($_POST['saude']) ? $_POST['saude'] : null);
        $medico = (!empty($_POST['medico']) ? $_POST['medico'] : null);
        $alergia = (!empty($_POST['alergia']) ? $_POST['alergia'] : null);
        $medicamento = (!empty($_POST['medicamento']) ? $_POST['medicamento'] : null);
        $gruposangue = (!empty($_POST['gruposangue']) ? $_POST['gruposangue'] : null);
        $doador = (!empty($_POST['doador']) ? $_POST['doador'] : null);
        $tipo = (!empty($_POST['tipo']) ? $_POST['tipo'] : null);
        $nome = (!empty($_POST['nome']) ? $_POST['nome'] : null);
        $telefone = (!empty($_POST['telefone']) ? $_POST['telefone'] : null);
        $altura = (!empty($_POST['altura']) ? $_POST['altura'] : null);
        $peso = (!empty($_POST['peso']) ? $_POST['peso'] : null);
        $massa_magra = (!empty($_POST['massa_magra']) ? $_POST['massa_magra'] : null);
        $gordura_corporal = (!empty($_POST['gordura_corporal']) ? $_POST['gordura_corporal'] : null);
        $exercicios = (!empty($_POST['exercicios']) ? $_POST['exercicios'] : null);
        $outros_exercicios = (!empty($_POST['outros_exercicios']) ? $_POST['outros_exercicios'] : null);
        $academia_frequentada = (!empty($_POST['academia_frequentada']) ? $_POST['academia_frequentada'] : null);
        $academia_atual = (!empty($_POST['academia_atual']) ? $_POST['academia_atual'] : null);

        if ($linha_alterar['id'] === null) {
            $query = "insert into informacoes_adicionais ( saude, medico , alergia, medicamento, gruposangue, doador, academia_frequentada, academia_atual, aluno_id) "
                    . "values ( " . mysqliEscaparTexto($saude) . ", " . mysqliEscaparTexto($medico) . " , " . mysqliEscaparTexto($alergia) . " , " . mysqliEscaparTexto($medicamento) . ", " . mysqliEscaparTexto($gruposangue) . " , " . mysqliEscaparTexto($doador) . " , " . mysqliEscaparTexto($academia_frequentada) . " , " . mysqliEscaparTexto($academia_atual) . ", " . mysqliEscaparTexto($_SESSION['id']) . " )";
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $linha_alterar['id'] = mysqli_insert_id($conexao);
        } else {
            $query = "update informacoes_adicionais set saude=" . mysqliEscaparTexto($saude)
                    . " ,  medico= " . mysqliEscaparTexto($medico) . ",  alergia= " . mysqliEscaparTexto($alergia) . " ,  medicamento= " . mysqliEscaparTexto($medicamento)
                    . ",  gruposangue= " . mysqliEscaparTexto($gruposangue) . ",  doador= " . mysqliEscaparTexto($doador)
                    . ", academia_frequentada= " . mysqliEscaparTexto($academia_frequentada) . ", academia_atual=" . mysqliEscaparTexto($academia_atual)
                    . " where id= " . mysqliEscaparTexto($linha_alterar['id']);

            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $query = "delete from informacoes_adicionais_contatos where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $query = "delete from informacoes_adicionais_exercicios where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
            $query = "delete from informacoes_adicionais_medidas where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
            mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
        }
        foreach ($tipo as $posicao => $contato) {
            $query1 = "insert into informacoes_adicionais_contatos ( informacoes_adicionais_id, tipo, nome, telefone ) values ( " . mysqliEscaparTexto($linha_alterar['id']) . ", " . mysqliEscaparTexto($contato) . ", " . mysqliEscaparTexto($nome[$posicao]) . ", " . mysqliEscaparTexto($telefone[$posicao]) . " )";
            mysqli_query($conexao, $query1) or die_mysql($query1, __FILE__, __LINE__);
        }
        if ($outros_exercicios) {
            $exercicios = array_merge($exercicios, array_map("trim", explode(",", $outros_exercicios))); //quebra outros exercicios nas virgulas, limpa espaços dos itens do array e concatena com o array dos exercicios.
        }
        foreach ($exercicios as $exercicio) {
            $query1 = "insert into informacoes_adicionais_exercicios ( informacoes_adicionais_id, exercicios) values ( " . mysqliEscaparTexto($linha_alterar['id']) . ", " . mysqliEscaparTexto($exercicio) . " )";
            mysqli_query($conexao, $query1) or die_mysql($query1, __FILE__, __LINE__);
        }
        foreach ($altura as $posicao => $valor) {
            $query1 = "insert into informacoes_adicionais_medidas ( informacoes_adicionais_id, altura, peso, massa_magra, gordura_corporal) values ( " . mysqliEscaparTexto($linha_alterar['id']) . ", " . mysqliEscaparTexto($valor, 'float') . " , " . mysqliEscaparTexto($peso[$posicao], 'float') . " , " . mysqliEscaparTexto($massa_magra[$posicao], 'float') . " , " . mysqliEscaparTexto($gordura_corporal[$posicao], 'float') . ")";
            mysqli_query($conexao, $query1) or die_mysql($query1, __FILE__, __LINE__);
        }
    }
    //header('Location: ' . basename(__FILE__));
    header('Location: perfil.php');
    exit();
}

//referente à consulta
$query = "select informacoes_adicionais.*, usuario.nome, usuario.sobrenome, usuario.foto from informacoes_adicionais join usuario on usuario.id=informacoes_adicionais.aluno_id where usuario.id= " . mysqliEscaparTexto($_SESSION['id']);
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Alterar Informações Adicionais</h1>
    </section>
    <section class="content">
        <form method="post" action="<?php echo basename(__FILE__) ?>?acao=<?= !empty($linha_alterar['id']) ? 'alterar' : 'incluir' ?>">
            <div class="box box-primary">
                <h3 class="box-title">Minhas Informações</h3>
            <div class="box-body">
                <strong><i class="fa fa-fw fa-medkit margin-r-5"></i>Ficha médica</strong><br><br>
                <div class="col-lg-3">
                    Problemas de Saúde:<textarea name="saude" class="form-control" rows="2" placeholder="Nenhum..."><?php echo htmlspecialchars($linha_alterar['saude']) ?></textarea> 
                </div>
                <div class="col-lg-3">
                    Notas médicas: <textarea name="medico" class="form-control" rows="2" placeholder="Nenhuma..."><?php echo htmlspecialchars($linha_alterar['medico']) ?></textarea> 
                </div>
                <div class="col-lg-3">
                    Alergias e reações: <textarea name="alergia" class="form-control" rows="2" placeholder="Nenhuma..."><?php echo htmlspecialchars($linha_alterar['alergia']) ?></textarea> 
                </div>
                <div class="col-lg-3">
                    Medicamentos: <textarea name="medicamento" class="form-control" rows="2" placeholder="Nenhum..."><?php echo htmlspecialchars($linha_alterar['medicamento']) ?></textarea> 
                </div>
                <div class="col-lg-6">
                    <br>Grupo Sanguineo<select class="form-control select2" name="gruposangue" style="width: 100%;">                                  
                        <option value="">(Selecione)</option>
                        <option value="A+"<?php if ($linha_alterar['gruposangue'] == "A+") echo ' selected="selected"'; ?>>A+</option>
                        <option value="A-"<?php if ($linha_alterar['gruposangue'] == "A-") echo ' selected="selected"'; ?>>A-</option>
                        <option value="B+"<?php if ($linha_alterar['gruposangue'] == "B+") echo ' selected="selected"'; ?>>B+</option>
                        <option value="B-"<?php if ($linha_alterar['gruposangue'] == "B-") echo ' selected="selected"'; ?>>B-</option>
                        <option value="AB+"<?php if ($linha_alterar['gruposangue'] == "AB+") echo ' selected="selected"'; ?>>AB+</option>
                        <option value="AB-"<?php if ($linha_alterar['gruposangue'] == "AB-") echo ' selected="selected"'; ?>>AB-</option>
                        <option value="0+"<?php if ($linha_alterar['gruposangue'] == "O+") echo ' selected="selected"'; ?>>O+</option>
                        <option value="O-"<?php if ($linha_alterar['gruposangue'] == "O-") echo ' selected="selected"'; ?>>O-</option>
                    </select> </div>
                <div class="col-lg-6">
                    <br><i class="fa fa-fw fa-heart-o"></i>Doador de orgão:<select class="form-control select2" name="doador" style="width: 100%;">                                  
                        <option value="">(Selecione)</option>
                        <option value="SIM"<?php if ($linha_alterar['doador'] == "SIM") echo ' selected="selected"'; ?>>Sim</option>
                        <option value="NAO"<?php if ($linha_alterar['doador'] == "NAO") echo ' selected="selected"'; ?>>Não</option>
                    </select><br></div>


                <hr>
                <strong><br><i class="fa fa-fw fa-phone"></i> Contatos de emergência</strong><br><br>
                <table class="table col-lg-12 duplicador"><tbody>
                <?php
                if (empty($linha_alterar['contatos']))
                    $linha_alterar['contatos'][] = array();
                foreach ($linha_alterar['contatos'] as $contato) {
                    ?>
                <tr class="duplicador-item">
                    <td>
                        <select class="form-control select2" name="tipo[]" style="width: 100%;">                                  
                            <option value="">(Selecione)</option>
                            <option value="Mãe"<?php if ($contato['tipo'] == "Mãe") echo ' selected="selected"'; ?>>Mãe</option>
                            <option value="Pai"<?php if ($contato['tipo'] == "Pai") echo ' selected="selected"'; ?>>Pai</option>
                            <option value="Responsável"<?php if ($contato['tipo'] == "Responsável") echo ' selected="selected"'; ?>>Responsável</option>
                            <option value="Irmão"<?php if ($contato['tipo'] == "Irmão") echo ' selected="selected"'; ?>>Irmão</option>
                            <option value="Irmã"<?php if ($contato['tipo'] == "Irmã") echo ' selected="selected"'; ?>>Irmã</option>
                            <option value="Filho(a)"<?php if ($contato['tipo'] == "Filho(a)") echo ' selected="selected"'; ?>>Filho(a)</option>                               
                            <option value="Amigo(a)"<?php if ($contato['tipo'] == "Amigo(a)") echo ' selected="selected"'; ?>>Amigo(a)</option>
                            <option value="Cônjuge"<?php if ($contato['tipo'] == "Cônjuge") echo ' selected="selected"'; ?>>Cônjuge</option>
                            <option value="Outros"<?php if ($contato['tipo'] == "Outros") echo ' selected="selected"'; ?>>Outros</option>
                        </select> 
                    </td>
                    <td>
                        <input type="text" name="nome[]" class="form-control" placeholder="Nome..." value="<?php echo htmlspecialchars($contato['nome']) ?>">
                    </td>
                    <td>
                        <input type="tel" name="telefone[]" class="form-control" placeholder="Telefone..." value="<?php echo htmlspecialchars($contato['telefone']) ?>">
                    </td> 
                    <td style="width: 1px">
                        <button type="button" class="btn btn-info btn-flat duplicador-mais"><i class="fa fa-fw fa-plus"></i></button>
                    </td> 
                </tr>
                <?php } ?>
                </tbody></table>

                <hr>
                <strong><br><i class="fa fa-fw fa-male margin-r-5"></i>Medidas</strong><br><br>
                <?php
                if (empty($linha_alterar['medidas']))
                    $linha_alterar['medidas'][] = array();
                foreach ($linha_alterar['medidas'] as $medida) {
                    ?>
                    <div class="col-lg-3">
                        Altura: <input type="number" name="altura[]" class="form-control" step="0.01" min="0" value="<?php echo htmlspecialchars($medida['altura']) ?>">
                    </div>
                    <div class="col-lg-3">
                        Peso: <input type="number" name="peso[]" class="form-control" step="0.001" min="0" value="<?php echo htmlspecialchars($medida['peso']) ?>" >
                    </div>
                    <div class="col-lg-3">
                        Massa magra: <input type="number" name="massa_magra[]" class="form-control" step="0.001" min="0" value="<?php echo htmlspecialchars($medida['massa_magra']) ?>">
                    </div>
                    <div class="col-lg-3">
                        Gordura Corporal: <input type="number" name="gordura_corporal[]" class="form-control" step="0.001" min="0" value="<?php echo htmlspecialchars($medida['gordura_corporal']) ?>">
                    </div><br><br>
                <?php } ?>

                <hr>
                <br><strong><i class="fa fa-fw fa-diamond margin-r-5"></i>Academia</strong><br><br>
                <div class="col-lg-6">
                    Academias já frequentádas:<textarea name="academia_frequentada" class="form-control" rows="2" placeholder="Nenhum..."><?php echo htmlspecialchars($linha_alterar['academia_frequentada']) ?></textarea> 
                </div>
                <div class="col-lg-6">
                    Academia atual:<textarea name="academia_atual" class="form-control" rows="2" placeholder="Nenhum..."><?php echo htmlspecialchars($linha_alterar['academia_atual']) ?></textarea> 
                </div><br><br>


                <hr>
                <strong><br><i class="fa fa-fw fa-bicycle margin-r-5"></i>Esportes Praticados </strong><br><br>

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

                    </div>
                </div><br>
                <?php
                $valor = array_diff($linha_alterar['exercicios'], array(
                    'Futebol',
                    'Karatê',
                    'Basquete',
                    'Balé',
                    'Jiu-jitsu',
                    'Corrida',
                    'Caminhada',
                    'Ping-Pong',
                    'Skate',
                    'Natação',
                    'Bicicleta',
                ));
                ?>
                <input type="text" name="outros_exercicios" class="form-control" placeholder="Outros... (para mais de um item separe com vírgula)" value="<?php echo htmlspecialchars(implode(',', $valor)) ?>"><br><br>




                <button type="submit" class="btn btn-primary btn-flat">Alterar</button>
            </div>                    
            </div>
        </form>
    </section>
<!--</div>-->

<?php
require_once './template/rodape_especial.php';
