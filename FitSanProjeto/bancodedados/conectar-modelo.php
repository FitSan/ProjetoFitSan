<?php
define('URL_SITE', 'http://localhost/FitSan/');
define('EMAIL', 'plataformafitsan@gmail.com');
define('EMAIL_HOST', 'smtp.gmail.com');
define('EMAIL_AUTH', true);
define('EMAIL_AUTOTLS', false);
define('EMAIL_SECURE', 'ssl');
define('EMAIL_USERNAME', 'plataformafitsan@gmail.com');
define('EMAIL_PASSWORD', 'NaStiF321');
define('EMAIL_PORT', 465);

$conexao = mysqli_connect("localhost", "root", "ifsc", "FitSan", "3306");
mysqli_query($conexao, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
