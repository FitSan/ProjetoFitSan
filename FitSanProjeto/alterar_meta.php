<?php

namespace SDCU\GeneralBundle\Entity;

use \DateTime;

require_once './autenticacao.php';

$tipo = (!empty($_POST['meta_tipo']) ? $_POST['meta_tipo'] : null);
$data_inicial = (!empty($_POST['data_inicial']) ? $_POST['data_inicial'] : null);
$data_final = (!empty($_POST['data_final']) ? $_POST['data_final'] : null);
$peso_inicial = (!empty($_POST['peso_inicial']) ? $_POST['peso_inicial'] : null);
$peso_final = (!empty($_POST['peso_final']) ? $_POST['peso_final'] : null);

$erro = false;
if ($data_inicial == null) {
    $_SESSION['erro_dataI'] = 'Preencha a data inicial da meta';
    $erro = true;
} 
if ($data_final == null) {
    $_SESSION['erro_dataF'] = 'Preencha a data final da meta';
    $erro = true;
} 

if (!$erro){
    $data_now = date('Y-m-d');
    $data_now = new DateTime($data_now);
    
    $data_inicial = date('Y-m-d', dataParse($data_inicial));
    $data_final = date('Y-m-d', dataParse($data_final));
    $data_inicio = new DateTime($data_inicial);
    $data_fim = new DateTime($data_final);

    // Resgata diferença entre as datas
    $diff_agora = $data_fim->diff($data_now);
    $diff_agora = $diff_agora->format("%r%a");
    
    $diff = $data_inicio->diff($data_fim);
    $diff = $diff->format("%r%a");
    
    if($diff_agora>0){
        $_SESSION['erro_data'] = 'Escolha uma data final posterior à atual';
        $erro = true;
    }else if ($diff <= 0) {
    $_SESSION['erro_data'] = 'Escolha datas válidas';
    $erro = true;
}

}


if ($tipo == null) {
    $_SESSION['erro_meta'] = 'Preencha o tipo da meta';
    $erro = true;
}


if ($peso_inicial == null) {
    $_SESSION['erro_pesoI'] = 'Preencha o peso inicial da meta';
    $erro = true;
} 
if ($peso_final == null) {
    $_SESSION['erro_pesoF'] = 'Preencha seu peso final';
    $erro = true;
} 
if ($peso_final <= $peso_inicial && $tipo == 'GANHAR' || $peso_inicial <= $peso_final && $tipo == 'PERDER' || $peso_inicial != $peso_final && $tipo == 'MANTER') {
    $_SESSION['erro_peso'] = 'Preencha uma meta de peso válida';
    $erro = true;
}

if ($erro) {
    header('Location: metas.php');
} else {
        $query = "update meta set tipo='$tipo', data_inicial='$data_inicial', data_final='$data_final', peso_inicial='$peso_inicial', peso_final='$peso_final' where usuario_id='".$_SESSION[id]."' and status='ativa'";
        
        if (!mysqli_query($conexao, $query)) {
            $_SESSION['erro'] = "Meta não alterada! Falha na conexão.";
            header('Location: metas.php');
        } else {
            $query_dado_meta = "update dados_meta set data_add=(data_add, peso_add, meta_id) values ('$data_inicial', peso_add='$peso_inicial' where meta_id=  and id=1";
            mysqli_query($conexao, $query_dado_meta);
            $_SESSION['info'] = "Meta alterada!";
            header('Location: metas.php');
        }
}


