<?php
$pagina = " Avaliações ";
require_once './template/cabecalho.php';
ini_set('display_errors', true);

//quando um tipo diferente tentar acessar pelo navegador ele será redirecionado para a pagina 1. 

if (!tipoLogado("aluno")){
    header('Location: pagina1.php');
    exit;
}

$query = "select * from `avaliacao` where aluno_id=" . $_SESSION['id'];
$resultado = mysqli_query($conexao, $query);
 $linha = (mysqli_fetch_array($resultado));


//
//echo $linha[data]  ;
//exit;


?>


<div class="content-wrapper">
    <section class="content-header">
        <h1> Avaliação </h1>
    </section>
    <section class="content">
        <form method="post" action="enviar_avaliacao.php">

            <div class="box box-primary">


                <div class="col-lg-6">
                    <br><strong>SELECIONE O ALUNO PARA SER AVALIADO</strong><select class="form-control select2" name="aluno" style="width: 100%;" >                                  
                        <option value="">(Selecione)</option>
                        <?php
                        $usuarios = array();
                        $query = "select * from usuario join vinculo on usuario.id=vinculo.aluno_id where profissional_id=$_SESSION[id]";
                        $retorno = mysqli_query($conexao, $query);
                        while ($linhas = mysqli_fetch_array($retorno)) {
                            array_push($usuarios, $linhas);
                        }
                            foreach ($usuarios as $usuario) {
                                ?>
                                <option value=<?= $usuario['id'] ?>><?= $usuario['nome']?> / <?= $usuario['email'] ?></option>
                            <?php }
                            ?>

                        </select> </div>
                    <div class="box-body">           
                        <div class="col-lg-6">
                            <br>Desempenho do aluno com as atividades <select class="form-control select2"  name="desempenho" style="width: 100%;">                                  
                                <option><?= $linha[desempenho]?></option>
                            

                            </select> </div>
                        <div class="col-lg-6">
                            <br>Frequência do aluno com as atividades <select class="form-control select2" name="frequencia" style="width: 100%;">                                  
                                <option value="">(Selecione)</option>
                                <option value="boa">Boa</option>
                                <option value="excelente">Excelente</option>
                                <option value="media">Média</option>
                                <option value="ma">Má</option>
                                <option value="pessima">péssima</option>
                            </select> </div>

                        <div class="col-lg-6">
                            <br>Cumpriu com os objetivos estipulados? <select class="form-control select2" name="grupo_cumpriu" style="width: 100%;">                                  
                                <option value="">(Selecione)</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                                <option value="asvezes">As Vezes</option>
                            </select> </div>

                        <div class="col-lg-6">
                            <br>O aluno tira dúvida com o professor? <select class="form-control select2" name="grupo_duvida" style="width: 100%;">                                  
                                <option value="">(Selecione)</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                                <option value="asvezes">As Vezes</option>
                            </select> </div>
                        <div class="col-lg-6">
                            <br>Apresentou algum tipo de dificuldade em uma determinada atividade?<select class="form-control select2" name="grupo_dificuldade" style="width: 100%;">                                  
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
                        