<?php
$pagina = "Histórico";
require_once './template/cabecalho.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php
            if (estaLogado()) {
                echo 'Histórico de ' . exibirName();
                $aba = (!empty($_GET['aba']) ? $_GET['aba'] : 'atividadesExtras');
            }
            ?>
        </h1>
    </section>
    <br>
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li<?php if ($aba == 'atividadesExtras') echo ' class="active"'; ?>><a href="#atividadesExtras" data-toggle="tab">Atividades Extras</a></li>
                <li<?php if ($aba == 'pesosMedidas') echo ' class="active"'; ?>><a href="#pesosMedidas" data-toggle="tab">Pesos e Medidas</a></li>
                <li<?php if ($aba == 'treinosPlanilha') echo ' class="active"'; ?>><a href="#treinosPlanilha" data-toggle="tab">Treinos da Planilha</a></li>
                <li<?php if ($aba == 'avaliacoes') echo ' class="active"'; ?>><a href="#avaliacoes" data-toggle="tab">Avaliações</a></li>
            </ul>
            <div class="tab-content">               
                <div class="tab-pane<?php if ($aba == 'atividadesExtras') echo ' active'; ?>" id="atividadesExtras">

                    <!-- Post -->
                    Postar Histórico de atividades extras.
                    <!-- /.post -->

                </div>

                <div class="tab-pane<?php if ($aba == 'pesosMedidas') echo ' active'; ?>" id="pesosMedidas">
                    
                    <!-- Post -->
                    Postar históricos de peso e medidas.
                    <!-- /.post -->
                    
                </div>
                
                <div class="tab-pane<?php if ($aba == 'treinosPlanilha') echo ' active'; ?>" id="treinosPlanilha">
                   
                    <!-- Post -->
                    Postar o historico dos treinos das planilhas.
                    <!-- /.post -->
                    
                </div>

                <div class="tab-pane<?php if ($aba == 'avaliacoes') echo ' active'; ?>" id="avaliacoes">
                    <!-- Post -->
                    
                    Postar o histórico das avaliações.

                    <!-- /.post -->
                </div>

    </div>
</div>
</div> 
<!--</div>-->

<?php
require_once './template/rodape_especial.php';
