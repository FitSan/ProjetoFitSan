<?php
require_once 'autenticacao.php';

?>  
<html lang="pt-br">
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
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        
        <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" >
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
            .example-modal .modal {
                position: relative;
                top: auto;
                bottom: auto;
                right: auto;
                left: auto;
                display: block;
                z-index: 1;
            }

            .example-modal .modal {
                background: transparent !important;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
        <?php
        if (!estaLogado()) {
            header('Location: form_login.php');
        } else {
            ?>

            <div class="wrapper">
                <header class="main-header">
                    <!-- Logo -->
                    <a href="http://localhost/FitSan/pagina1.php" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>F</b>S</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><b>Fit</b>San</span>
                    </a>
                    <nav class="navbar navbar-static-top">
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Alternar navegação</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>

                        </a>
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-warning"><?= totalNotificacao() ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">Você tem  <?= totalNotificacao() ?> notificações</li>
                                        <!--   fazer notificação ficar no plural quando tiver numeros acima de 1-->
                                        <li>
                                            <!-- inner menu: contains the actual data -->
                                            <?php
                                            $notificacao = consultarNotificacao(); //carrega a notificação
                                            if ($notificacao) {
                                                ?><ul class="menu"><?php foreach ($notificacao as $linha) { ?>
                                                        <li class="alert <?php
                                                        if ($linha['status'] == 'OK') {
                                                            echo "alert-success";
                                                        } elseif ($linha['status'] == 'ERRO') {
                                                            echo "alert-danger";
                                                        } elseif ($linha['status'] == 'INFO') {
                                                            echo "alert-info";
                                                        }
                                                        ?>"> 

                                                            <?php
                                                            echo $linha['texto'] . '<br/>';
                                                            if ($linha['profissional_id'] && ($linha['profissional_id'] != $_SESSION['id'])) {
                                                                echo 'Profissional: ' . $linha['prof_nome'] . ' ' . $linha['prof_sobrenome'] . '<br/>';
                                                            }
                                                            if ($linha['aluno_id'] && ($linha['aluno_id'] != $_SESSION['id'])) {
                                                                echo 'Aluno: ' . $linha['al_nome'] . ' ' . $linha['al_sobrenome'] . '<br/>';
                                                            }
                                                            ?>   

                                                        </li><?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </li>
                                    </ul>                                                                                             
                                </li>
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php if (!empty($_SESSION['foto'])){ ?>
                                        <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="user-image" alt="User Image">
                                        <?php } else { ?>
                                        <img src="img/user-avatar-placeholder.png" class="user-image" alt="User Image">
                                        <?php } ?>
                                         <span class="hidden-xs"><?php
                                            if (estaLogado()) {
                                                echo 'Olá ' . exibirName();
                                            }
                                            ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li class="user-header">
                                            <?php if (!empty($_SESSION['foto'])){ ?>
                                            <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="img-circle" alt="User Image">
                                            <?php } else { ?>
                                            <img src="img/user-avatar-placeholder.png" class="img-circle" alt="User Image">
                                            <?php } ?>
                                            <p>
                                                <?php echo exibirName(true); ?>
                                                <small>Membro desde <?= date('d/m/Y', dataParse($_SESSION['datahora'])) ?></small>
                                            </p>
                                        </li>
                                        <!-- Menu Body -->
                                        <li class="user-body">
                                            <div class="row">
<?php if (tipoLogado("aluno")) { ?>
                                                <div class="col-xs-4 text-center">
                                                        <a href="http://localhost/FitSan/vinculos.php?tipo=<?php echo $_SESSION['tipo'] ?>"> Profissionais</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                    <span>&nbsp;</span>
                                                </div>
                                                <div class="col-xs-4 text-center">
<?php } elseif (tipoLogado("profissional")) { ?>
                                                <div class="col-xs-4 text-center">
                                                        <a href="http://localhost/FitSan/vinculos.php?tipo=<?php echo $_SESSION['tipo'] ?>"> Alunos</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                    <span>&nbsp;</span>
                                                </div>
                                                <div class="col-xs-4 text-center">
<?php } else { ?>
                                                <div class="col-xs-12 text-center">
<?php } ?>
                                                    <a href="http://localhost/FitSan/form_conf.php">Configuração</a>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="http://localhost/FitSan/perfil.php" class="btn btn-default btn-flat">Perfil</a>
                                            </div>
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-default">
                                                    Sair 
                                                </button>                                             
                                            </div>
                                        </li>
                                       
                                    </ul>
                                </li>                              
                            </ul>
                        </div>
                    </nav>
                </header>

                <aside class="main-sidebar">
                    <section class="sidebar">
                        <a href="http://localhost/FitSan/perfil.php"><div class="user-panel">
                            <div class="pull-left image">
                                <?php if (!empty($_SESSION['foto'])){ ?>
                                <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="img-circle" alt="User Image">
                                <?php } else { ?>
                                <img src="img/user-avatar-placeholder.png" class="img-circle" alt="User Image">
                                <?php } ?>
                            </div>
                            <div class="pull-left info">
                                <p><?php echo exibirName(true); ?></p>
                                
                                <!--caso queira por se o usuario esta online ou nao.-->
                                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                                
                            </div>
                        </div></a>
                        <form action="busca.php" method="post" class="sidebar-form">
                            <div class="input-group">
                                <input type="text" name="busca" class="form-control" placeholder="Busca...">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">NAVEGAÇÀO PRINCIPAL</li>
                            <li class="menu-open">
                                <a href="http://localhost/FitSan/pagina1.php">
                                    <i class="fa fa-home"></i> <span>Home</span>                                  
                                </a>
                            </li>
                            <?php if (tipoLogado("aluno", "profissional")){ ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-id-badge"></i>
                                    <span>Área Pessoal</span>                                     
                                </a>
                                <ul class="treeview-menu">
                                    <?php
                                    if (tipoLogado("aluno")){
                                        echo "<li><a href='#'><i class='fa fa-circle-o'></i> Metas </a></li>";
                                        echo "<li><a href='http://localhost/FitSan/atividadesExtras.php'><i class='fa fa-circle-o'></i> Atividades Extras </a></li>";
                                        echo "<li><a href='#'><i class='fa fa-circle-o'></i> Contato </a></li>";
                                    } elseif (tipoLogado("profissional")){
                                        echo "<li><a href='#'><i class='fa fa-circle-o'></i> Contato </a></li>";
                                    }
                                    ?>     
                                </ul>
                            </li>
                            <?php } ?>
                            <?php
                            if (tipoLogado("aluno")){
                                echo "<li><a href='#'><i class='fa fa-th-list'></i><span>Planilha</span></a></li>";
                                echo "<li><a href='http://localhost/FitSan/form_avaliacao.php'><i class='fa fa-pencil'></i><span>Avaliações</span></a></li>";
                                echo "<li><a href='#'><i class='fa fa-history'></i><span>Histórico</span></a></li>";
                            } elseif (tipoLogado("profissional")){
                                echo "<li><a href='http://localhost/FitSan/minhas_dicas.php'><i class='fa fa-heartbeat'></i><span>Minhas Dicas</span></a></li>";
                                echo "<li><a href='http://localhost/FitSan/planilha.php'><i class='fa fa-th-list'></i><span>Planilha</span></a></li>";
                                echo "<li><a href='#'><i class='fa fa-address-book'></i><span>Evoluções</span></a></li>";
                            } elseif (tipoLogado("admin")){
                                echo "<li><a href='http://localhost/FitSan/area_admin.php'><i class='fa fa-th-list'></i><span>Área Administrativa</span></a></li>";
                            }
                            ?>
                            <!--                            <li>
                                                            <a href="http://localhost/FitSan/busca_usuarios.php">
                                                                <i class="fa fa-th"></i> <span>Busca</span>
                                                            </a>
                                                        </li>-->
                        </ul>
                    </section>
                </aside>        
            <?php } ?>
