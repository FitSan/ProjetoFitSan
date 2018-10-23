<?php
$pagina = "Area do administrador";
require_once './template/cabecalho.php';

if (!tipoLogado("admin")){
    header('Location: pagina1.php');
    exit;
}
?>

<div class="content-wrapper">
    <div class="box-header">
        <h1>Area do administrador</h1>
    </div>   
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Escolha onde deseja ir</h3>
        </div>
        <div class="box-body">
            <a href="lista_usuarios_admin.php" class="btn btn-app">
                <i class="fa fa-user"></i> Usuarios
            </a>
            
            <a href="planilha_muscCard.php" class="btn btn-app">
                <i class="fa fa-heart"></i> Músculos/Cárdio
            </a>
            <a href="planilha_exercicios.php" class="btn btn-app">
              <i class="fa fa-bicycle"></i> Exercícios  
            </a>
        </div>
        <div class="box-footer">        
    </div>
    </div>   
</div>

<?php
require_once './template/rodape_especial.php';
?>