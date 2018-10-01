<?php
$pagina = 'Página inicial';

require_once './template/cabecalho.php';

$query = "select * from dica";
$resultado = mysqli_query($conexao, $query);
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
                <img src="img/fitsan2.jpg" style="width: 100%;" alt="Primeiro slide">
                <div class="carousel-caption">
                    Primeiro Slide
                </div>
            </div>
            <div class="item">
                <img src="img/fitsan1.jpg" style="width: 100%;" alt="Segundo slide">
                <div class="carousel-caption">
                    Segundo Slide
                </div>
            </div>
            <div class="item">
                <img src="img/fitsan3.jpg" style="width: 100%;" alt="Terceiro slide">
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
        <div class="row justify-content-sm-center my-4">
            <div class="col-sm-6 col-md-4 ">
                <div class="card mb-5">
                    <img class="card-img-top img-responsive"  src="img/Planilha.png" alt="Planilha">
                    <div class="card-body">
                        <h4 class="card-title">Planilha de Treino</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Profissional faz, o aluno segue.</h6>
                        <p class="card-text">Estou fazendo o teste de alguma coisa.</p>
                        <a href="#" class="card-link">Encontre novos vínculos.</a>
                        <a href="#" class="card-link">Complete seu perfil</a>                  
                    </div>
                    <div class="card-footer text-muted">Nao sei ainda</div>
                </div> 
            </div>

            <div class="col-sm-6 col-md-4 ">
                <div class="card mb-5">
                    <img class="card-img-top img-responsive"  src="img/avaliacao.png" alt="Avaliacao">
                    <div class="card-body">
                        <h4 class="card-title">Avaliações</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Análise individual para cada aluno.</h6>
                        <p class="card-text">Estou fazendo o teste de alguma coisa.</p>
                        <a href="#" class="card-link">Encontre novos vínculos.</a>
                        <a href="#" class="card-link">Complete seu perfil</a>                  
                    </div>
                    <div class="card-footer text-muted">Nao sei ainda</div>
                </div> 
            </div>

            <div class="col-sm-6 col-md-4 ">
                <div class="card mb-5">
                    <img class="card-img-top img-responsive"  src="img/historico.png" alt="Historico">
                    <div class="card-body">
                        <h4 class="card-title">Histórico</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Registre suas atividades.</h6>
                        <p class="card-text">Estou fazendo o teste de alguma coisa.</p>
                        <a href="#" class="card-link">Encontre novos vínculos.</a>
                        <a href="#" class="card-link">Complete seu perfil</a>                  
                    </div>
                    <div class="card-footer text-muted">Nao sei ainda</div>
                </div> 
            </div>
        </div>
    </section>
    
     <div class="nav-tabs-custom">
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
     
        
        

    <div class="nav-tabs-custom">
        <div class="row">
            <?php include 'dicas.php'; ?>               
        </div>
    </div>
         
         </div>









    <?php
    include './template/rodape_especial.php';
    ?>