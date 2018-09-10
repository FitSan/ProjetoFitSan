<?php
$pagina = "Profissionais";
include './template/cabecalho.php';
include './bancodedados/conectar.php';
$query = "select * from usuario join vinculo on usuario.id=vinculo.profissional_id where vinculo.aluno_id=$_SESSION[id]";
$resultado = mysqli_query($conexao, $query);
?>
<h1>Profissionais</h1>

<h2>Professores vínculados:</h2>
<table>            
    <?php
    while ($linha = mysqli_fetch_array($resultado)) {
        ?>
        <tr>
            <td style="width: 200px"><?= $linha['nome'] ?></td>
            <td style="width: 200px"><?= $linha['email'] ?></td>
            <th><a href="desvincular.php?id=<?= $linha['id'] ?>"><img src="img/desconvite.png" height="40"></a></th>
        </tr>
        <?php
    }
    ?>
</table>
<?php
include './template/rodape.php';
