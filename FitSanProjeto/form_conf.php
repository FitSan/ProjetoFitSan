<?php
$pagina = 'Configurar Perfil';
require_once './template/cabecalho.php'; 
require_once './template/menu.php';

$query = "select * from usuario where id='" . $_SESSION['id'] . "'";
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
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
                <form role="form" method="post" enctype="multipart/form-data" action="<?=URL_SITE?>atualizar_conf.php">
                    <div class="box-body">
<?php if (!tipoLogado("admin")){ ?>
                         <div class="form-group">
                            <label for="novo_email">E-mail</label>
                            <input type="text" class="form-control"  name="novo_email" value="<?= htmlspecialchars($linha['email']) ?>">
                        </div>
<?php } ?>

                        <h4> Trocar Senha</h4>

                        <div class="form-group">
                            <label for="nova_senha">Nova Senha</label>
                            <input type="password" class="form-control" name="nova_senha" >
                        </div>

                        <div class="form-group">
                            <label for="repita_senha">Repita sua Senha</label>
                            <input type="password" class="form-control"  name="repita_senha" >
                        </div>
                        <div class="form-group" style="display: none; border: 5px solid #cb2027; padding: 0 5px 5px 5px; " id="inputSenha" >
                            <label  for="insira_senha"><h3>Insira sua senha para completar a atualização!</h3></label>
                            <input type="password" name="insira_senha" class="form-control" placeholder=" Senha">
                            <span class="glyphicon  form-control-feedback"></span>
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
                    if (!empty($_SESSION['errosenha'])) {
                        ?> <div class="alert alert-danger">
                            <strong> Senha Incorreta !</strong>.
                        </div> <?php
                unset($_SESSION['errosenha']);
            }
                    ?>
                    
                                        <?php
                    if (!empty($_SESSION['diver_senha'])) {
                        ?> <div class="alert alert-danger">
                            <strong> Senha Incorreta !</strong>.
                        </div> <?php
                unset($_SESSION['diver_senha']);
            }
                    ?>



                    <div class="pull-left" style="display: none;" id="submit">
                      
                        <button type="submit" class="btn btn-primary" onclick="showInput()">
                                   Salvar 
                        </button>                                                
                    </div>
                    <div class="pull-left">
                      
                        <button type="button" class="btn btn-primary" onclick="getElementById('inputSenha').style.display='block'; getElementById('submit').style.display='block'; this.style.display='none'">
                                   Salvar 
                        </button> 
<?php if (!tipoLogado("admin")){ ?>
                        <a href="<?=URL_SITE?>desativarP.php" type="button" class="btn btn-danger">Desativar Conta</a>
<?php } ?>
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

