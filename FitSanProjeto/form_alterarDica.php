<?php
$pagina = "Alterar dica";
include './template/cabecalho.php';
if (tipoLogado('profissional')){
    header('Location: pagina1.php');
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
                <form role="form" method="post" enctype="multipart/form-data" action="alterar_dica.php">
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
                    ?>
                    <div class="form-group">
                        <label for="nome">Profissional</label>
                        <input name="nome" class="form-control" id="nome" type="text" value="<?= $_SESSION['nome'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input name="id" value="<?= $linha_dica['id'] ?>" hidden>           
                        <textarea class="form-control" rows="5" maxlength="255" name="dica" ><?= $linha_dica['texto'] ?></textarea>
                    </div>    
                    <div class="form_group" id="uploads" style="padding: 5px;">
                        <ul>
                        <?php
                        $query_upload = "select * from upload_dica where dica_id = $linha_dica[id]";
                        $resultado_upload = mysqli_query($conexao, $query_upload);
                        $num = 0;
                        while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                            $num = $num + 1;
                            $check = 'check'.$num;
                            $label = 'label'.$num;
                            ?>
                                <?php
                            if ($linha_upload['tipo'] != 'img') {
                                ?>                 
                            <li><video id="<?= $num ?>" height="300" style="padding: 5px;" onclick="hideUpload(this)">
                                    <source src="upload/dica/<?= $linha_upload['nome_arq'] ?>" > 
                                </video></li>                         
                                <?php
                            } else {
                                ?>  
                                <li><img id="<?= $num ?>" src="upload/dica/<?= $linha_upload['nome_arq'] ?>" height="300" style="padding: 5px;" onclick="hideUpload(this)"></li>

                                <?php
                            }
                            ?>
                                <label class="btn btn-default" for="<?= $check ?>"><b style="font-size: 20px;" id="<?= $label?>">x</b></label>
                                <input type="checkbox" id="<?= $check ?>" name="id_upload[]" onclick="hideUpload(<?= $num ?>, this)" value="<?= $linha_upload['id'] ?>" style="display:none;">
                            <?php
                        }?>
                        </ul>
                    </div>
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file"><span><img src="img/upload_img.png" height="40"></span><input type="file" name="imagens[]" multiple="multiple" hidden accept="image/png, image/jpeg"></span>
<!--                            <span class="fileinput-filename"></span><span class="fileinput-new">No file chosen</span>-->
                            <!--                        </div>-->
                            <b style="padding: 5px ">ou</b>
                            <!--                        <div class="fileinput fileinput-new" data-provides="fileinput">-->
                            <span class="btn btn-default btn-file"><span><img src="img/upload_vid.png" height="40"></span><input type="file" name="video" accept="video/*"> </span>
<!--                            <span class="fileinput-filename"></span><span class="fileinput-new">No file chosen</span>-->
                        </div>
<!--                        <input type="file" name="arquivos[]" class="form-control" multiple="multiple" accept="image/png, image/jpeg, video/*">-->
                    </div>    
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a class="btn btn-danger" href="minhas_dicas.php">Cancelar</a>
                </form>                
            </div>
        </div>
    </section>


</div>

<?php
include './template/rodape_especial.php';

