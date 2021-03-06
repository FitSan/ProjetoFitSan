<?php
$pagina = " Alterar Avaliação";
require_once './template/cabecalho.php';
require_once './template/menu.php';

$id_avaliacao = $_GET['id_avaliacao'];

if (!tipoLogado("profissional")) {
    header('Location: ' . URL_SITE . 'pagina1.php');
    exit;
}


$sql = "select * from avaliacao where id = $id_avaliacao";
$retorno_usuario = mysqli_query($conexao, $sql);
$update = (mysqli_fetch_array($retorno_usuario));

$sql_usuario = "Select usuario.id, usuario.nome, usuario.email from usuario inner join avaliacao on avaliacao.aluno_id = usuario.id  where avaliacao.id = $id_avaliacao";
$retorno_usuario = mysqli_query($conexao, $sql_usuario);
$update_usuario = (mysqli_fetch_array($retorno_usuario));

$_SESSION['usuario_passado'] = $update_usuario[id];
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1>Formulário de Avaliação </h1>
    </section>
    <section class="content">

   
        <a href="<?=URL_SITE?>form_historico_avaliacao_profissional.php" class="btn btn-app"><span class="badge bg-aqua">Histórico</span><i class="fa fa-calendar"></i> Avaliações </a>               
        
         <a class="btn btn-app" type="button" data-toggle="modal" data-target="#modal-avaliacao" id="modal-lista-button"><i class="fa fa-upload"></i> Atualizar </a>
        

        <form method="post" action="<?= URL_SITE ?>atualizar_avaliacao.php">
            <?php $_SESSION['update'] = $id_avaliacao; ?>

        

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
                            <strong>Avaliação enviada com sucesso. No histórico você pode excluir ou modificar suas avaliações.</strong>.
                        </div> <?php
                        unset($_SESSION['mandou_avaliacao']);
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


                                        <?php
                                        if ($update['desempenho'] == Excelente) {
                                            ?>

                                            <option value="<?= $update['desempenho'] ?>"><?= $update['desempenho'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Bom">Bom</option>
                                            <option value="Médio">Médio</option>
                                            <option value="Mal">Mal</option>
                                            <option value="Péssimo">péssimo</option>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($update['desempenho'] == Bom) {
                                            ?>

                                            <option value="<?= $update['desempenho'] ?>"><?= $update['desempenho'] ?></option>    
                                            <option value="">(Nulo)</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Médio">Médio</option>
                                            <option value="Mal">Mal</option>
                                            <option value="Péssimo">Péssimo</option>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($update['desempenho'] == Médio) {
                                            ?>

                                            <option value="<?= $update['desempenho'] ?>"><?= $update['desempenho'] ?></option>   
                                            <option value="">(Nulo)</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Bom">Bom</option>
                                            <option value="Mal">Mal</option>
                                            <option value="Péssimo">Péssimo</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['desempenho'] == Mal) {
                                            ?>

                                            <option value="<?= $update['desempenho'] ?>"><?= $update['desempenho'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Bom">Bom</option>
                                            <option value="Médio">Médio</option>
                                            <option value="Péssimo">Péssimo</option>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($update['desempenho'] == Péssimo) {
                                            ?>

                                            <option value="<?= $update['desempenho'] ?>"><?= $update['desempenho'] ?></option> 
                                            <option value="">(Nulo)</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Bom">Bom</option>
                                            <option value="Médio">Médio</option>
                                            <option value="Mal">Mal</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['desempenho'] == null) {
                                            ?>

                                            <option value="">(Nulo)</option> 
                                            <option value="Péssimo">Péssimo</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Bom">Bom</option>
                                            <option value="Médio">Médio</option>
                                            <option value="Mal">Mal</option>
                                            <?php
                                        }
                                        ?>

                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>Frequência do aluno com as atividades <select class="form-control select2" name="frequencia" style="width: 100%;">                                  

                                        <?php
                                        if ($update['frequencia'] == Boa) {
                                            ?>
                                            <option value="<?= $update['frequencia'] ?>"><?= $update['frequencia'] ?></option> 
                                            <option value="">(Nulo)</option>                  
                                            <option value="Excelente">Excelente</option>
                                            <option value="Média">Média</option>
                                            <option value="Má">Má</option>
                                            <option value="Péssima">Péssima</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['frequencia'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Boa">Boa</option>                  
                                            <option value="Excelente">Excelente</option>
                                            <option value="Média">Média</option>
                                            <option value="Má">Má</option>
                                            <option value="Péssima">Péssima</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['frequencia'] == Excelente) {
                                            ?>
                                            <option value="<?= $update['frequencia'] ?>"><?= $update['frequencia'] ?></option> 
                                            <option value="">(Nulo)</option>                  
                                            <option value="Boa">Boa</option>
                                            <option value="Média">Média</option>
                                            <option value="Má">Má</option>
                                            <option value="Péssima">Péssima</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['frequencia'] == Média) {
                                            ?>
                                            <option value="<?= $update['frequencia'] ?>"><?= $update['frequencia'] ?></option> 
                                            <option value="">(Nulo)</option>                  
                                            <option value="Boa">Boa</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Má">Má</option>
                                            <option value="Péssima">Péssima</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['frequencia'] == Má) {
                                            ?>
                                            <option value="<?= $update['frequencia'] ?>"><?= $update['frequencia'] ?></option> 
                                            <option value="">(Nulo)</option>                  
                                            <option value="Boa">Boa</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Média">Média</option>
                                            <option value="Péssima">Péssima</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['frequencia'] == Péssima) {
                                            ?>
                                            <option value="<?= $update['frequencia'] ?>"><?= $update['frequencia'] ?></option> 
                                            <option value="">(Nulo)</option>                  
                                            <option value="Boa">Boa</option>
                                            <option value="Excelente">Excelente</option>
                                            <option value="Média">Média</option>
                                            <option value="Má">Má</option>
                                            <?php
                                        }
                                        ?>
                                    </select> </div>

                                <div class="col-lg-6">
                                    <br>Cumpriu com os objetivos estipulados? <select class="form-control select2" name="grupo_cumpriu" style="width: 100%;">                                  

                                        <?php
                                        if ($update['grupo_cumpriu'] == Sim) {
                                            ?>

                                            <option value="<?= $update['grupo_cumpriu'] ?>"><?= $update['grupo_cumpriu'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>
                                            <option value="As vezes">As Vezes</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['grupo_cumpriu'] == null) {
                                            ?>

                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>
                                            <option value="As vezes">As Vezes</option>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($update['grupo_cumpriu'] == Não) {
                                            ?>

                                            <option value="<?= $update['grupo_cumpriu'] ?>"><?= $update['grupo_cumpriu'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="As vezes">As Vezes</option>
                                            <?php
                                        }
                                        ?>


                                        <?php
                                        if ($update['grupo_cumpriu'] == 'As vezes') {
                                            ?>

                                            <option value="<?= $update['grupo_cumpriu'] ?>"><?= $update['grupo_cumpriu'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não"> Não</option>
                                            <?php
                                        }
                                        ?>


                                    </select> </div>

                                <div class="col-lg-6">
                                    <br>O aluno tira dúvida com o professor? <select class="form-control select2" name="grupo_duvida" style="width: 100%;">                                  
                                        <?php
                                        if ($update['grupo_duvida'] == Sim) {
                                            ?>

                                            <option value="<?= $update['grupo_duvida'] ?>"><?= $update['grupo_duvida'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>
                                            <option value="As vezes">As Vezes</option>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['grupo_duvida'] == null) {
                                            ?>

                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>
                                            <option value="As vezes">As Vezes</option>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($update['grupo_duvida'] == Não) {
                                            ?>

                                            <option value="<?= $update['grupo_duvida'] ?>"><?= $update['grupo_duvida'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="As vezes">As Vezes</option>
                                            <?php
                                        }
                                        ?>


                                        <?php
                                        if ($update['grupo_duvida'] == 'As vezes') {
                                            ?>

                                            <option value="<?= $update['grupo_duvida'] ?>"><?= $update['grupo_duvida'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não"> Não</option>
                                            <?php
                                        }
                                        ?>
                                    </select> </div>



                                <div class="col-lg-6">
                                    <br>Apresentou algum tipo de dificuldade em uma determinada atividade?<select class="form-control select2" name="grupo_dificuldade" style="width: 100%;">                                  

                                        <?php
                                        if ($update['grupo_dificuldade'] == Sim) {
                                            ?>
                                            <option value="<?= $update['grupo_dificuldade'] ?>"><?= $update['grupo_dificuldade'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['grupo_dificuldade'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($update['grupo_dificuldade'] == Não) {
                                            ?>
                                            <option value="<?= $update['grupo_dificuldade'] ?>"><?= $update['grupo_dificuldade'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>  

                                            <?php
                                        }
                                        ?>
                                    </select> </div>

                                <div class="col-lg-6">
                                    <br> Caso sim, qual?<textarea name="caso_sim" class="form-control" rows="1" placeholder="Escreva aqui."><?= $update['caso_sim'] ?></textarea> 

                                </div>

                                <hr>


                                <div class="col-lg-6">
                                    <br> <strong>Considerações gerais</strong> <textarea name="consideracoes" class="form-control" rows="5" placeholder="Escreva aqui"><?=$update['consideracoes']?></textarea> 

                                </div>

                            </div>   

                        </div>
                        <div class="tab-pane" id="avaliacao_corporal">

                            <div class="box-body">           
                                <div class="col-lg-6">
                                    <br>O aluno desenvolveu musculatura ? <select class="form-control select2" name="musculatura" style="width: 100%;">                                  
                                        <?php
                                        if ($update['musculatura'] == Não) {
                                            ?>
                                            <option value="<?= $update['musculatura'] ?>"><?= $update['musculatura'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim Pouca">Sim (Pouca)</option>
                                            <option value="Sim Muita">Sim (Muita)</option>


                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['musculatura'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>
                                            <option value="Sim Pouca">Sim (Pouca)</option>
                                            <option value="Sim Muita">Sim (Muita)</option>


                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['musculatura'] == 'Sim(Pouca)' ) {
                                            ?>
                                            <option value="<?= $update['musculatura'] ?>"><?= $update['musculatura'] ?></option>
                                            <option value="">(Nulo)</option>                                           
                                            <option value="Sim Muita">Sim (Muita)</option>
                                            <option value="Não">Não</option>


                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['musculatura'] == 'Sim(Muita)' ) {
                                            ?>
                                            <option value="<?= $update['musculatura'] ?>"><?= $update['musculatura'] ?></option>
                                            <option value="">(Nulo)</option>                                           
                                            <option value="Sim Pouca">Sim (Pouca)</option>
                                            <option value="Não">Não</option>


                                            <?php
                                        }
                                        ?>
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno sofreu alguma lesão? <select class="form-control select2" name="lesao" style="width: 100%;">                                  
                                        <?php
                                        if ($update['lesao'] == Sim) {
                                            ?>
                                            <option value="<?= $update['lesao'] ?>"><?= $update['lesao'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['lesao'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['lesao'] == Não) {
                                            ?>
                                            <option value="<?= $update['lesao'] ?>"><?= $update['lesao'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>  

                                            <?php
                                        }
                                        ?>
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno já sentiu queimação? <select class="form-control select2" name="queimacao" style="width: 100%;">                                  
                                        <?php
                                        if ($update['queimacao'] == Sim) {
                                            ?>
                                            <option value="<?= $update['queimacao'] ?>"><?= $update['queimacao'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['queimacao'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['queimacao'] == Não) {
                                            ?>
                                            <option value="<?= $update['queimacao'] ?>"><?= $update['queimacao'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>  

                                            <?php
                                        }
                                        ?>
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno já sentiu caimbras? <select class="form-control select2" name="caimbras" style="width: 100%;">                                  
                                        <?php
                                        if ($update['caimbras'] == Sim) {
                                            ?>
                                            <option value="<?= $update['caimbras'] ?>"><?= $update['caimbras'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['caimbras'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option> 


                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['caimbras'] == Não) {
                                            ?>
                                            <option value="<?= $update['caimbras'] ?>"><?= $update['caimbras'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>  

                                            <?php
                                        }
                                        ?>
                                    </select> </div>
                                <div class="col-lg-6">
                                    <br>O aluno perdeu seu equilíbrio por causa de tontura? <select class="form-control select2" name="tontura" style="width: 100%;">                                  
                                        <?php
                                        if ($update['tontura'] == Sim) {
                                            ?>
                                            <option value="<?= $update['tontura'] ?>"><?= $update['tontura'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['tontura'] == null) {
                                            ?>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>  

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($update['tontura'] == Não) {
                                            ?>
                                            <option value="<?= $update['tontura'] ?>"><?= $update['tontura'] ?></option>
                                            <option value="">(Nulo)</option>
                                            <option value="Sim">Sim</option>  

                                            <?php
                                        }
                                        ?>
                                    </select> </div>

                                <hr>


                                <div class="col-lg-6">
                                    <br> <strong>Considerações gerais </strong> <textarea name="consideracoes_corporal" class="form-control" rows="5" placeholder="Escreva aqui."><?=$update['consideracoes_corporal'] ?></textarea> 

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
                    <option value=<?= $update_usuario['id'] ?>><?= $update_usuario['nome'] ?> / <?= $update_usuario['email'] ?></option>
                    <?php
                    $usuarios = array();
                    $query = "select * from usuario join vinculo on usuario.id=vinculo.aluno_id  where profissional_id=$_SESSION[id] and vinculo.status='aprovado'";
                    $retorno = mysqli_query($conexao, $query);
                    while ($linha = mysqli_fetch_array($retorno)) {
                        array_push($usuarios, $linha);
                    }
                    foreach ($usuarios as $usuario) {
                        if ($update_usuario['id'] <> $usuario['id']) {
                            ?>
                            <option value=<?= $usuario['id'] ?>><?= $usuario['nome'] ?> / <?= $usuario['email'] ?></option>
                            <?php
                        }
                    }
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
    