<?php
$pagina = " Lista de Avaliações ";
require_once './template/cabecalho.php';
require_once './template/menu.php';

//quando um tipo diferente tentar acessar pelo navegador ele será redirecionado para a pagina 1. 

if (!tipoLogado("profissional")) {
    header('Location: '.URL_SITE.'pagina1.php');
    exit;
}
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
            $query = "select * from `avaliacao` where profissional_id=" . $_SESSION['id']. " order by avaliacao.`data` desc";
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
                
                 $nome_aluno = $linha['nome'];
                 
                 $sobrenome_aluno = $linha['sobrenome'];
                
                ?>

                    <div class="nav-tabs-custom" align="center">
                        <div class="tab-content">


                            <div class="timeline-item">

                                <samp class="border border-primary"></samp>

                                <span class="time"><i class="calendar-table"></i> <?= date('d/m/Y', dataParse($usuario['data'])) ?></span>

                                <h3 class="timeline-header">Avaliação do Aluno <br> <strong><?php echo htmlspecialchars($linha['nome'])?> <?= htmlspecialchars($linha['sobrenome']); ?></strong></h3>

                              
                                    
                                    <a href="<?=URL_SITE?>form_mostrar_avaliacao.php?id_avaliacao='<?php echo$id_avaliacao;?>' & nome_aluno=<?php echo $nome_aluno; ?> & sobrenome_aluno=<?php echo $sobrenome_aluno; ?>">  
                                        <button type="button" class="btn btn-primary btn-flat"> Conferir </button>
                                    </a>




                            </div>
                        </div>
                    </div>

            
            
            <?php }
            
            }
            ?>     
        </form>
    </section>
    <!--</div>-->

    <?php
    require_once './template/rodape_especial.php';
    
