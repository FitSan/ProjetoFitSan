<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/bootstrap.css">
        <!-- Estilo Personalizado-->
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/style.css">
        <?php require_once 'autenticacao.php'; ?>  


        <title>FitSan<?= ' - ' . $pagina ?></title>

    </head>
    <body>
        <?php
        if (!estaLogado()) {
            header('Location: form_login.php');
        }else{
        ?>
        <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-info"><!--CONFIGURACAO DA NAVBAR-->
            <!--<div class="container"> ALINHA COM O RESTO DA POSTAGEM-->
            <a class="navbar-brand h1 mb-0" href="http://localhost/FitsanPI/pagina1.php">FitSan</a><!--DEIXA O LOGO DIFERENCIADO-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsite"> <!--GERA OS BOTOES DA NAVBAR-->
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsite">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/FitsanPI/pagina1.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (getTipo() == "aluno") {
                            echo "<a class='nav-link' href='http://localhost/FitsanPI/vinculos.php?tipo=$_SESSION[tipo]'> Profissionais</a></li>";//enviando o tipo para mudar o nome da página
                            echo "<li class='nav-item'><a class='nav-link' href='#'> Planilha</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='#'> Avaliações</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='#'> Histórico</a></li>";
                        } else {
                            echo "<li class='nav-item'><a class='nav-link' href='http://localhost/FitsanPI/vinculos.php?tipo=$_SESSION[tipo]'> Alunos</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='http://localhost/FitsanPI/minhas_dicas.php'> Minhas Dicas</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='#'> Planilha</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='#'> Avaliações</a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/FitsanPI/busca_usuarios.php">Busca</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navDrop">
                            <?php
                            if (estaLogado()) {
                                echo 'Olá, ' . getTipo() . ' ' . exibirName();
                            }
                            ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="http://localhost/FitsanPI/form_conf.php">Configuração</a>
                            <a class="dropdown-item" href="#">Breve</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#siteModal">Sair</a>

                        </div>
                    </li>

                </ul>

                <!--</div> FECHAMENTO DA DIV CONTAINER-->
            </div>
        </nav>
        <?php } ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->














