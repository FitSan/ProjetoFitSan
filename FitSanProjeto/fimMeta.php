<?php
namespace SDCU\GeneralBundle\Entity;

use \DateTime;

require_once './autenticacao.php';

if (isset($_POST['meta_id'])) {
    $id_meta = $_POST['meta_id'];
}
$query_dados = "select data_inicial, MAX(data_add) as max_mes from dados_meta join meta on dados_meta.meta_id= meta.id where usuario_id='" . $_SESSION[id] . "' and status='ativa'";
$resultado_dados = mysqli_query($conexao, $query_dados);
$linha_dados = mysqli_fetch_array($resultado_dados);


$max_data_add = new DateTime($linha_dados['max_mes']);

$data_inicial = new DateTime($linha_dados['data_inicial']);
//echo $data_inicial;

$data_final = date('Y-m-d');
$data_fim = new DateTime($data_final);

$diff_add = $max_data_add->diff($data_fim);
$diff_add = $diff_add->format("%r%a");

$diff_inicial = $data_inicial->diff($data_fim);
$diff_inicial = $diff_inicial->format("%r%a");

if ($diff_inicial < 0) {
    $_SESSION['erro_data'] = 'Meta não pode ser finalizada! Data inicial da meta posterior a data de hoje!';
    header('Location: ' . URL_SITE . 'metas.php');
}else{

if ($diff_add < 0) {
    $_SESSION['erro_data'] = 'Meta não pode ser finalizada! Meta possui dados posteriores a data de hoje!';
    header('Location: ' . URL_SITE . 'metas.php');
} else {
    $query = "update meta set status='finalizada', data_final=".mysqliEscaparTexto(time(), 'datetime')." where id=$id_meta";
    if (!mysqli_query($conexao, $query)) {
        $_SESSION['erro'] = 'Meta não finalizada! Falha na conexão.';
        header('Location: ' . URL_SITE . 'metas.php');
    } else {
        $query_info = "select * from meta where id= $id_meta";
        $resultado = mysqli_query($conexao, $query_info);
        $linha = mysqli_fetch_array($resultado);
        criarNotificacao('INFO', 'Você finalizou sua meta em ' . date('d M Y', dataParse($linha['data_final'])) . '<br><a href="' . URL_SITE . 'okMetaNot.php">Ver</a>', null, $_SESSION['id'], null);
        $_SESSION['info'] = 'Meta finalizada!';
        header('Location: ' . URL_SITE . 'metas.php');
    }
}
}