<?php
require_once './autenticacao.php';
ini_set('display_errors', true);
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>FitSan<?= ' - ' . $pagina ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>



    <body class="hold-transition login-page" id="fundologin">
        <div class="login-box">
            <div class="login-logo">
                <a href="form_login.php"><b>Fit</b>San</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Recuperar Senha</p>

                <form action="recSenha.php" method="post">
                    <h4> Trocar Senha</h4>
                    <?php
                    $codigo = $_GET['perfil_codigo'];

                    $_SESSION['codigo'] = $codigo;
                    ?>
                    <div class="form-group">
                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" >
                    </div>

                    <div class="form-group">
                        <label for="repita_senha">Repita sua Senha</label>
                        <input type="password" class="form-control" id="repita_senha" name="repita_senha" >
                    </div>



                    <br>

                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                        </div>
                        <!-- /.col -->
                    </div>

                    <?php if (!empty($_SESSION['erroCount'])) {
                        ?> <div class="alert alert-danger">
                            <strong>A senha deve conter do mínimo 8 caracteres</strong>.
                        </div> <?php
                        unset($_SESSION['erroCount']);
                    }
                    ?>
                                        <?php if (!empty($_SESSION['erroCodigo'])) {
                        ?> <div class="alert alert-danger">
                            <strong>DEU ERRO FILHÃO</strong>.
                        </div> <?php
                        unset($_SESSION['erroCodigo']);
                    }
                    ?>

                    <br>
                </form> 





                <!-- /.social-auth-links -->
                <br>

                <p class="login-box-msg">  <a href="form_cadastrar.php">Não tenho conta</a></p>


            </div>
            <!-- /.login-box-body -->
        </div>


    </script>
</body>
</html>






