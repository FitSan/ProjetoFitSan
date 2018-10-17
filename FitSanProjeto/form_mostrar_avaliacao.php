<?php
$pagina = " Avaliações ";
require_once './template/cabecalho.php';
ini_set('display_errors', true);

//quando um tipo diferente tentar acessar pelo navegador ele será redirecionado para a pagina 1. 

if (!tipoLogado("aluno")){
    header('Location: pagina1.php');
    exit;
}

$id_avaliacao = $_GET['id_avaliacao'];

$query = "select * from `avaliacao` where id= $id_avaliacao";
$resultado = mysqli_query($conexao, $query);
 $linha = (mysqli_fetch_array($resultado));




//exit;


?>
<style>

</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Avaliação  </h1>
    </section>
    <section class="content">
        <form method="post" action="">

            <div class="box box-primary">


          
                    <div class="box-body">           
                        <div class="col-lg-10" >
                            <br>Desempenho do aluno com as atividades <font color="red" ><h5><?= $linha[desempenho]?></h5></font> 
                            <br>Frequência do aluno com as atividades <font color="red" ><h5><?= $linha[frequencia]?></h5></font> 
                            <br>Cumpriu com os objetivos estipulados? <font color="red" ><h5><?= $linha[grupo_cumpriu]?></h5></font> 
                             <br>O aluno tira dúvida com o professor? <font color="red" ><h5><?= $linha[grupo_duvida]?></h5></font> 
                             <br>Apresentou algum tipo de dificuldade em uma determinada atividade? <font color="red" ><h5><?= $linha[grupo_dificuldade]?></h5></font> 
                             <br> Caso sim, qual?<font color="red" ><h5><?= $linha[caso_sim]?></h5></font> 
                             <br> <strong>Considerações gerais</strong> <font color="red" ><h5><?= $linha[consideracoes]?></h5></font>
                             
                        
           
        </section>
        <!--</div>-->

        <?php
         
        require_once './template/rodape_especial.php';
                        