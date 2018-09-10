        <?php
        $pagina = "Busca";
        include './template/cabecalho.php';
        include './bancodedados/conectar.php';
        if($_SESSION['tipo']<>'profissional'){
            header('Location: pagina1.php');
        }
        $query = "select * from usuario where tipo_id=1";
        $resultado = mysqli_query($conexao, $query);
        
        $sql = "select * from vinculo where profissional_id=$_SESSION[id]";
        $resultado_vinculo = mysqli_query($conexao, $sql);
        
        ?>
        <h1>Busca</h1>
        
        <h2> Encontre aqui o seu profissional:</h2>
        <table>            
            <?php
            $vinculado = false;
            while ($linha = mysqli_fetch_array($resultado)) {
                while ($linha_vinculo = mysqli_fetch_array($resultado_vinculo)) {
                    if ($linha['id'] == $linha_vinculo['aluno_id']) {
                        $vinculado = true;
                        break;
                    } else {
                        $vinculado = false;
                    }
                }
                mysqli_free_result($resultado_vinculo);
                $resultado_vinculo = mysqli_query($conexao, $sql);
                ?>
                <tr style="height: 25px;">
                    <td style="width: 200px"><?= $linha['nome'] ?></td>
                    <td style="width: 200px"><?= $linha['email'] ?></td>
                    <?php
                    if ($vinculado) {
                        ?>
                        <th><a href="desvincular.php?id=<?= $linha['id'] ?>"><img src="img/desconvite.png" height="40"></a></th>                
                        <?php
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
<?php
include './template/rodape.php';
