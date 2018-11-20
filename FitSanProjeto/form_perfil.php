<?php
$pagina = "Meu Perfil";

require_once './template/cabecalho.php';
require_once './template/menu.php';


$query = "select * from usuario where id='" . $_SESSION['id'] . "'";
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Atualização do perfil</h1>
        </section>

        <section class="content">
            <?php
        if (!empty($_SESSION['erro'])) {
            ?>
            <div class="alert alert-danger alert-dismissible" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo htmlspecialchars($_SESSION['erro']) ?>
            </div>
            <?php
            unset($_SESSION['erro']);
        } ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Meu Perfil</h3>
                </div>
                <form role="form" method="post" enctype="multipart/form-data" action="<?=URL_SITE?>alterar_perfil.php">
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
                             <label for="foto">Foto</label><br>
                            <div class="pull-left ">
                             <?php if ($mobiledet->isMobile() || $mobiledet->isTablet()){ ?>
                                     <a class="btn btn-file btn-app">
                                         <i class="fa fa-mobile" ></i>
                                         <input  type="file" name="foto" id="foto" accept="image/png, image/jpeg, image/gif"> Celular </a>
                             <?php } else { ?>
                                     <a class="btn btn-file btn-app" data-toggle="modal" data-target="#modal-upload-imagem" id="modal-upload-imagem-button" title="Upload de imagem" data-input="foto-sel">
                                         <i class="fa fa-cloud-upload"></i> Upload </a>
                                         <input type="hidden" id="foto-sel" name="foto-sel" value="">
                             <?php } ?>
                            </div>
                                <br><br><br><br><?php if (!empty($linha['foto'])) { ?>
                               <img class="profile-user-img img-responsive" style="margin: 0;margin-bottom: 2px" src="<?= htmlspecialchars($linha['foto']) ?>" alt="User profile picture">
                                <label for="fotoremover"><input type="checkbox" class="flat-red" id="fotoremover" name="fotoremover" value="1"> Remover foto atual</label>
                            <?php } ?>
                             
                                <br>
                            
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
