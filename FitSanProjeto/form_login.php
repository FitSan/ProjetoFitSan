 <?php
$pagina = "Login";
require_once './template/cabecalho1.php';
require_once './autenticacao.php';
?>



<div class="modal-dialog text-center" id="login"><!--INICIO MODAL-->
    <div class="col-sm-8 main-section" id="login">
        <div class="modal-content" id="login">
            <div class="col-12 user-img" id="login">
                <img src="img/face.png">
            </div> 
            <h1 class="entrar" id="login">Login</h1>  
            <form class="col-12" method="post" action="logar.php" id="login">
                <div class="form-group" id="login">
                    <input class="form-control" type="email" name="e-mail" placeholder="Entre com seu E-mail"> 
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="senha" placeholder="Entre com sua Senha">
                </div>
                 <?php     
            if (!empty($_SESSION['erro'])){
            ?>
            <div class="alert alert-danger alert-dismissible" style="width: 100%">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Erro!</strong> <?php echo htmlspecialchars($_SESSION['erro']) ?>
                </div>
            <?php     
                unset($_SESSION['erro']);
            }
            ?>
                    <button type="submit" class="btn" id="login">Logar</button>    
                    <button type="reset" class="btn" id="login">Limpar</button>   
            </form>
            <div class="col-12 forgot" id="login">
                <a href="#">Esqueceu a senha?</a>
            </div>
            <div class="col-12 forgot" id="login">
                <a href="form_cadastrar.php"> Não tenho uma conta.</a>
            </div>

        </div>     
    </div>   
</div> <!--FIM MODAL-->

<?php
        include './template/rodape.php';      










 