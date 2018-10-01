<?php
$pagina = "Alterar Informações adicionais";
require_once './template/cabecalho.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Formulário de Avaliação </h1>
    </section>
    <section class="content">
        <form method="post" action="">

            <div class="box box-primary">


                            <div class="col-lg-6">
                    <br><strong>SELECIONE O ALUNO PARA SER AVALIADO</strong><select class="form-control select2" name="alunoavaliado" style="width: 100%;" >                                  
                        <option value="">(Selecione)</option>


                    </select> </div>
                <div class="box-body">           
                    <div class="col-lg-6">
                        <br>Desempenho do aluno com as atividades <select class="form-control select2" name="grupodesempenho" style="width: 100%;">                                  
                            <option value="">(Selecione)</option>
                            <option value="bom">Bom</option>
                            <option value="excelente">Excelente</option>
                            <option value="medio">Médio</option>
                            <option value="mal">Mal</option>
                            <option value="pessimo">péssimo</option>

                        </select> </div>
                    <div class="col-lg-6">
                        <br>Frequência do aluno com as atividades <select class="form-control select2" name="grupofrequencia" style="width: 100%;">                                  
                            <option value="">(Selecione)</option>
                            <option value="boa">Boa</option>
                            <option value="excelente">Excelente</option>
                            <option value="media">Média</option>
                            <option value="ma">Má</option>
                            <option value="pessima">péssima</option>
                        </select> </div>

                    <div class="col-lg-6">
                        <br>Cumpriu com os objetivos estipulados? <select class="form-control select2" name="grupocumpriu" style="width: 100%;">                                  
                            <option value="">(Selecione)</option>
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                            <option value="asvezes">As Vezes</option>
                        </select> </div>

                    <div class="col-lg-6">
                        <br>O aluno tira dúvida com o professor? <select class="form-control select2" name="grupoduvida" style="width: 100%;">                                  
                            <option value="">(Selecione)</option>
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                            <option value="asvezes">As Vezes</option>
                        </select> </div>
                    <div class="col-lg-6">
                        <br>Apresentou algum tipo de dificuldade em uma determinada atividade?<select class="form-control select2" name="grupodificuldade" style="width: 100%;">                                  
                            <option value="">(Selecione)</option>
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>  

                        </select> </div>

                    <div class="col-lg-6">
                        <br> Caso sim, qual?<textarea name="caso_sim" class="form-control" rows="2" placeholder="Escreva aqui."></textarea> 

                    </div>
                    <hr>


                    <div class="col-lg-6">
                        <br> <strong>Considerações gerais</strong> <textarea name="consideracoes" class="form-control" rows="5" placeholder="NEscreva aqui"></textarea> 

                    </div>

                </div>                    
            </div>
            <button type="submit" class="btn btn-primary btn-flat">Enviar</button>
        </form>
    </section>
    <!--</div>-->

    <?php
    require_once './template/rodape_especial.php';
    