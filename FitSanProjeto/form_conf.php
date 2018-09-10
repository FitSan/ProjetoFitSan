<?php
$pagina = 'Configurar Perfil';
require_once './template/cabecalho.php';


$query = "select * from usuario where id=$_SESSION[id]";
$resultado = mysqli_query($conexao, $query);
$linha = mysqli_fetch_array($resultado);
?>
<div class="container">
    <form method="post" action="confP.php">
        <h1 style="padding: 10px"><?=$pagina?></h1>
        Nome: <input type="text" name="nome" required style="text-transform: capitalize" value="<?= $linha['nome'] ?>"><br><br>
        E-mail: <input type="email" name="email" required value="<?= $linha['email'] ?>"><br><br>
        Senha: <input type="password" name="senha" required value="<?= $linha['senha'] ?>"><br><br>
        <a data-toggle="modal" data-target="#modalAltSenha" href="#"><input type="button" value="Alterar Senha"></a>
        <input type="submit" class="btn-primary" value="Atualizar">
        <a href="form_conf.php"><input type="button" class="btn-dark" value="Cancelar"></a>
    </form>
    <br><br>
    <a data-toggle="modal" data-target="#modalDesativarP" href="#"><input type="button" class="btn-secondary" value="Excluir perfil" /></a>
</div>
<?php
include './template/rodape_especial.php';
?>
