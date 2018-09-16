<?php
require_once './autenticacao.php';

$query = "select dica.*, usuario.nome, usuario.sobrenome, usuario.foto from dica left join usuario on usuario.id = dica.profissional_id order by data_envio desc";
$resultado = mysqli_query($conexao, $query);
?>


<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab"> Dicas </a></li>
            <li><a href="#breve" data-toggle="tab"> Breve </a></li>
            <li><a href="#settings" data-toggle="tab"> Breve </a></li> 
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="activity">
                <!-- Post -->
                <?php
                while ($linha = mysqli_fetch_array($resultado)) {
                    ?>
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture">
                            <span class="username">
                                <a href="perfil_externo.php?id=<?= $linha['profissional_id'] ?>"><?= $linha['profissional_nome'] ?></a> 
                                <!--icone de x caso for usar para o profissional excluir a dica pela tela inicial-->

                    <!--<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>-->

                                <!--Fim do icone x-->
                            </span>
                            <span class="description"><?= $linha['data_envio'] ?></span>
                        </div>
                        <p> <?= $linha['texto'] ?> </p> 
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
    </div>
</div>












