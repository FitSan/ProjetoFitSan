<?php
$pagina = 'Minhas Dicas';
include './template/cabecalho.php';

if (!tipoLogado('profissional')){
    header('Location: pagina1.php');
}

$query = "select * from dica where profissional_id=$_SESSION[id] order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1 style="padding: 10px"><?=$pagina?></h1>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form role="form" method="post" enctype="multipart/form-data" action="enviar_dica.php">
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
                        <textarea class="form-control" rows="14" cols="80"  name="dica" ></textarea>
                    </div>
                    <div class="form-group">
<!--                        <input type="file" name="imagens[]" multiple="multiple" hidden accept="image/png, image/jpeg">
                        ou
                        <input type="file" name="video" >-->
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

        <?php
        while ($linha = mysqli_fetch_array($resultado)){
            ?>
            <div class="post">   
                <div class="user-block">
                    <button type="button" class="pull-right btn-box-tool" data-toggle="modal" data-target="#excluir-dica" data-id="<?= $linha['id'] ?>"><i class="fa fa-times" style="font-size:20px"></i></button>
                    <a href="form_alterarDica.php?id=<?= $linha['id'] ?>"><button type="button" class="pull-right btn-box-tool" ><i class="fa fa-edit" style="font-size:20px"></i></button></a>
                    <h4><?= date('d/m/Y H:i:s', dataParse($linha['data_envio'])) ?></h4>                
                </div>
                <p style="padding: 5px; "><?= nl2br(htmlentities($linha['texto'])) ?></p>            

                <div id="uploads"><ul><?php
                        $query_dica = "select * from upload_dica where dica_id = $linha[id]";
                        $resultado_upload = mysqli_query($conexao, $query_dica);
                        while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                            if($linha_upload['tipo']!='img'){
                    ?>                          
                    <li><video height="400" style="padding: 5px;" controls>
                            <source src="upload/dica/<?= $linha_upload['nome_arq'] ?>" type="video/mp4">
                        </video></li>
                       <?php 
                            }else{
                              ?>  
                    <li><img src="upload/dica/<?= $linha_upload['nome_arq'] ?>" height="400" style="padding: 5px;"></li>                  
                        
                       <?php   
                            }
                            
                        }?>
                        </ul>
                </div><?php
                }
                ?>
                    
            </div>
    </section>
</div>
	

<?php

include './template/rodape_especial.php';

