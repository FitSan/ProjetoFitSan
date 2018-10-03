<?php
$pagina = "Prescrição de treino";
require_once './template/cabecalho.php';

if (!tipoLogado("aluno")) {
    header('Location: pagina1.php');
    exit;
}
?>



<div class="content-wrapper">
    <section class="content-header">
        <h1>Prescrição de Treino</h1>
    </section><br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Prescrição de treino</h3>
            <br><br>
            <div class="box-body">
                <div class="table-responsive table-box">
                    <table class="table table-hover table-striped">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab"> Grupo A </a></li>
                            <li><a href="#breve" data-toggle="tab"> Grupo B </a></li>
                            <li><a href="#settings" data-toggle="tab"> <i class="fa fa-fw fa-plus"></i> </a></li>
                        </ul>
                        <thead>
                            <tr>
                                <th>Exercício</th>
                                <th>Séries</th>
                                <th>Repetições</th>                      
                                <th>Carga(Kg)</th>
                                <th>Intervalo</th>
                                <th>Tempo</th>
                                <th><i class="fa fa-eye"></i></th> 
                                <th><i class="fa fa-check-square-o"></i></th>
                            </tr>
                        </thead> 
                        <tbody>
                            <tr>
                                <td>Supino enclinado com barra <b class="label label-danger"> Peito</b></td>
                                <td>3x</td>
                                <td>12, 10, 9</td>
                                <td>30, 40, 60</td>
                                <td>15 seg</td>
                                <td>  - </td>
                                <td><i class="fa fa-eye"></i></td>
                                <td><input class="checkbox"  type="checkbox"></td>
                            </tr>
                        </tbody>
                    </table> 
                    <div class="box-footer">  
                        <button type="submit" class="btn btn-info">Enviar</button>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</div>


<?php
require_once './template/rodape_especial.php';
