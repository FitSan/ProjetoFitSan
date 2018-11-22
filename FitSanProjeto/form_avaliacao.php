<?php
$pagina = "Avaliação";
require_once './template/cabecalho.php';
require_once './template/menu.php';

//quando um tipo diferente tentar acessar pelo navegador ele será redirecionado para a pagina 1. 

if (!tipoLogado("profissional")) {
    header('Location: ' . URL_SITE . 'pagina1.php');
    exit;
}
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1>Formulário de Avaliação </h1>
    </section>
    <section class="content">
        
        <a href="<?=URL_SITE?>form_historico_avaliacao_profissional.php" class="btn btn-app"><span class="badge bg-aqua">Histórico</span><i class="fa fa-calendar"></i> Avaliações </a>               
        
         <a class="btn btn-app" type="button" data-toggle="modal" data-target="#modal-avaliacao" id="modal-lista-button"><i class="fa fa-users"></i> Enviar </a>
        
        <form method="post" action="<?= URL_SITE ?>enviar_avaliacao.php">
           
            <br>
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <?php if (!empty($_SESSION['semaluno'])) {
                        ?> <div class="alert alert-danger">
                            <strong>Selecione um aluno</strong>.
                        </div> <?php
                        unset($_SESSION['semaluno']);
                    }
                    ?>
                    <?php if (!empty($_SESSION['semnada'])) {
                        ?> <div class="alert alert-danger">
                            <strong>Selecione as respostas do seu questionário </strong>.
                        </div> <?php
                        unset($_SESSION['semnada']);
                    }
                    ?>
                    
                                                            <?php if (!empty($_SESSION['mandou_avaliacao'])) {
                        ?> <div class="alert alert-success">
                            <strong>Avalição enviada com sucesso. No histórico você pode excluir ou modificar suas avaliações.</strong>.
                        </div> <?php
                        unset($_SESSION['mandou_avaliacao']);
                    }
                    ?>

                                                                                <?php if (!empty($_SESSION['atualizacao_avaliacao'])) {
                        ?> <div class="alert alert-success">
                            <strong>Avaliação atualizada com sucesso.</strong>.
                        </div> <?php
                        unset($_SESSION['atualizacao_avaliacao']);
                    }
                    ?>
                    <ul class="nav nav-tabs">

                        <li class="active" ><a href="#performance" data-toggle="tab"> Performance </a></li>
                        <li><a href="#avaliacao_corporal" data-toggle="tab"> Avaliação corporal </a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="performance">

                            <div class="box-body">           
                                <div class="col-lg-6">
                                    <br>Desempenho do aluno com as atividades <select class="form-control select2" name="desempenho" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Bom">Bom</option>
                                        <option value="Excelente">Excelente</option>
                                        <option value="Médio">Médio</option>
                                        <option value="Mal">Mal</option>
                                        <option value="Péssimo">Péssimo</option>

                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>Frequência do aluno com as atividades <select class="form-control select2" name="frequencia" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Boa">Boa</option>
                                        <option value="Excelente">Excelente</option>
                                        <option value="Média">Média</option>
                                        <option value="Má">Má</option>
                                        <option value="Péssima">Péssima</option>
                                    </select> </div>

                                <div class="col-lg-6">
                                    <br>Cumpriu com os objetivos estipulados? <select class="form-control select2" name="grupo_cumpriu" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option>
                                        <option value="As vezes">As Vezes</option>
                                    </select> </div>

                                <div class="col-lg-6">
                                    <br>O aluno tira dúvida com o professor? <select class="form-control select2" name="grupo_duvida" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option>
                                        <option value="As vezes">As Vezes</option>

                                    </select> </div>

                            

                                <div class="col-lg-6">
                                    <br>Apresentou algum tipo de dificuldade em uma determinada atividade?<select class="form-control select2" name="grupo_dificuldade" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option>  

                                    </select> </div>

                                <div class="col-lg-6">
                                    <br> Caso sim, qual?<textarea name="caso_sim" class="form-control" rows="1" placeholder="Escreva aqui."></textarea> 

                                </div>

                                <hr>
                               

                                <div class="col-lg-6">
                                    <br> <strong>Considerações gerais</strong> <textarea name="consideracoes" class="form-control" rows="5" placeholder="Escreva aqui"></textarea> 

                                </div>

                            </div>   

                        </div>
                        
                        <div class="tab-pane" id="avaliacao_corporal">

                            <div class="box-body">           
                                <div class="col-lg-6">
                                    <br>O aluno desenvolveu musculatura ? <select class="form-control select2" name="musculatura" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim(Pouca)">Sim (Pouca)</option>
                                        <option value="Sim(Muita)">Sim (Muita)</option>
                                        <option value="Não">Não</option>             
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno sofreu alguma lesão? <select class="form-control select2" name="lesao" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option> 
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno já sentiu queimação? <select class="form-control select2" name="queimacao" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option> 
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno já sentiu caimbras? <select class="form-control select2" name="caimbras" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option> 
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno perdeu seu equilíbrio por causa de tontura? <select class="form-control select2" name="tontura" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option> 
                                    </select> </div>

                                <hr>
                                <br>
                                <br>

                                <div class="col-lg-6">
                                    <br> <strong>Considerações gerais </strong> <textarea name="consideracoes_corporal" class="form-control"  cols="5" rows="5"  placeholder="Escreva aqui"></textarea> 

                                </div>

                            </div>   

                        </div>



                    </div>
                </div>
            </div>




           
        
        

        

<div class="modal fade" id="modal-avaliacao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Escolha o aluno</h4>
            </div>
            <div class="modal-body">
               
                <p>Selecione um aluno</p>          
            <select class="form-control select2" name="aluno" style="width: 100%;" >                                  
                    <option value="">(Selecione)</option>
                    <?php
                    $usuarios = array();
                    $query = "select * from usuario join vinculo on usuario.id=vinculo.aluno_id  where profissional_id=$_SESSION[id] and vinculo.status='aprovado'";
                    $retorno = mysqli_query($conexao, $query);
                    while ($linha = mysqli_fetch_array($retorno)) {
                        array_push($usuarios, $linha);
                    }
                    foreach ($usuarios as $usuario) {
                        ?>
                        <option value=<?= $usuario['id'] ?>><?= $usuario['nome'] ?> / <?= $usuario['email'] ?></option>
                    <?php }
                    ?>

                </select>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
             
 <button type="submit" class="btn btn-primary" role="button">Enviar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


        
        
        </form>
    </section>
    <?php
    require_once './template/rodape_especial.php';
    
