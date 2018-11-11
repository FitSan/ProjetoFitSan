<?php
$pagina = 'Minhas Dicas';
include './template/cabecalho.php';

if (!tipoLogado('profissional')) {
    header('Location: ' . URL_SITE . 'pagina1.php');
}

$query = "select * from dica where profissional_id=$_SESSION[id] order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1 style="padding: 10px"><?= $pagina ?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form role="form" method="post" enctype="multipart/form-data" action="<?= URL_SITE ?>enviar_dica.php">
                    <?php
                    if (!empty($_SESSION['msg'])) {
                        ?>
                        <div class="alert alert-danger alert-dismissible" >
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo htmlspecialchars($_SESSION['msg']) ?>
                        </div>
                        <?php
                        unset($_SESSION['msg']);
                    }
                    if (!empty($_SESSION['info'])) {
                        ?>
                        <div class="alert alert-info alert-dismissible" >
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo htmlspecialchars($_SESSION['info']) ?>
                        </div>
                        <?php
                        unset($_SESSION['info']);
                    }
                    ?>
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input name="titulo" class="form-control" id="titulo" type="text">
                    </div>
                    <div class="form-group">          
                        <textarea class="form-control" rows="14" cols="80"  name="dica" placeholder="Digite sua dica."></textarea>
                    </div>
                    <div class="form-inline">
<!--                        <input type="file" name="imagens[]" multiple="multiple" hidden accept="image/png, image/jpeg">
                        ou
                        <input type="file" name="video" >-->
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span><img src="<?= URL_SITE ?>img/upload_img.png" height="40"></span><input type="file" name="imagens[]" multiple="multiple" hidden accept="image/png, image/jpeg"></span>
<!--                            <span class="fileinput-filename"></span><span class="fileinput-new">No file chosen</span>-->
                            <!--                        </div>-->
                            <b style="padding: 5px ">ou</b>
                            <!--                        <div class="fileinput fileinput-new" data-provides="fileinput">-->
                            <label class="btn btn-default btn-file" for="check_link" onclick="showFormLink()"><img src="<?= URL_SITE ?>img/upload_vid.png" height="40"></label><input type="checkbox" name="check_link" id="check_link" hidden>
                            <div class="col-md-6 input-group" style="visibility: hidden;" id="form_link">
                                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                <input type="text" class="form-control" placeholder="Link de seu video." name="link_video">
                            </div>

<!--                            <span class="fileinput-filename"></span><span class="fileinput-new">No file chosen</span>-->
                        </div>
<!--                        <input type="file" name="arquivos[]" class="form-control" multiple="multiple" accept="image/png, image/jpeg, video/*">-->
                    </div>    
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Salvar</button>
                    <a class="btn btn-danger" href="<?= URL_SITE ?>minhas_dicas.php" style="margin-top: 10px;">Cancelar</a>
                </form>
            </div>
        </div>

        <?php
        while ($linha = mysqli_fetch_array($resultado)) {
            ?>
            <div style="margin: 0 auto; width: 90%;">      
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="user-block">


                            <span>
                                <?= (empty($linha['titulo'])) ? '<i style="font-size: 18px;">No title</i>' : '<b style="font-size: 18px;">' . $linha['titulo'] . '</b>' ?><i style="font-size: 15px; padding: 0 5px;">-</i>
                                <button type="button" class="pull-right btn-box-tool" data-toggle="modal" data-target="#excluir-dica" data-id="<?= $linha['id'] ?>"><i class="fa fa-times" style="font-size:20px"></i></button>
                                <a href="<?= URL_SITE ?>form_alterarDica.php?id=<?= $linha['id'] ?>"><button type="button" class="pull-right btn-box-tool" ><i class="fa fa-edit" style="font-size:20px"></i></button></a>    
                                <!--Fim do icone x-->
                            </span>
                            <span><?= date('d/m/Y H:i:s', dataParse($linha['data_envio'])) ?></span>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" >
                        <p> <?= nl2br(htmlentities($linha['texto'])) ?> </p> 
                        <?php
                        $query_dica = "select * from upload_dica where dica_id = $linha[id]";
                        $resultado_upload = mysqli_query($conexao, $query_dica);
                        if (mysqli_num_rows($resultado_upload) > 0) {
                            $count = 0;
                            while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                                if ($linha_upload['tipo'] != 'img') {
                                    if ($linha_upload['tipo'] == 'vid') {
                                        ?> 
                                        <div class="embed-container"><iframe  src="<?= $linha_upload['nome_arq'] ?>" frameborder="0" allowfullscreen></iframe>                                  
                                            <?php
                                        } else {
                                            ?>
                                            <div><a href="<?= $linha_upload['nome_arq'] ?>"  target="_blank"><?= $linha_upload['nome_arq'] ?></a>
                                                <?php
                                            }
                                            $img = false;
                                        } else {
                                            $count += 1;
                                            $img = true;
                                            $id = $linha['id'];
                                            if ($count == 1) {
                                                ?>
                                                <div class="wrap" id="<?= $id ?>">
                                                    <section class="container galery-container">
                                                    <?php }
                                                    ?>  
                                                    <div class="mySlides" <?= ($count > 1) ? ' style="display: none;"' : '' ?>><img class="imgslide img img-responsive " src="<?= URL_SITE ?>uploads/dicas/<?= $linha_upload['nome_arq'] ?>" style="padding: 5px; margin: 0 auto;"></div>                

                                                    <?php
                                                }
                                            } if ($img) {
                                                if ($count > 1) {
                                                    ?>
                                                    <a class="prev" onclick="plusSlides(-1, <?= $id ?>)">&#10094;</a>
                                                    <a class="next" onclick="plusSlides(1, <?= $id ?>)">&#10095;</a>
                                                <?php } ?>
                                            </section>
                                        <?php } ?>                                                
                                    </div>
                                <?php } ?>                 
                            </div>
                            <!-- /.box-body -->

                        </div>
                    </div>         
                    <?php
                }
                ?>
                </section>
                <!--</div>-->


                <?php
                include './template/rodape_especial.php';

                