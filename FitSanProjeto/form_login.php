<?php
$pagina = "Login";
require_once './template/cabecalho.php';
?>
    <body class="hold-transition login-page" id="fundologin">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?=URL_SITE?>form_login.php"><b>Fit</b>San</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">LOGIN</p>
                                <?php
                if(!empty($_SESSION['cadastrado'])) {
                    
                  ?> <div class="alert alert-info">
                <strong>Cadastro feito com Sucesso. Verifique seu email para ativar a conta!</strong>.
                </div> <?php
                 
                    unset($_SESSION['cadastrado']);
                }
                ?>
                <form action="<?=URL_SITE?>logar.php" method="post">

                    <div class="form-group has-feedback">
                        <label class="sr-only" for="email">Email</label>
                        <input type="email" name="e-mail" class="form-control" placeholder="Entre com seu E-mail">
                        <span class="glyphicon  form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label class="sr-only" for="senha">Senha</label>
                        <input type="password" name="senha" class="form-control" placeholder="Entre com sua Senha">
                        <span class="glyphicon  form-control-feedback"></span>
                    </div>
                    
                <?php
                if(!empty($_SESSION['erro'])) {
                    
                  ?> <div class="alert alert-danger">
                <strong>Dados não Conferem!</strong>.
                </div> <?php
                 
                    unset($_SESSION['erro']);
                }
                ?>
                    

                        
                        <br>

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Logar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        
                        <br>
                       </form> 
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-12">
                        <a href="<?=URL_SITE?>form_cadastrar.php"><button class="btn btn-primary btn-block btn-flat">Cadastrar</button></a>
                            </div>
                            <!-- /.col -->
                        </div>
                             
                        
                

                <!-- /.social-auth-links -->
                <br>
       
               <p class="login-box-msg">  <a href="<?=URL_SITE?>form_recEmail.php">Esqueceu a senha?</a></p>


            </div>
            <!-- /.login-box-body -->
        </div>


    <?php
            include_once './template/rodape.php';










 