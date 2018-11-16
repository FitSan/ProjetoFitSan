<?php
$pagina = "Receber E-mail";
require_once './template/cabecalho.php';
?>

<body class="hold-transition login-page" id="fundologin">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= URL_SITE ?>form_login.php"><b>Fit</b>San</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Recuperar Senha</p>
            <form action="<?= URL_SITE ?>envio_email.php" method="post">
                <div class="form-group has-feedback">
                    <label class="sr-only" for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder=" Insira seu E-mail">
                    <span class="glyphicon  form-control-feedback"></span>
                </div>
                <?php
                if (!empty($_SESSION['erroEmail'])) {
                    ?> <div class="alert alert-danger">
                        <strong>Email não encontrado no banco de dados do site!</strong>.
                    </div> <?php
                    unset($_SESSION['erroEmail']);
                }
                ?>
                <?php
                if (!empty($_SESSION['sucesso'])) {
                    ?> <div class="alert alert-success">
                        <strong>Confira seu email</strong>.
                    </div> <?php
                    unset($_SESSION['sucesso']);
                }
                ?>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                    </div>
                </div>
                <br>
            </form> 
            <br>
            <p class="login-box-msg">  <a href="<?= URL_SITE ?>form_cadastrar.php">Não tenho conta</a></p>
        </div>
    </div>


 <?php
            include_once './template/rodape.php';








