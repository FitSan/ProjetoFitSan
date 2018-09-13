<?php
$pagina = 'Configurar Perfil';
require_once './template/cabecalho.php';

$pagina = "Meu Perfil";

require_once './template/cabecalho.php';


$query = "select * from usuario where id='" . $_SESSION['id'] . "'";
$resultado = mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Configuração do perfil</h1>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Meu Perfil</h3>
                </div>
                <form role="form" method="post" enctype="multipart/form-data" action="atualizar_conf.php">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="novo_nome">Nome</label>
                            <input type="text" class="form-control" id="novo_nome" name="novo_nome" value="<?= htmlspecialchars($linha['nome']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="novo_sobrenome">Sobrenome</label>
                            <input type="text" class="form-control" id="novo_sobrenome" name="novo_sobrenome" value="<?= htmlspecialchars($linha['sobrenome']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="novo_email">E-mail</label>
                            <input type="text" class="form-control" id="novo_email" name="novo_email" value="<?= htmlspecialchars($linha['email']) ?>">
                        </div>

                        <h4> Trocar Senha</h4>

                        <div class="form-group">
                            <label for="nova_senha">Nova Senha</label>
                            <input type="text" class="form-control" id="nova_senha" name="nova_senha" >
                        </div>

                        <div class="form-group">
                            <label for="repita_senha">Repita sua Senha</label>
                            <input type="text" class="form-control" id="repita_senha" name="repita_senha" >
                        </div>

                        <?php
                        if (!empty($_SESSION['diver_senha'])) {
                            ?> <div class="alert alert-danger">
                                <strong>Senhas Divergentes!</strong>.
                            </div> <?php
                            unset($_SESSION['diver_senha']);
                        }
                        ?>

                    </div>



                    <?php
                    if (!empty($_SESSION['atualizado'])) {
                        ?> <div class="alert alert-success">
                            <strong>Atualizado com sucesso!</strong>.
                        </div> <?php
                unset($_SESSION['atualizado']);
            }
                    ?> 


                    <?php
                    if (!empty($_SESSION['semsenha'])) {
                        ?> <div class="alert alert-danger">
                            <strong> Senha Incorreta !</strong>.
                        </div> <?php
                unset($_SESSION['semsenha']);
            }
                    ?>



                    <div class="pull-left">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-salvar">
                            Salvar
                        </button>                                                
                    </div>






                </form>
        </section>


    </div>
    <!--fim content-wrapper-->
    <?php
} else {

    echo "Não foi possivel";
}
include './template/rodape_especial.php';

