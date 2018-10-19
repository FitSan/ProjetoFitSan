<?php
$pagina = " Avaliações ";
require_once './template/cabecalho.php';
ini_set('display_errors', true);

//quando um tipo diferente tentar acessar pelo navegador ele será redirecionado para a pagina 1. 

if (!tipoLogado("profissional")) {
    header('Location: pagina1.php');
    exit;
}




//
//echo $linha[data]  ;
//exit;
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1> Lista de Avaliações </h1>
    </section>
    <section class="content">
        <form method="post" action="">

            <div class="box box-primary">

            </div>
            <?php
            $usuarios = array();
            $query = "select * from `avaliacao` where profissional_id=" . $_SESSION['id'];
            $retorno = mysqli_query($conexao, $query);
            while ($linhas = mysqli_fetch_array($retorno)) {
                array_push($usuarios, $linhas);
            }
            if($usuarios == null){
                ?>
                 <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Você não possui nenhuma avaliação!</b></h3></div>
                 <?php
            } else {
                
            foreach ($usuarios as $usuario) {
                ?>
 
                <?php
                $sql = "select * from `usuario` where id=" . $usuario['aluno_id'];
                $retorno_usuario = mysqli_query($conexao, $sql);
                $linha = (mysqli_fetch_array($retorno_usuario));
                 
                
                 
                $id_avaliacao = $usuario['id'];   
                
                ?>
            <a href="http://localhost/FitSan/form_mostrar_avaliacao.php?id_avaliacao=<?php echo $id_avaliacao; ?>">
                <h3> Avaliação do Aluno <?= $linha['nome'] ?> / <?= $usuario['data'] ?> </h3>
                </a>
            
            
            <?php }
            
            }
            ?>     
        </form>
    </section>
    <!--</div>-->

    <?php
    require_once './template/rodape_especial.php';
    