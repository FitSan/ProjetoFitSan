<?php
$pagina = "Histórico";
require_once './template/cabecalho.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php
            if (estaLogado()) {
            echo 'Histórico de ' . exibirName();
            $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'atividadesExtras');
            }
            ?>
        </h1>
    </section>
    <br>
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li<?php if ($aba == 'atividadesExtras') echo ' class="active"'; ?>><a href="#atividadesExtras" data-toggle="tab">Atividades Extras</a></li>
                <li<?php if ($aba == 'pesosMedidas') echo ' class="active"'; ?>><a href="#pesosMedidas" data-toggle="tab">Pesos e Medidas</a></li>
                <li<?php if ($aba == 'treinosPlanilha') echo ' class="active"'; ?>><a href="#treinosPlanilha" data-toggle="tab">Treinos da Planilha</a></li>
                <li<?php if ($aba == 'avaliacoes') echo ' class="active"'; ?>><a href="#avaliacoes" data-toggle="tab">Avaliações</a></li>
            </ul>
            <div class="tab-content">               
                <div class="tab-pane<?php if ($aba == 'atividadesExtras') echo ' active'; ?>" id="atividadesExtras">

                    <!-- Post -->
                    Postar Histórico de atividades extras.
                    <!-- /.post -->

                </div>

                <div class="tab-pane<?php if ($aba == 'pesosMedidas') echo ' active'; ?>" id="pesosMedidas">

                    <!-- Post -->
                    Postar históricos de peso e medidas.
                    <!-- /.post -->

                </div>

                <div class="tab-pane<?php if ($aba == 'treinosPlanilha') echo ' active'; ?>" id="treinosPlanilha">

                    <!-- Post -->
                    Postar o historico dos treinos das planilhas.
                    <!-- /.post -->

                </div>

                <div class="tab-pane<?php if ($aba == 'avaliacoes') echo ' active'; ?>" id="avaliacoes">

                    <?php
                    $usuarios = array();
                    $query = "select * from `avaliacao` inner join `notificacao` on `avaliacao`.aluno_id=`notificacao`.aluno_id where `notificacao`.lido='L'  and `avaliacao`.aluno_id =" . $_SESSION['id'];
                    $retorno = mysqli_query($conexao, $query);
                    while ($linhas = mysqli_fetch_array($retorno)) {
                    array_push($usuarios, $linhas);
                    }
                    

                    if ($usuarios == null) {
                    ?>
                    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Você não possui nenhuma avaliação!</b></h3></div>
                    <?php
                    } else {

                        foreach ($usuarios as $usuario) {
                            ?>

                            <?php
                            $sql = "select * from `usuario` where id=" . $usuario['profissional_id'];
                            $retorno_usuario = mysqli_query($conexao, $sql);
                            $linha = (mysqli_fetch_array($retorno_usuario));



                            $id_avaliacao = $usuario['id'];
                            ?>



                            <div class="nav-tabs-custom" align="center">
                                <div class="tab-content">


                                    <div class="timeline-item">

                                        <samp class="border border-primary"></samp>

                                        <span class="time"><i class="calendar-table"></i> <?= date('d/m/Y', dataParse($usuario['data'])) ?></span>

                                        <h3 class="timeline-header">Avaliação do profissional <br> <strong><?php echo htmlspecialchars($linha['nome']) ?> <?= htmlspecialchars($linha['sobrenome']); ?></strong></h3>



                                        <a href="http://localhost/FitSan/form_mostrar_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>">  
                                            <button type="button" class="btn btn-primary btn-flat"> Conferir </button>
                                        </a>





                                    </div>
                                </div>
                            </div>



                            <?php
                        }
                    }
                    ?> 



                </div>

            </div>
        </div>
    </div> 
    <!--</div>-->

    <?php
    require_once './template/rodape_especial.php';
    