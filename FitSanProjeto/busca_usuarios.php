<?php
$pagina = "Busca";
require_once './template/cabecalho.php';

if(tipoLogado('profissional')){
    $query = "select * from usuario u left join vinculo v on v.aluno_id = u.id and v.profissional_id = $_SESSION[id] where u.tipo_id=1";
    //$sql = "select * from vinculo where profissional_id=$_SESSION[id]";
    $usuario_busca = 'aluno_id'; 
}else{
    $query = "select * from usuario u left join vinculo v on v.profissional_id = u.id and v.aluno_id = $_SESSION[id] where u.tipo_id=2";
    // tradução selecione a tabela usuario apelidado de u juntando a tabela vinculo apelidada de v apenas quando o profissional_id da tabela vinculo for igual ao id da tabela usuario.
    ///$query = "select * from usuario where tipo_id=2";
    //$sql = "select * from vinculo where aluno_id=$_SESSION[id]";
    $usuario_busca = 'profissional_id'; 
}

$resultado = mysqli_query($conexao, $query);

//$resultado_vinculo = mysqli_query($conexao, $sql);
?>
<div class="container">
    <h1 style="padding: 10px"><?=$pagina?></h1>



<table  cellpadding="5">            
    <?php
    //$vinculado = false;
    while ($linha = mysqli_fetch_array($resultado)) {
        /*while ($linha_vinculo = mysqli_fetch_array($resultado_vinculo)) {
            if ($linha['id'] == $linha_vinculo[$usuario_busca]) {
                $vinculado = true;
                break;                
            } else {
                $vinculado = false;                
            }
        }        
        mysqli_free_result($resultado_vinculo);
        $resultado_vinculo = mysqli_query($conexao, $sql);
         */
        $vinculado = (!empty($linha[$usuario_busca]) ? $linha['status'] : false);
        ?>
    <tr style="margin-bottom: 20px">
            <td style="width: 150px"><?= $linha['nome'] ?></td>
            <td style="width: 300px"><?= $linha['email'] ?></td>
            <?php
            if ($vinculado === 'aprovado') {
                ?>
                <th><a href="desvincular.php?id=<?= $linha['id'] ?>"><img src="img/desconvite.png" height="40"></a></th>                
                <?php
            } elseif ($vinculado === 'espera') {
                if (tipoLogado($linha['solicitante'])){
                ?>
                <th>Aguardando</th>                
                <?php
                } else {
                ?>
                <th><a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=aprovado">Aceitar</a> <a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=negado">Negar</a></th>                
                <?php
                }
            } else {
                ?>
                <th><a href="vincular.php?id=<?= $linha['id'] ?>"><img src="img/convite.png" height="40"></a></th>
                <?php
            }
            ?>
        </tr>
            <?php
        }
        ?>
</table>
</div>
<?php
include './template/rodape_especial.php';


