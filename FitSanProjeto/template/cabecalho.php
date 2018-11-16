<?php
require_once 'autenticacao.php';
if (tipoLogado('aluno')){
    verificarMeta();
}
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
        <link rel="stylesheet" href="<?= URL_SITE ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= URL_SITE ?>bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= URL_SITE ?>bower_components/Ionicons/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?= URL_SITE ?>bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= URL_SITE ?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= URL_SITE ?>dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= URL_SITE ?>plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="<?= URL_SITE ?>plugins/iCheck/all.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= URL_SITE ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">       
        <link rel="stylesheet" href="<?= URL_SITE ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" >
        <link rel="stylesheet" type="text/css" href="<?= URL_SITE ?>css/estilo.css">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= URL_SITE ?>img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= URL_SITE ?>img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= URL_SITE ?>img/favicon-16x16.png">
        <link rel="manifest" href="<?= URL_SITE ?>img/site.webmanifest">
        <link rel="mask-icon" href="<?= URL_SITE ?>img/safari-pinned-tab.svg" color="#5bbad5">
        <link href="<?= URL_SITE ?>css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        
        <meta name="msapplication-TileColor" content="#00aba9">
        <meta name="theme-color" content="#ffffff">
        
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
            .wrapper .sidebar-menu li>a>.pull-right-container {margin-top:0px;}
        </style>
        
    </head>
    
