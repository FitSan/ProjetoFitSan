<?php
$pagina = 'Página inicial';
require_once './template/cabecalho.php';
require_once './template/menu.php';
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div id="carouselSite" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselSite" data-slide-to="0" class="active"></li>
            <li data-target="#carouselSite" data-slide-to="1" class=""></li>
            <li data-target="#carouselSite" data-slide-to="2" class=""></li>
        </ol> 
        <div class="carousel-inner">
            <div class="item active">
                <img src="<?= URL_SITE ?>img/fitsan2.jpg" style="width: 100%;" alt="Primeiro slide">
                <div class="carousel-caption">
                    Primeiro Slide
                </div>
            </div>
            <div class="item">
                <img src="<?= URL_SITE ?>img/fitsan1.jpg" style="width: 100%;" alt="Segundo slide">
                <div class="carousel-caption">
                    Segundo Slide
                </div>
            </div>
            <div class="item">
                <img src="<?= URL_SITE ?>img/fitsan3.jpg" style="width: 100%;" alt="Terceiro slide">
                <div class="carousel-caption">
                    Terceiro Slide
                </div>
            </div>               
        </div>
        <a class="left carousel-control" href="#carouselSite" data-slide="prev">
            <span class="fa fa-angle-left"></span>
        </a>
        <a class="right carousel-control" href="#carouselSite" data-slide="next">
            <span class="fa fa-angle-right"></span>
        </a>
    </div>
    <br>
    <section class="content">

        <?php if (tipoLogado("aluno")) { ?>

            <div class="row justify-content-sm-center my-4">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="card mb-5">
                        <img class="card-img-top img-responsive"  src="<?= URL_SITE ?>img/Planilha.png" style="width: 100%;"  alt="Planilha">
                        <div class="card-body">
                            <h4 class="card-title">Planilha de Treino</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Profissional faz, o aluno segue.</h6>
                            <a href="<?= URL_SITE ?>planilha_aluno.php" class="card-link">Verifique sua planilha. |</a>
                            <a href="<?= URL_SITE ?>form_perfil.php" class="card-link"> Complete seu perfil.</a>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="card mb-5">
                        <img class="card-img-top img-responsive"  src="<?= URL_SITE ?>img/avaliacao.png" style="width: 100%;" alt="Avaliacao">
                        <div class="card-body">
                            <h4 class="card-title">Avaliações</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Análise individual para cada aluno.</h6>
                            <a href="<?= URL_SITE ?>form_receber_avaliacao.php" class="card-link">Confira suas avaliações. |</a>
                            <a href="<?= URL_SITE ?>informacoes_adicionais.php" class="card-link"> Preencha as informações adicionais.</a> 
                        </div>
                    </div>  
                </div> 

                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="card mb-5">
                        <img class="card-img-top img-responsive"  src="<?= URL_SITE ?>img/historico.png" style="width: 100%;" alt="Historico">
                        <div class="card-body">
                            <h4 class="card-title">Histórico</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Suas atividades em um lugar só.</h6>
                            <a href="<?= URL_SITE ?>historico.php" class="card-link">Verifique seu histórico. |</a>
                            <a href="<?= URL_SITE ?>metas.php" class="card-link"> Realize suas metas.</a>  
                        </div>
                    </div> 
                </div>

            </div>

        <?php } ?>

        <?php if (!tipoLogado("aluno")) { ?>

            <div class="row justify-content-sm-center my-4">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="card mb-5">
                        <img class="card-img-top img-responsive"  src="<?= URL_SITE ?>img/Planilha.png" alt="Planilha" style="width: 100%">
                        <div class="card-body">
                            <h4 class="card-title">Planilha de Treino</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Profissional faz, o aluno segue.</h6>
                            <a href="<?= URL_SITE ?>planilha.php" class="card-link">Crie planilhas para seus alunos.</a>
                        </div>
                    </div> 
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="card mb-5">
                        <img class="card-img-top img-responsive"  src="<?= URL_SITE ?>img/avaliacao.png" alt="Avaliacao" style="width: 100%">
                        <div class="card-body">
                            <h4 class="card-title">Avaliações</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Análise individual para cada aluno.</h6>
                            <a href="<?= URL_SITE ?>form_avaliacao.php" class="card-link">Realize suas avaliações.</a>           
                        </div>
                    </div> 
                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="card mb-5">
                        <img class="card-img-top img-responsive"  src="<?= URL_SITE ?>img/dicas.png" alt="Dicas" style="width: 100%">
                        <div class="card-body">
                            <h4 class="card-title">Dicas</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Crie dicas para seus alunos.</h6>
                            <a href="<?= URL_SITE ?>minhas_dicas.php" class="card-link">Que tal criar novas dicas?</a>
                        </div>
                    </div> 
                </div>
            </div>

        <?php } ?>

    </section>

    <div class="box box-default">
        <div class="row">
            <div class="col-12 text-center my-5">
                <h1 class="display-3">
                    <?php
                    if (estaLogado()) {
                        echo 'Olá, ' . exibirName();
                    }
                    ?> </h1>
                <p>Estamos felizes por tê-lo aqui, aproveite nossa plataforma.</p>
            </div>

        </div>
    </div>    


    <!--Dicas-->
    <div style="margin: 0 auto; width: 80%;" id="content">      
    </div>  
    <div id='loading' style="margin: 0 auto; width: 50px;"></div>
    <?php
    include './template/rodape_especial.php';
    ?>