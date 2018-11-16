<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
    <?php
    if (!estaLogado()) {
        header('Location: ' . URL_SITE . 'form_login.php');
    } else {
        ?>

        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?= URL_SITE ?>pagina1.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>F</b>S</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Fit</b>San</span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Alternar navegação</span>


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
                                    
                                    <li>
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
                                    <?php if (!empty($_SESSION['foto'])) { ?>
                                        <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="user-image" alt="User Image">
                                    <?php } else { ?>
                                        <img src="<?= URL_SITE ?>img/user-avatar-placeholder.png" class="user-image" alt="User Image">
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
                                        <?php if (!empty($_SESSION['foto'])) { ?>
                                            <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="img-circle" alt="User Image">
                                        <?php } else { ?>
                                            <img src="<?= URL_SITE ?>img/user-avatar-placeholder.png" class="img-circle" alt="User Image">
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
                                                    <a href="<?= URL_SITE ?>vinculos.php?tipo=<?php echo $_SESSION['tipo'] ?>"> Profissionais</a>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                    <span>&nbsp;</span>
                                                </div>
                                                <div class="col-xs-4 text-center">
                                                <?php } elseif (tipoLogado("profissional")) { ?>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="<?= URL_SITE ?>vinculos.php?tipo=<?php echo $_SESSION['tipo'] ?>"> Alunos</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <span>&nbsp;</span>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                    <?php } else { ?>
                                                        <div class="col-xs-12 text-center">
                                                        <?php } ?>
                                                        <a href="<?= URL_SITE ?>form_conf.php">Configuração</a>
                                                    </div>
                                                </div>
                                                </li>
                                                <!-- Menu Footer-->
                                                <li class="user-footer">
                                                    <div class="pull-left">
                                                        <a href="<?= URL_SITE ?>perfil.php" class="btn btn-default btn-flat">Perfil</a>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-sair">
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
                                                    <a href="<?= URL_SITE ?>perfil.php"><div class="user-panel">
                                                            <div class="pull-left image">
                                                                <?php if (!empty($_SESSION['foto'])) { ?>
                                                                    <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="img-circle"  alt="User Image">
                                                                <?php } else { ?>
                                                                    <img src="<?= URL_SITE ?>img/user-avatar-placeholder.png" class="img-circle"   alt="User Image">
                                                                <?php } ?>
                                                            </div>
                                                            <div class="pull-left info">
                                                                <p><?php echo exibirName(true); ?></p>
                                                            </div>
                                                        </div></a>
                                                    <!--Inicio formulario pesquisa-->
                                                    <form action="<?= URL_SITE ?>busca.php" method="post" class="sidebar-form">
                                                        <div class="input-group">
                                                            <input type="text" name="busca" class="form-control" placeholder="Busca...">
                                                            <span class="input-group-btn">
                                                                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </form>
                                                    <!--Final formulario pesquisa-->
                                                    <!--Inicio Sidebar menu -->
                                                    <ul class="sidebar-menu" data-widget="tree">
                                                        <li class="header">NAVEGAÇÀO PRINCIPAL</li>                          
                                                        <li><a href="<?= URL_SITE ?>pagina1.php"><i class="fa fa-home"></i><span>Home</span></a></li>
                                                        <?php if (tipoLogado("aluno")) { ?>
                                                            <li><a href="<?= URL_SITE ?>atividadesExtras.php"><i class="fa fa-pagelines"></i><span> Atividades Extras </span></a></li>
                                                            <li><a href="<?= URL_SITE ?>planilha_aluno.php"><i class="fa fa-th-list"></i><span>Planilha</span></a></li>
                                                            <li><a href="<?= URL_SITE ?>metas.php"><i class="fa fa-line-chart"></i><span> Metas </span></a></li>
                                                            <li><a href="<?= URL_SITE ?>form_receber_avaliacao.php"><i class="fa fa-pencil"></i><span>Avaliação</span></a></li>
                                                            <li><a href="<?= URL_SITE ?>historico.php"><i class="fa fa-history"></i><span>Histórico</span></a></li>
                                                            <li><a href="<?= URL_SITE ?>mensagens.php"><i class="fa fa fa-weixin"></i><span>Mensagens</span></a></li>
                                                        <?php } elseif (tipoLogado("profissional")) { ?>
                                                            <li><a href="<?= URL_SITE ?>minhas_dicas.php"><i class="fa fa-heartbeat"></i><span>Minhas Dicas</span></a></li>
                                                            <li><a href="<?= URL_SITE ?>planilha.php"><i class="fa fa-th-list"></i><span>Planilha</span></a></li>
                                                            <li><a href="<?= URL_SITE ?>form_avaliacao.php"><i class="fa fa-pencil"></i><span>Avaliações</span></a></li>
                                                            <li><a href="<?= URL_SITE ?>mensagens.php"><i class="fa fa-weixin"></i><span>Mensagens</span></a></li>
                                                        <?php } elseif (tipoLogado("admin")) { ?>
                                                            <li><a href="<?= URL_SITE ?>area_admin.php"><i class="fa fa-th-list"></i><span>Área Administrativa</span></a></li>
                                                                    <?php } ?>
                                                    </ul>
                                                </section>
                                            </aside>        
                                        <?php } ?>