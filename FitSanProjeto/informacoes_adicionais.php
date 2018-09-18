<?php 
$pagina = "Alterar Informações adicionais";
require_once './template/cabecalho.php';
?>

<div class="content-wrapper">
    <section class="content-header">
            <h1>Alterar Informações Adicionais</h1>
        </section>
    <section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Minhas Informações</h3>
        </div>
        <div class="box-body">
            <strong><i class="fa fa-fw fa-medkit margin-r-5"></i>Ficha médica</strong><br><br>
            <div class="col-lg-3">
                Problemas de Saúde:<textarea class="form-control" rows="2" placeholder="Nenhum..."></textarea> 
            </div>
            <div class="col-lg-3">
                Notas médicas: <textarea class="form-control" rows="2" placeholder="Nenhuma..."></textarea> 
            </div>
            <div class="col-lg-3">
                Alergias e reações: <textarea class="form-control" rows="2" placeholder="Nenhuma..."></textarea> 
            </div>
            <div class="col-lg-3">
                Medicamentos: <textarea class="form-control" rows="2" placeholder="Nenhum..."></textarea> 
            </div>
            <div class="col-lg-6">
                <br>Grupo Sanguineo<select class="form-control select2" name="sangue" style="width: 100%;">                                  
                    <option value="">(Selecione)</option>
                    <option value="a1">A+</option>
                    <option value="a2">A-</option>
                    <option value="b1">B+</option>
                    <option value="b2">B-</option>
                    <option value="ab1">AB+</option>
                    <option value="ab2">AB-</option>
                    <option value="o1">O+</option>
                    <option value="o2">O-</option>
                </select> </div>
            <div class="col-lg-6">
                <br><i class="fa fa-fw fa-heart-o"></i>Doador de orgão:<select class="form-control select2" name="convenio" style="width: 100%;">                                  
                    <option value="">(Selecione)</option>
                    <option value="sim">Sim</option>
                    <option value="nao">Não</option>
                </select><br></div>


            <hr>
            <strong><br><i class="fa fa-fw fa-phone"></i> Contato de emergência</strong><br><br>
            <div class="col-lg-3">
                <select class="form-control select2" name="sangue" style="width: 100%;">                                  
                    <option value="">(Selecione)</option>
                    <option value="mae">Mãe</option>
                    <option value="pai">Pai</option>
                    <option value="responsavel">Responsável</option>
                    <option value="irmao">Irmão</option>
                    <option value="irma">Irmã</option>
                    <option value="filho(a)">Filho(a)</option>                               
                    <option value="amigo(a)">Amigo(a)</option>
                    <option value="conjuge">Cônjuge</option>
                    <option value="outros">Outros</option>
                </select> 
            </div>
            <div class="col-lg-4">
                <input type="text" name="nome" class="form-control" placeholder="Nome...">
            </div>
            <div class="col-lg-4">
                <input type="text" name="numero" class="form-control" placeholder="Telefone...">
            </div> 
            <button type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-plus-square-o"></i></button>



            <hr>
            <strong><br><i class="fa fa-fw fa-male margin-r-5"></i>Medidas</strong><br><br>
            <div class="col-lg-3">
                Altura: <input type="text" name="altura" class="form-control" placeholder="">
            </div>
            <div class="col-lg-3">
                Peso: <input type="text" name="peso" class="form-control" placeholder="">
            </div>
            <div class="col-lg-3">
                Massa magra: <input type="text" name="massam" class="form-control" placeholder="">
            </div>
            <div class="col-lg-3">
                Gordura Corporal: <input type="text" name="gordura" class="form-control" placeholder="">
            </div><br><br>

            <hr>
            <br><strong><i class="fa fa-fw fa-diamond margin-r-5"></i>Academia</strong><br><br>
            <div class="col-lg-6">
                Academias já frequentádas:<textarea class="form-control" rows="2" placeholder="Nenhum..."></textarea> 
            </div>
            <div class="col-lg-6">
                Academia atual:<textarea class="form-control" rows="2" placeholder="Nenhum..."></textarea> 
            </div><br><br>


            <hr>
            <strong><br><i class="fa fa-fw fa-bicycle margin-r-5"></i>Esportes Praticados </strong><br><br>

            <div class="row">
                <div class="col-xs-4 col-sm-6">
                    <input type="checkbox" class="flat-red" name="exercicios[]" value="Futebol"> Futebol
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Karatê"> Karatê
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Basquete"> Basquete
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Balé"> Balé
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Jiu-jitsu"> Jiu-jitsu
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Corrida"> Corrida
                </div>

                <div class="col-xs-4 col-sm-6">
                    <input type="checkbox" class="flat-red" name="exercicios[]" value="Caminhada"> Caminhada
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Ping-Pong"> Ping-Pong
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Skate"> Skate
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Natação"> Natação
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Bicicleta"> Bicicleta
                    <br><br><input type="checkbox" class="flat-red" name="exercicios[]" value="Outros"> Outros
                </div>
            </div><br>
            <input type="text" name="outros1" class="form-control" placeholder="Qual?"><br><br>




            <a href="#" class="btn btn-primary btn-block"><b>Alterar</b></a>
        </div>                    
    </div> 
    </section>
</div>

<?php
require_once './template/rodape_especial.php';
