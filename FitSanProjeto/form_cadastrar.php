<?php
$pagina = "Cadastro";
require_once './template/cabecalho.php';
?>
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
