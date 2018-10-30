<?php
define('URL_SITE', 'http://localhost/FitSan/');

$conexao = mysqli_connect("localhost", "root", "ifsc", "FitSan", "3306");
mysqli_query($conexao, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
