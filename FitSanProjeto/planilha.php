<?php
$pagina = "Planilha";
require_once './template/cabecalho.php';

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Planilha</h1>
    </section><br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Prescrição de treino</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped planilha">
                a
                <thead>
                    
                    <tr>
                        <th>Exercício</th>
                        <th>Série</th>
                        <th>Repetições</th>
                        <th> </th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Supino enclinado com barra <b class="label label-danger"> Peito</b></td>
                        <td>4x</td>
                        <td>10 a 12</td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Crucifixo reto <b class="label label-danger"> Peito</b></td>
                        <td>4x</td>
                        <td>10 a 12</td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Supino reto com barra <b class="label label-danger"> Peito</b></td>
                        <td>4x</td>
                        <td>10 a 12</td>
                        <td> </td>
                        <td> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once './template/rodape_especial.php';