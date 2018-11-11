<?php
$pagina = "Alterar dica";
include './template/cabecalho.php';
if (!tipoLogado('profissional')) {
    header('Location: ' . URL_SITE . 'pagina1.php');
}

$dica_id = $_GET['id'];

$query_dica = "select * from dica where id = $dica_id";
$resultado_dica = mysqli_query($conexao, $query_dica);
$linha_dica = mysqli_fetch_array($resultado_dica);
?>

<div class="content-wrapper" onload="viewUpload()">
    <section class="content-header">
        <h2 style="padding: 10px"><?= $pagina ?></h2>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form role="form" method="post" enctype="multipart/form-data" action="<?= URL_SITE ?>alterar_dica.php">
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
                        <label for="titulo">Titulo</label>
                        <input name="titulo" class="form-control" id="titulo" type="text" value="<?= $linha_dica['titulo'] ?>">
                    </div>
                    <div class="form-group">
                        <input name="id" value="<?= $linha_dica['id'] ?>" hidden>           
                        <textarea class="form-control" rows="14" cols="80"  name="dica" ><?= htmlspecialchars($linha_dica['texto']) ?></textarea>
                    </div>
                    <?php
                    $query_upload = "select * from upload_dica where dica_id = $linha_dica[id]";
                    $resultado_upload = mysqli_query($conexao, $query_upload);
                    $num = 0;
                    $count = 0;
                    while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                        $count += 1;
                        $num = $num + 1;
                        $check = 'check' . $num;
                        $label = 'label' . $num;
                        ?>
                        <?php
                        if ($linha_upload['tipo'] != 'img') {
                            if ($linha_upload['tipo'] == 'vid') {
                                ?>
                                <div class="embed-container"><iframe id="<?= $num ?>" src="<?= $linha_upload['nome_arq'] ?>" frameborder="0" allowfullscreen></iframe></div>                               
                                <?php
                            } else {
                                ?>
                                <a href="<?= $linha_upload['nome_arq'] ?>" id="<?= $num ?>" target="_blank"><?= $linha_upload['nome_arq'] ?></a>
                                <?php
                            }
                            $img = false;
                        } else {
                            $img = true;
                            if ($count == 1) {
                                ?>
                                <div id="uploads"><ul>
                                    <?php }
                                    ?>  
                                    <li><img id="<?= $num ?>" src="<?= URL_SITE ?>uploads/dicas/<?= $linha_upload['nome_arq'] ?>" height="300" style="padding: 5px;"></li>                

                                    <?php }
                                ?>
                                <label class="btn" for="<?= $check ?>"><b style="font-size: 22px;" id="<?= $label ?>"><i class="fa fa-minus-circle"></i></b></label>
                                <input type="checkbox" id="<?= $check ?>" name="id_upload[]" onclick="hideUpload(<?= $num ?>, this)" value="<?= $linha_upload['id'] ?>" style="display:none;">     
                                <?php
                            } if ($img) {
                                ?>
                            </ul>
                        </div>                            
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span><img src="<?= URL_SITE ?>img/upload_img.png" height="40"></span><input type="file" name="imagens[]" multiple="multiple" hidden accept="image/png, image/jpeg"></span>
                            <b style="padding: 5px ">ou</b>
                            <label class="btn btn-default btn-file" for="check_link" onclick="showFormLink()"><img src="<?= URL_SITE ?>img/upload_vid.png" height="40"></label><input type="checkbox" name="check_link" id="check_link" hidden>
                            <div class="col-md-6 input-group" style="visibility: hidden;" id="form_link">
                                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                <input type="text" class="form-control" placeholder="Link de seu video. (Novo link substituirá o anterior)" name="link_video" >
                            </div>
                        </div>
                    </div>    
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a class="btn btn-danger" href="<?= URL_SITE ?>minhas_dicas.php">Cancelar</a>
                </form>                
            </div>
        </div>
    </section>


</div>

<?php
include './template/rodape_especial.php';

