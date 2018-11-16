<?php
$pagina = "Alterar Informações adicionais";
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

        <a href="<?= URL_SITE ?>form_historico_avaliacao_profissional.php">
            <button type="button" class="btn btn-primary btn-flat">Histórico de avalições enviadas</button>
        </a>

        <form method="post" action="<?= URL_SITE ?>enviar_avaliacao.php">
            <div class="col-lg-6">
                <br><strong>SELECIONE O ALUNO PARA SER AVALIADO</strong><select class="form-control select2" name="aluno" style="width: 100%;" >                                  
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

                </select> </div> 
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
                                        <option value="bom">Bom</option>
                                        <option value="excelente">Excelente</option>
                                        <option value="médio">Médio</option>
                                        <option value="mal">Mal</option>
                                        <option value="péssimo">péssimo</option>

                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>Frequência do aluno com as atividades <select class="form-control select2" name="frequencia" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="boa">Boa</option>
                                        <option value="excelente">Excelente</option>
                                        <option value="média">Média</option>
                                        <option value="má">Má</option>
                                        <option value="péssima">péssima</option>
                                    </select> </div>

                                <div class="col-lg-6">
                                    <br>Cumpriu com os objetivos estipulados? <select class="form-control select2" name="grupo_cumpriu" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="não">Não</option>
                                        <option value="as vezes">As Vezes</option>
                                    </select> </div>

                                <div class="col-lg-6">
                                    <br>O aluno tira dúvida com o professor? <select class="form-control select2" name="grupo_duvida" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="não">Não</option>
                                        <option value="as vezes">As Vezes</option>

                                    </select> </div>

                                <ul class="nav nav-tabs"></ul>

                                <div class="col-lg-6">
                                    <br>Apresentou algum tipo de dificuldade em uma determinada atividade?<select class="form-control select2" name="grupo_dificuldade" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="não">Não</option>  

                                    </select> </div>

                                <div class="col-lg-6">
                                    <br> Caso sim, qual?<textarea name="caso_sim" class="form-control" rows="1" placeholder="Escreva aqui."></textarea> 

                                </div>

                                <hr>
                                <ul class="nav nav-tabs"></ul>

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
                                        <option value="sim Pouca">Sim (Pouca)</option>
                                        <option value="sim Muita">Sim (Muita)</option>
                                        <option value="não">Não</option>             
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno sofreu alguma lesão? <select class="form-control select2" name="lesao" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option> 
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno já sentiu queimação? <select class="form-control select2" name="queimacao" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option> 
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno já sentiu caimbras? <select class="form-control select2" name="caimbras" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option> 
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno perdeu seu equilíbrio por causa de tontura? <select class="form-control select2" name="tontura" style="width: 100%;">                                  
                                        <option value="">(Selecione)</option>
                                        <option value="sim">Sim</option>
                                        <option value="nao">Não</option> 
                                    </select> </div>

                                <hr>


                                <div class="col-lg-6">
                                    <br> <strong>Considerações gerais </strong> <textarea name="consideracoes_corporal" class="form-control" rows="5" placeholder="Escreva aqui"></textarea> 

                                </div>

                            </div>   

                        </div>



                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary btn-flat">Enviar</button>

        </form>
    </section>


    <?php
    require_once './template/rodape_especial.php';
    