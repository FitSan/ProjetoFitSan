<?php
$pagina = "Meu Perfil";
require_once './template/cabecalho.php';

if ($_SESSION['tipo'] == 'profissional') {
    $query = "select * from usuario u left join vinculo v on v.aluno_id = u.id and v.profissional_id = $_SESSION[id] where u.id=" . mysqliEscaparTexto($_GET['id']);
    $usuario_busca = 'aluno_id';
} else {
    $query = "select * from usuario u left join vinculo v on v.profissional_id = u.id and v.aluno_id = $_SESSION[id] where u.id=" . mysqliEscaparTexto($_GET['id']);
    $usuario_busca = 'profissional_id';
}
$resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Perfil de Usuário
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
                            <h3 class="profile-username text-center"><?= $linha['nome'] ?> <?= $linha['sobrenome'] ?></h3>
                            <p class="text-muted text-center"><?= $linha['email'] ?></p>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b><?= (!empty($linha['sexo']) ? ucfirst($linha['sexo']) : '(Não definido)') ?></b> <a class="pull-right"><?= (!empty($linha['datanasc']) ? calculaidade($linha['datanasc']) : '??') ?> anos</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Data de nascimento:</b><a class="pull-right"><?= (!empty($linha['datanasc']) ? date('d/m/Y', dataParse($linha['datanasc'])) : '(Não definido)') ?></a>
                                </li>
                            </ul>
                            <?php if ($linha['status'] === 'aprovado') {
                                ?><a href="desvincular.php?id=<?= $linha['id'] ?>" class="btn btn-info btn-block"><b>Deixar de seguir</b></a><?php
                            } elseif ($linha['status'] === 'espera') {
                                if ($linha['solicitante'] == $_SESSION['tipo']) {
                                    ?>   
                                    <button type="button" class="btn btn-block btn-warning">Aguardando</button>
                                    <?php
                                } else {
                                    ?>

                                    <a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=aprovado" class="btn btn-success btn-block"><b>Aceitar</b></a>
                                    <a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=negado" class="btn btn-danger btn-block"><b>Negar</b></a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="vincular.php?id=<?= $linha['id'] ?>" class="btn btn-primary btn-block"><b>Seguir</b></a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php if (!empty($_SESSION['tipo'] == "profissional")) { ?>
                    <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informações Adicionais</h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-fw fa-medkit margin-r-5"></i>Ficha médica</strong><br><br>
                                <b>Problemas de saúde:</b> Resposta <br>
                                <b>Notas médicas:</b> Resposta <br>
                                <b>Alergias e reações:</b> Resposta <br>
                                <b>Medicamentos:</b> Resposta <br>
                                <b>Grupo sanguíneo:</b> Resposta <br>
                                <i class="fa fa-fw fa-heart-o"></i><b>Doador de Orgão:</b> Resposta <br>

                                <hr>
                                <strong><i class="fa fa-fw fa-phone"></i> Contato de emergência</strong><br><br>
                                <b>Mãe:</b> Neide Guzzatti Konig - 4836267585 <br>
                                <b>Cônjuge:</b> Diego Pereira - 4899999999 <br>

                                <hr>
                                <strong><i class="fa fa-fw fa-male margin-r-5"></i>Medidas</strong><br><br>

                                <b>Altura:</b>Resposta <br>
                                <b>Peso:</b>Resposta <br>
                                <b>Massa magra:</b>Resposta <br>
                                <b>Gordura corporal:</b>Resposta <br>
                                <b>IMC:</b>Resposta

                                <hr>
                                <strong><i class="fa fa-fw fa-diamond margin-r-5"></i>Academia</strong><br><br>

                                <b>Academias já frequentadas:</b>Resposta <br>
                                <b>Academia atual:</b>Resposta 

                                <hr>
                                <strong><i class="fa fa-fw fa-bicycle margin-r-5"></i>Esportes Praticados </strong><br><br>

                                <span class="label label-danger">Caminhada</span>
                                <span class="label label-success">Bicicleta</span>
                                <span class="label label-info">Ping-Pong</span>
                                <span class="label label-warning">Futebol</span>
                                <span class="label label-primary">Volei</span><br><br>

                                
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
