<?php
require_once './autenticacao.php';

$query = "select dica.*, usuario.nome, usuario.sobrenome, usuario.foto from dica join usuario on usuario.id = dica.profissional_id";
$query .= " order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
?>

<?php
while ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <!-- Box Comment -->
    <div class="box box-widget">
        <div class="box-header with-border">
            <div class="user-block">

                <img class="img-circle img-bordered-sm" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">
                <span class="username">
                    <?php
                    if (tipoLogado("aluno")) {
                        ?>
                    <a href="<?= URL_SITE ?>perfil_externo.php?id=<?= htmlspecialchars($linha['profissional_id']) ?>"><?= $linha['profissional_nome'] ?></a> 
                        <?php
                    } else if (htmlspecialchars($linha['profissional_id']) == $_SESSION['id']) {
                        ?>
                        <a href="<?= URL_SITE ?>perfil.php"><?= htmlspecialchars($linha['profissional_nome']) ?></a> 
                        <?php
                    } else {
                        ?>
                        <?= htmlspecialchars($linha['profissional_nome']) ?>
                        <?php
                    }
                    if (htmlspecialchars($linha['profissional_id']) == $_SESSION['id'] || tipoLogado('admin')) {
                        ?>


                        <button type="button" class="pull-right btn-box-tool" data-toggle="modal" data-target="#excluir-dica" data-id="<?= htmlspecialchars($linha['id']) ?>"><i class="fa fa-times"></i></button>
                        <?php
                    }
                    ?>
                    <!--Fim do icone x-->
                    <i style="font-size: 15px;"> <?= (empty(htmlspecialchars($linha['titulo']))) ? 'postou uma dica</i>' : 'postou a dica </i><b>' . htmlspecialchars($linha['titulo']) . '</b>' ?><i style="font-size: 15px;">.</i>
                </span>
                <span class="description"><?= date('d/m/Y H:i:s', dataParse(htmlspecialchars($linha['data_envio']))) ?></span>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" >
            <p> <?= nl2br(htmlentities($linha['texto'])) ?> </p> 
            <?php
            $query_dica = "select * from upload_dica where dica_id = ".htmlspecialchars($linha[id]);
            $resultado_upload = mysqli_query($conexao, $query_dica);            
            if (mysqli_num_rows($resultado_upload)>0){
                $count = 0;
                while ($linha_upload = mysqli_fetch_array($resultado_upload)) {                
                    if (htmlspecialchars($linha_upload['tipo']) != 'img') {
                        if (htmlspecialchars($linha_upload['tipo']) == 'vid') {
                            ?> 
                            <div class="embed-container"><iframe  src="<?= htmlspecialchars($linha_upload['nome_arq']) ?>" frameborder="0" allowfullscreen></iframe>                                  
                                <?php
                            } else {
                                ?>
                                <div><a href="<?= htmlspecialchars($linha_upload['nome_arq']) ?>"  target="_blank"><?= htmlspecialchars($linha_upload['nome_arq']) ?></a>
                                    <?php
                                }
                                $img = false;
                            } else {
                                $count += 1;
                                $img = true;
                                $id = htmlspecialchars($linha['id']);
                                if ($count == 1) {
                                    ?>
                                    <div class="wrap" id="<?= $id ?>">
                                        <section class="container galery-container">
                                        <?php }
                                        ?>  
                                        <div class="mySlides" <?=($count>1) ? ' style="display: none;"' : '' ?>><img class="imgslide img img-responsive " src="<?= URL_SITE ?>uploads/dicas/<?= htmlspecialchars($linha_upload['nome_arq']) ?>" style="padding: 5px; margin: 0 auto;"></div>                

                                        <?php
                                    }
                                } if ($img) {                                
                                    if ($count > 1) {
                                        ?>
                                        <a class="prev" onclick="plusSlides(-1, <?=$id ?>)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1, <?=$id ?>)">&#10095;</a>
                                    <?php } ?>
                                </section>
                            <?php } ?>                                                
                        </div>
                    <?php } ?>                 
                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->


            <!-- /.post -->
            <?php
        }
        ?>

        <!--desblooquear dicas-->
        <!--  /var/www/html/FitSan/upload$ chmod 777 -R dicas/  -->









