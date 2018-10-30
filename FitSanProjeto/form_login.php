 <?php
$pagina = "Login";
require_once './autenticacao.php';
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FitSan<?= ' - ' . $pagina ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?=URL_SITE?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=URL_SITE?>bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?=URL_SITE?>bower_components/Ionicons/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?=URL_SITE?>bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=URL_SITE?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?=URL_SITE?>dist/css/skins/_all-skins.min.css">
        <link href="<?=URL_SITE?>css/estilo.css" rel="stylesheet" type="text/css"/>
        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page" id="fundologin">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?=URL_SITE?>form_login.php"><b>Fit</b>San</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">LOGIN</p>

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
                </div> <?php ;
                 
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


    </script>
</body>
</html>











 