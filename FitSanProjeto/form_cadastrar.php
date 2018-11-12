<?php
$pagina = "Cadastro";
include './autenticacao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
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
                <p class="login-box-msg">Cadastre-se no FitSan</p>

                <form action="<?=URL_SITE?>cadastrar.php" method="post">

                    <div class="form-group has-feedback">
                        
                        <label class="sr-only" for="nome">Nome</label>
                        <input type="text" name="nome" value="<?php if (!empty($_SESSION['erro_nome'])){ echo $_SESSION['erro_nome'];  unset($_SESSION['erro_nome']);}?>" required style="text-transform: capitalize" class="form-control"  placeholder="Nome">
                        <span class="glyphicon  form-control-feedback"></span>

                    </div>

                    <div class="form-group has-feedback">
                        <label class="sr-only" for="sobrenome">Sobrenome</label>
                        <input type="text" name="sobrenome" value="<?php if (!empty($_SESSION['erro_sobrenome'])){ echo $_SESSION['erro_sobrenome'];  unset($_SESSION['erro_sobrenome']);}?>" required style="text-transform: capitalize" class="form-control" placeholder="Sobrenome">
                        <span class="glyphicon  form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label class="sr-only" for="email">Email</label>
                        <input type="email" name="email" value="<?php if (!empty($_SESSION['erro_email'])){ echo $_SESSION['erro_email'];  unset($_SESSION['erro_email']);}?>" class="form-control" placeholder="Email">
                        <span class="glyphicon  form-control-feedback"></span>
                    </div>

                    <?php
                    if (!empty($_SESSION['erroemail'])) {
                        ?> <div class="alert alert-danger">
                            <strong>Esse email já existe no sistema!</strong>.
                        </div> <?php
                        unset($_SESSION['erroemail']);
                    }
                    ?>       



                    <div class="form-group has-feedback">
                        <label class="sr-only" for="senha">Senha</label>
                        <input type="password" name="senha"  value="<?php if (!empty($_SESSION['erro_senha'])){ echo $_SESSION['erro_senha'];  unset($_SESSION['erro_senha']);}?>" class="form-control" placeholder="Senha">
                        <span class="glyphicon  form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label class="sr-only" for="confsenha">Confirme sua Senha</label>
                        <input type="password" name="confsenha" value="<?php if (!empty($_SESSION['erro_confsenha'])){ echo $_SESSION['erro_confsenha'];  unset($_SESSION['erro_confsenha']);}?>" class="form-control" placeholder="Digite Novamente sua Senha">
                        <span class="glyphicon  form-control-feedback"></span>
                    </div>



                    <?php if (!empty($_SESSION['erroCount'])) {
                        ?> <div class="alert alert-danger">
                            <strong>A senha deve conter do mínimo 8 caracteres</strong>.
                        </div> <?php
                        unset($_SESSION['erroCount']);
                    }
                    ?>



                    <?php if (!empty($_SESSION['errosenha'])) {
                        ?> <div class="alert alert-danger">
                            <strong>Senhas Divergentes</strong>.
                        </div> <?php
                        unset($_SESSION['errosenha']);
                    }
                    ?>

                    <p class="login-box-msg">Escolha seu tipo de usuário</p>

                    <div class="form-group">
                        <label class="sr-only" for="tipo">Tipo</label>
                        <?php
                        include './bancodedados/conectar.php';
                        $query = "select * from tipo_usuario";
                        $resultado = mysqli_query($conexao, $query);
                        ?>
                        <select name="tipo_id" class="tipo form-control" id="tipo">
                            <?php
                            while ($linha = mysqli_fetch_array($resultado)) {
                                ?>               
                                <option value="<?= $linha['id'] ?>"><?= $linha['tipo'] ?></option>

                                <?php
                            }
                            ?>
                        </select>

                        <br>

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Cadastrar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                </form>

                <!-- /.social-auth-links -->
                <br>

                <p class="login-box-msg">  <a href="<?=URL_SITE?>form_login.php">Já possuo uma conta</a></p>


            </div>
            <!-- /.login-box-body -->
        </div>


    </script>
</body>
</html>
