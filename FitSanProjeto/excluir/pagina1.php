<?php
$pagina = 'Página inicial';
include './template/cabecalho.php';
?>



<div id="carouselSite" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
        <li data-target="#carouselSite" data-slide-to="0" class="active"></li>
        <li data-target="#carouselSite" data-slide-to="1"></li>
        <li data-target="#carouselSite" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/fitsan2.jpg" class="img-fluid d-block">
        </div>
        <div class="carousel-item">
            <img src="img/fitsan1.jpg" class="img-fluid d-block">
        </div>
        <div class="carousel-item">
            <img src="img/fitsan3.jpg" class="img-fluid d-block">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselSite" role="button" data-slide="prev" >
        <span class="carousel-control-prev-icon"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carouselSite" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="sr-only">Avançar</span>
    </a>
</div>

<div class="container-fluid">

    <div class="row mb-5 my-3"> <!--my-5 usado pra dar espaco entre uma linha e outra-->

        <div class="col-sm-4">

            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Planilha de Treino</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Profissional faz, o aluno segue.</h6><!--mb-2 margem text-muted texto cinza claro-->
                    <p class="card-text">Estou fazendo o teste de alguma coisa.</p>
                    <a href="#" class="card-link">Encontre novos vínculos</a>
                    <a href="#" class="card-link">Complete seu perfil</a>

                </div>

            </div>

        </div>


        <div class="col-sm-4">

            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Avaliações</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Análise individual para cada aluno.</h6>
                    <p class="card-text">Estou fazendo o teste de alguma coisa.</p>
                    <a href="#" class="card-link">Escolha o profissionais</a>
                    <a href="#" class="card-link">Converse com seu profissional</a>

                </div>

            </div>

        </div>

        <div class="col-sm-4">

            <div class="card">

                <div class="card-body">
                    <h4 class="card-title">Histórico</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Registre suas atividades.</h6>
                    <p class="card-text">Estou fazendo o teste de alguma coisa.</p>
                    <a href="#" class="card-link">Complete seu perfil</a>

                </div>

            </div>

        </div>

    </div>
</div>



<div class="container">
    <div class="row">
        <div class="col-12 text-center my-5">
            <h1 class="display-3"><?php
if (estaLogado()) {
    echo 'Olá ' . ' ' . exibirName() . ", ";
}
?> </h1>
            <p>Estamos felizes de ter você aqui, aproveite nossa plataforma.</p>

        </div>
    </div>
</div>


<div class="container">
    <!-- Barra de busca -->
    <!--<form class="form-inline">
                    <input class="form-control ml-2 mr-2 ml-auto" type="search" placeholder="Buscar...">
                    <button class="btn btn-dark" type="Submit">OK</button>
                    
                </form>-->



<?php
include 'dicas.php';
?>
</div>
<?php
include './template/rodape_especial.php';
?>




