<?php
$pagina = "Meu Perfil";

require_once './template/cabecalho.php';


$query = "select * from usuario where id='" . $_SESSION['id'] . "'";
$resultado = mysqli_query($conexao, $query) or die('ERRO: ' . mysqli_error($conexao) . PHP_EOL . $query . PHP_EOL . print_r(debug_backtrace(), true));
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Atualização do perfil</h1>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Meu Perfil</h3>
                </div>
                <form role="form" method="post" enctype="multipart/form-data" action="alterar_perfil.php">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($linha['nome']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= htmlspecialchars($linha['sobrenome']) ?>">
                        </div>
<!--                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($linha['email']) ?>">
                        </div>-->
                        <div class="form-group">
                            <label>Sexo</label>
                            <select class="form-control select2" name="sexo" style="width: 100%;">                              
                                <option value="">(Selecione)</option>
                                <option value="feminino" <?php if ($linha['sexo'] == "feminino") echo ' selected="selected"'; ?>>Feminino</option>
                                <option value="masculino" <?php if ($linha['sexo'] == "masculino") echo ' selected="selected"'; ?>>Masculino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Data de nascimento:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>                                    
                                </div>
                                <input type="text" class="form-control pull-right" id="datanasc" name="datanasc" value="<?= (!empty($linha['datanasc']) ? date('d/m/Y', dataParse($linha['datanasc'])) : '') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <?php if (!empty($linha['foto'])) { ?>
                                <img class="profile-user-img img-responsive" style="margin: 0;margin-bottom: 2px" src="<?= htmlspecialchars($linha['foto']) ?>" alt="User profile picture">
                                <label for="fotoremover"><input type="checkbox" class="flat-red" id="fotoremover" name="fotoremover" value="1"> Remover foto atual</label>
                            <?php } ?>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>


                </form>
            </div>
        </section>
<!--    </div>-->

    
    <!--fim content-wrapper-->
    <?php
} else {

    echo "Não foi possivel";
}
include './template/rodape_especial.php';
