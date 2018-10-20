<?php
// Visualg       => PHP       - Descrição
//  <-           => =         - Atribuição
//  =            => ==        - Igual
//  <>           => !=        - Diferente
//  >            => >         - Diferente
//  <            => <         - Diferente
//  .e.          => &&        - E
//  .ou.         => ||        - Ou
//  .não.        => !         - Não
//  <- a + b     => a += b    - Atribuição com soma
//  <- a - b     => a -= b    - Atribuição com subtração
//  <- a * b     => a *= b    - Atribuição com multiplicação
//  <- a / b     => a /= b    - Atribuição com divisão



$x = 10;
$y = 5;

// Soma
$z = $x + $y;
// $z == 15 

// Subitração
$z = $x - $y;
// $z == 5

// Multiplicação
$z = $x * $y;
// $z == 50

// Divisão
$z = $x / $y;
// $z = 2

// Pré-Incremento
$x = 1;
$z = ++$x; // x <- x + 1 ; z <- x
// z = 2 e x = 2

// Pós-Incremento
$x = 1;
$z = $x++; // z <- x ; x <- x + 1
// z = 1 e x = 2

// Pré-Decremento
$x = 1;
$z = --$x; // x <- x - 1 ; z <- x
// z = 0 e x = 0

// Pós-Decremento
$x = 1;
$z = $x--; // z <- x ; x <- x - 1
// z = 1 e x = 0

// marcar notificacao como lida
// 
//if (isset($_GET['notificacao'])){
//    leituraNotificacao($_GET['notificacao']);
//    echo '<script>window.location.reload();</script>';
//    exit;
//}