<?php
$pagina = "Histórico";
require_once './template/cabecalho.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php
if (estaLogado()) {
    echo 'Histórico de ' . exibirName();
}
?></h1>
    </section>
    <br>
    
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#exercicios" data-toggle="tab"> Exercicios </a></li>
                <li><a href="#avaliacoes" data-toggle="tab"> Avaliações </a></li>
                <li><a href="#pesosMedidas" data-toggle="tab"> Pesos e Medidas </a></li>
                <li><a href="#ativExtra" data-toggle="tab"> Atividades Extras </a></li>
            </ul>
            <div class="tab-content">
                            <div class="active tab-pane" id="exercicios">
                               <!-- Post -->
                               Postar o histórico de exercicios realizados com Data que foi enviado cada exercicio e os exercicios que foram feitos
                               <!-- /.post -->
                            </div>
                            <div class="tab-pane" id="avaliacoes">
                                <!-- Post -->
                                Postar o histórico de avaliações realizadas
                                <!-- /.post -->
                            </div>
                            <div class="tab-pane" id="pesosMedidas">
                                <!-- Post -->
                               Postar o historico de dados retirado de Metas
                                <!-- /.post -->
                            </div>
                            <div class="tab-pane" id="ativExtra">
                                <!-- Post -->
                                Postar o histórico de atividades extras
                                <!-- /.post -->
                            </div>
                            
                            
                        </div>
        </div>
    </div>

</div>


<?php
require_once './template/rodape_especial.php';
