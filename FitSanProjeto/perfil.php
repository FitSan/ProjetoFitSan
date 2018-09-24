<?php
$pagina = "Meu Perfil";

require_once './template/cabecalho.php';


$query = "select * from usuario where id=" . $_SESSION['id'];
$resultado = mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Meu perfil
            </h1>
            <ol class="breadcrumb">
                <li> <?= breadcrumbs() ?></li>
            </ol>
        </section> 

        <section class="content">

            <div class="row">
                <div class="col-md-3">


                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">

                            <h3 class="profile-username text-center"><?= htmlspecialchars($linha['nome']) ?> <?= htmlspecialchars($linha['sobrenome']) ?></h3>

                            <p class="text-muted text-center"><?= htmlspecialchars($linha['email']) ?></p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b><?= (!empty($linha['sexo']) ? ucfirst($linha['sexo']) : '(Não definido)') ?></b> <a class="pull-right"><?= (!empty($linha['datanasc']) ? calculaidade($linha['datanasc']) : '??') ?> anos</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Data de nascimento</b> <a class="pull-right"><?= (!empty($linha['datanasc']) ? date('d/m/Y', dataParse($linha['datanasc'])) : '(Não definido)') ?></a>
                                </li>
                            </ul>

                            <a href="form_perfil.php" class="btn btn-primary btn-block"><b>Alterar</b></a>
                        </div>
                    </div>
                    <?php if (getTipo() == "aluno") {

                        //referente ao formulário
                        $query_alterar = "select * from informacoes_adicionais where aluno_id = " . mysqliEscaparTexto($_SESSION['id']);
                        $resultado_alterar = mysqli_query($conexao, $query_alterar) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_alterar . PHP_EOL . print_r(debug_backtrace(), true));
                        $linha_alterar = ($resultado_alterar ? mysqli_fetch_array($resultado_alterar) : array());
                        if (!empty($linha_alterar['id'])) {
                            $query_cont_alterar = "select * from informacoes_adicionais_contatos where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_cont_alterar = mysqli_query($conexao, $query_cont_alterar) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_cont_alterar . PHP_EOL . print_r(debug_backtrace(), true));
                            $linha_alterar['contatos'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_cont_alterar)) $linha_alterar['contatos'][] = $linha2;
                            $query_exe_alterar = "select * from informacoes_adicionais_exercicios where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_exe_alterar = mysqli_query($conexao, $query_exe_alterar) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_exe_alterar . PHP_EOL . print_r(debug_backtrace(), true));
                            $linha_alterar['exercicios'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_exe_alterar)) $linha_alterar['exercicios'][] = $linha2['exercicios'];
                            $query_med_alterar = "select * from informacoes_adicionais_medidas where informacoes_adicionais_id= " . mysqliEscaparTexto($linha_alterar['id']);
                            $resultado_med_alterar = mysqli_query($conexao, $query_med_alterar) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query_med_alterar . PHP_EOL . print_r(debug_backtrace(), true));
                            $linha_alterar['medidas'] = array();
                            while ($linha2 = mysqli_fetch_array($resultado_med_alterar)) $linha_alterar['medidas'][] = $linha2;
                        }

                        
                        
                        ?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informações Adicionais</h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-fw fa-medkit margin-r-5"></i>Ficha médica</strong><br><br>
                                <b>Problemas de saúde:</b> <?php echo htmlspecialchars(!empty($linha_alterar['saude']) ? $linha_alterar['saude'] : '(Não informado)')  ?> <br>
                                <b>Notas médicas:</b> <?php echo htmlspecialchars(!empty($linha_alterar['medico']) ? ($linha_alterar['medico']) : '(Não informado)') ?> <br>
                                <b>Alergias e reações:</b> <?php echo htmlspecialchars(!empty($linha_alterar['alergia']) ? ($linha_alterar['alergia']) : '(Não informado)') ?> <br>
                                <b>Medicamentos:</b> <?php echo htmlspecialchars(!empty($linha_alterar['medicamento']) ? ($linha_alterar['medicamento']) : '(Não informado)') ?> <br>
                                <b>Grupo sanguíneo:</b> <?php echo htmlspecialchars(!empty($linha_alterar['gruposangue']) ? ($linha_alterar['gruposangue']) : '(Não informado)') ?> <br>
                                <i class="fa fa-fw fa-heart-o"></i><b>Doador de Orgão:</b> <?php echo htmlspecialchars(!empty($linha_alterar['doador']) ? ($linha_alterar['doador']) : '(Não informado)') ?> <br>

                                <hr>
                                <strong><i class="fa fa-fw fa-phone"></i> Contato de emergência</strong><br><br>
                                <?php
                                if (!empty($linha_alterar['contatos'])){
                                    foreach ($linha_alterar['contatos'] as $contato) {
                                ?>
                                        <b><?php echo htmlspecialchars($contato['tipo']) ?>:</b> <?php echo htmlspecialchars($contato['nome']) ?> - <?php echo htmlspecialchars($contato['telefone']) ?> <br>
                                <?php
                                    }
                                } else {
                                ?>
                                        Não informado <br>
                                <?php
                                }
                                ?>

                                <hr>
                                <strong><i class="fa fa-fw fa-male margin-r-5"></i>Medidas</strong><br><br>

                                <b>Altura:</b> <?php echo !empty($linha_alterar['medidas'][0]['altura']) ? numeroFormatar($linha_alterar['medidas'][0]['altura'], -2) : '(Não informado)' ?><br>
                                <b>Peso:</b><?php echo  !empty($linha_alterar['medidas'][0]['peso']) ? numeroFormatar($linha_alterar['medidas'][0]['peso'], -3)  : '(Não informado)' ?> <br>
                                <b>Massa magra:</b><?php echo !empty($linha_alterar['medidas'][0]['massa_magra']) ? numeroFormatar($linha_alterar['medidas'][0]['massa_magra'], -3) : '(Não informado)' ?> <br>
                                <b>Gordura corporal:</b><?php echo !empty($linha_alterar['medidas'][0]['gordura_corporal']) ? numeroFormatar($linha_alterar['medidas'][0]['gordura_corporal'], -3) : '(Não informado)' ?> <br>
                                <b>IMC:</b><?php echo (!empty($linha_alterar['medidas'][0]['peso']) && !empty($linha_alterar['medidas'][0]['altura']))? numeroFormatar($linha_alterar['medidas'][0]['peso'] / pow($linha_alterar['medidas'][0]['altura'], 2), -2) : '(Não informado)'?>

                                <hr>
                                <strong><i class="fa fa-fw fa-diamond margin-r-5"></i>Academia</strong><br><br>

                                <b>Academias já frequentadas:</b> <?php echo htmlspecialchars(!empty($linha_alterar['academia_frequentada']) ? ($linha_alterar['academia_frequentada']) : '(Não informado)' ) ?> <br>
                                <b>Academia atual:</b><?php echo htmlspecialchars(!empty($linha_alterar['academia_atual']) ? ($linha_alterar['academia_atual']) : '(Não informado)' ) ?> 

                                <hr>
                                <strong><i class="fa fa-fw fa-bicycle margin-r-5"></i>Esportes Praticados </strong><br><br>
                                
                                <?php
                                $classes = array('label-danger', 'label-success', 'label-info', 'label-warning', 'label-primary'); $clsindice = 0;
                                if (!empty($linha_alterar['exercicios'])){
                                foreach ($linha_alterar['exercicios'] as $exercicio) {
                                    $classe = $classes[$clsindice++];
                                    if ($clsindice >= count($classes)) $clsindice = 0;
                                ?>
                                 <span class="label <?php echo $classe ?>"><?php echo htmlspecialchars($exercicio) ?></span>
                                <?php }
                                } else {
                                ?>
                                        Não informado <br>
                                <?php
                                } ?>

                                 <hr>


                                <a href="informacoes_adicionais.php" class="btn btn-primary btn-block"><b>Alterar</b></a>
                            </div>                    
                        </div> 
                    <?php } ?>              
                </div>
                kkk
            </div>       
        </section>
    </div>

    <?php
} else {

    echo "Não Foi possivel obter a informação deste usuário.";
}
include './template/rodape_especial.php';
