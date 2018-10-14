<?php

namespace SDCU\GeneralBundle\Entity;

use \DateTime;

require_once './autenticacao.php';

$tipo = (!empty($_POST['meta_tipo']) ? $_POST['meta_tipo'] : null);
$data_inicial = (!empty($_POST['data_inicial']) ? $_POST['data_inicial'] : null);
$data_final = (!empty($_POST['data_final']) ? $_POST['data_final'] : null);
$peso_inicial = (!empty($_POST['peso_inicial']) ? $_POST['peso_inicial'] : null);
$peso_final = (!empty($_POST['peso_final']) ? $_POST['peso_final'] : null);

//echo $tipo;
//echo $data_inicial;
//echo $data_final;
//echo $peso_inicial;
//echo $peso_final;
//$data_inicial = strtotime(dataParse('d/m/Y', $data_inicial));
//$data_fim = strtotime(dataParse('d/m/Y',$data_final));
//
//// Resgata diferença entre as datas
//$diff = ($data_inicial - $data_final) / 86400;
//echo $diff;

$data_inicial = date('Y-m-d', dataParse($data_inicial));
$data_final = date('Y-m-d', dataParse($data_final));
echo $data_inicial;
echo $data_final;
$data_inicio = new DateTime($data_inicial);
$data_fim = new DateTime($data_final);

// Resgata diferença entre as datas
$diff = $data_inicio->diff($data_fim);
$diff = $diff->format("%r%a");

//365

$erro = false;
if ($tipo == null) {
    $_SESSION['erro_meta'] = 'Preencha o tipo da meta';
    $erro = true;
}

if ($data_inicial == null) {
    $_SESSION['erro_dataI'] = 'Preencha a data inicial da meta';
    $erro = true;
} elseif ($peso_final == null) {
    $_SESSION['erro_dataF'] = 'Preencha a data final da meta';
    $erro = true;
} elseif ($diff <= 0) {
    $_SESSION['erro_data'] = 'Escolha datas válidas';
    $erro = true;
}

if ($peso_inicial == null) {
    $_SESSION['erro_pesoI'] = 'Preencha o peso inicial da meta';
    $erro = true;
} elseif ($peso_final == null) {
    $_SESSION['erro_pesoF'] = 'Preencha seu peso final';
    $erro = true;
} elseif ($peso_final <= $peso_inicial && $tipo == 'GANHAR' || $peso_inicial <= $peso_final && $tipo == 'PERDER') {
    $_SESSION['erro_peso'] = 'Preencha uma meta de peso válida';
    $erro = true;
}
echo $peso_inicial . '   ' . $peso_final;
if ($erro) {
    header('Location: metas.php');
} else {
    $verificar_metas = "select * from meta where usuario_id=" . $_SESSION['id'] . " and status='ativa'";
    $resultado = mysqli_query($conexao, $verificar_metas);
    if (mysqli_fetch_array($resultado) == null) {
        $query = "insert into meta (tipo, data_inicial, data_final, peso_inicial, peso_final, usuario_id) values ('$tipo', '$data_inicial', '$data_final', '$peso_inicial', '$peso_final', '$_SESSION[id]')";
        $resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$sql.PHP_EOL.print_r(debug_backtrace(), true));
        if (!$resultado) {
            $_SESSION['erro'] = "Meta não iniciada! Falha na conexão.";
            header('Location: metas.php');
        } else {
            $_SESSION['info'] = "Meta iniciada!";
            header('Location: metas.php');
        }
        header('Location: metas.php');
    } else {
        $_SESSION['erro'] = 'Já existe meta ativa!';
    }
}


