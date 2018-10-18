<?php
require_once './autenticacao.php';

$query = "select dica.*, usuario.nome, usuario.sobrenome, usuario.foto from dica join usuario on usuario.id = dica.profissional_id";
$query .= " order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
?>

        <div class="tab-content">
            <div class="active tab-pane" id="dicas">
                <!-- Post -->               
                <?php
                while ($linha = mysqli_fetch_array($resultado)) {
                    ?>
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">
                            <span class="username">
                                <?php
                                if(tipoLogado("aluno")){
                                    ?>
                                <a href="perfil_externo.php?id=<?= $linha['profissional_id'] ?>"><?= $linha['profissional_nome'] ?></a> 
                                <?php
                                }else if($linha['profissional_id']==$_SESSION['id']){
                                ?>
                                <a href="perfil.php"><?= $linha['profissional_nome'] ?></a> 
                                <?php
                                }else{
                                ?>
                                <?= $linha['profissional_nome'] ?>
                                <?php
                                }
                                if($linha['profissional_id']==$_SESSION['id']){
                                ?>
                               
                                
                                <button type="button" class="pull-right btn-box-tool" data-toggle="modal" data-target="#excluir-dica" data-id="<?= $linha['id'] ?>"><i class="fa fa-times"></i></button>
                                <?php
                                }
                                ?>
                                <!--Fim do icone x-->
                            </span>
                            <span class="description"><?= date('d/m/Y H:i:s', dataParse($linha['data_envio'])) ?></span>
                        </div>
                        <p> <?= nl2br(htmlentities($linha['texto'])) ?> </p> 
                        <div id="uploads"><ul><?php
                            $query_dica = "select * from upload_dica where dica_id = $linha[id]";
                            $resultado_upload = mysqli_query($conexao, $query_dica);
                            while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                                if($linha_upload['tipo']!='img'){
                        ?>                          
                        <li><video height="380" style="padding: 5px;" controls>
                                <source src="upload/dica/<?= $linha_upload['nome_arq'] ?>" type="video/mp4">
                            </video></li>
                           <?php 
                                }else{
                                  ?>  
                        <li><img src="upload/dica/<?= $linha_upload['nome_arq'] ?>" height="380" style="padding: 5px;"></li>                  

                           <?php   
                                }

                                }?>
                            </ul>
                        </div>
                        
                        <!--Caso necessario colocar comentário e as opções de compartilhar e gostar -->

                        <!--<ul class="list-inline">
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                        </li>
                                        <li class="pull-right">
                                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                                (5)</a></li>
                                    </ul>
                                    <input class="form-control input-sm" type="text" placeholder="Type a comment">-->

                        <!--final do comentario -->
                    </div>
                    <!-- /.post -->
                    <?php
                }
                ?>
            </div>           
        </div>



<!--desblooquear dicas-->
 <!--  /var/www/html/FitSan/upload$ chmod 777 -R dicas/  -->








