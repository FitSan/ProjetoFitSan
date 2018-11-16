<?php
$pagina = "Receber Senha";
require_once './template/cabecalho.php';
?>
    <body class="hold-transition login-page" id="fundologin">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?=URL_SITE?>form_login.php"><b>Fit</b>San</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Recuperar Senha</p>

                <form action="<?=URL_SITE?>recSenha.php" method="post">
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
                            <strong>A senha deve conter no mínimo 8 caracteres</strong>.
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

                <p class="login-box-msg">  <a href="<?=URL_SITE?>form_cadastrar.php">Não tenho conta</a></p>


            </div>
            <!-- /.login-box-body -->
        </div>


    </script>
</body>
</html>






