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
            <br><br>
            <table>
                <td class="col-lg-2">
                    <select class="form-control select2 " name="musculos">
                        <option value="">Músculos</option>
                        <option value="abdominais">Abdominais</option>
                        <option value="antebracos">Antebraços</option>
                        <option value="anterior">Anterior da coxa</option>  
                        <option value="biceps">Bíceps</option>
                        <option value="costas">Costas</option>
                        <option value="coxas">Coxas</option> 
                        <option value="gemeos">Gémeos</option> 
                        <option value="hamstrings">Hamstrings(posterior da coxa)</option>
                        <option value="obliquos">Oblíquos</option>  
                        <option value="ombro">Ombro</option> 
                        <option value="panturrilhas">Panturrilhas</option>
                        <option value="peito">Peito</option>
                        <option value="pescoco">Pescoço</option>
                        <option value="posterior">Posterior da coxa</option>  
                        <option value="quadriceps">Quadríceps</option>
                        <option value="reto">Reto abdominal</option>
                        <option value="transverso">Transverso do abdome</option>  
                        <option value="trapezio">Trapézios</option>
                        <option value="triceps">Tríceps</option>  

                    </select>
                </td>
                <td class="col-lg-4">
                    <select class="form-control select2" name="exercicios">
                        <option value="">Exercícios</option>
                        <option value="agachamento">Agachamento frontal com barra</option>
                        <option value="supino">Supino com barra</option>
                        <option value="perna">Abdominal Elevação de perna</option>
                        <option value="frontal">Abdominal Frontal</option>
                        <option value="bike">Abdominal Bike</option>
                        <option value="inversao">Abdominal com Inversão</option>




                    </select>
                </td>
                <td class="col-lg-2">
                    <select class="form-control select2" name="series">
                        <option value="">Séries</option>
                    </select>
                </td>
                <td class="col-lg-2">
                    <select class="form-control select2" name="repeticoes">
                        <option value="">Repetições</option>
                    </select>
                </td>
                <td class="col-lg-2">
                    <select class="form-control select2" name="repeticoes">
                        <option value="">Descanso</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-flat duplicador-mais"><i class="fa fa-fw fa-plus"></i></button>
                </td>
            </table><br> 
        </div> 
        <!--        final do box header-->
        <div class="box-body">
            <table class="table table-bordered table-striped planilha">

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab"> Grupo A </a></li>
                    <li><a href="#breve" data-toggle="tab"> Grupo B </a></li>
                    <li><a href="#settings" data-toggle="tab"> <i class="fa fa-fw fa-plus"></i> </a></li> 
                </ul>
                <thead>

                    <tr>
                        <th>Exercício</th>
                        <th>CONJUNTOS</th>
                        <th>REP/TEMPO</th>
                        <th>DESCANSO(S)</th>
                        <th> </th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Supino enclinado com barra <b class="label label-danger"> Peito</b></td>
                        <td>4x</td>
                        <td>10 a 12</td>
                        <td>60 </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Crucifixo reto <b class="label label-danger"> Peito</b></td>
                        <td>4x</td>
                        <td>10 a 12</td>
                        <td>60 </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Supino reto com barra <b class="label label-danger"> Peito</b></td>
                        <td>4x</td>
                        <td>10 a 12</td>
                        <td>60 </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                </tbody>              
            </table><br>

        </div>
        <div class="box-footer">
            <div class="form-group">
                <div class="col-sm-3">
                    <br><span><label>Enviar para:</label></span>
                    <div class="input-group">                        
                        <span class="input-group-addon">@</span>
                        <input type="text" class="form-control" placeholder="nome...">
                        <span class="input-group-addon"><a href="#" data-toggle="tab"><i class="fa fa-search"></i></a></span>
                    </div>                 
                </div><br><br><br>
                <div class="col-sm-1 pull-right">
                    <a href="novos_exercicios.php" class="btn btn-default">Novos exercícios</a><br><br>


                </div>
                <div class="col-sm-1 pull-right">
                    <button type="submit" class="btn btn-default ">Lista</button>
                </div>
            </div>


        </div>
    </div>
</div>

<?php
require_once './template/rodape_especial.php';
