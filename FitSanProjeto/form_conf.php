<?php
$pagina = 'Configurar Perfil';
require_once './template/cabecalho.php';

$pagina = "Meu Perfil";

require_once './template/cabecalho.php';


$query = "select * from usuario where id='" . $_SESSION['id'] . "'";
$resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));
if ($linha = mysqli_fetch_array($resultado)) {
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Configuração do perfil</h1>
        </section>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Meu Perfil</h3>
                </div>
                <form role="form" method="post" enctype="multipart/form-data" action="atuailizar_conf.php">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($linha['nome']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= htmlspecialchars($linha['sobrenome']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($linha['email']) ?>">
                        </div>
                        
                        </div>
                    
                             <div class="pull-right">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                               Sair
                                  </button>                                                
                               </div>
                    
                    
                    <button type="submit" class="btn btn-primary">Salvar</button>
                         
                    
                </form>
        </section>
        

    </div>
    <!--fim content-wrapper-->
    <?php
}else {

    echo "Não foi possivel";
}
include './template/rodape_especial.php';

