<?php
    $pagina = "Cadastro";
    require_once './template/cabecalho1.php';
?>
        <h1>Cadastre-se</h1><br>        
        <form method="post" action="cadastrar.php">
            Nome: <input type="text" name="nome" required style="text-transform: capitalize" placeholder="Digite seu nome"><br><br>
            Sobrenome: <input type="text" name="sobrenome" required style="text-transform: capitalize" placeholder="Digite seu sobrenome"><br><br>
            E-mail: <input type="email" name="email" required placeholder="Digite seu e-mail"><br><br>
            Senha: <input type="password" name="senha" required placeholder="Digite sua senha"><br><br>
            Confirmar senha: <input type="password" name="confSenha" required placeholder="Confirme sua senha"><br><br>
            <?php
              include './bancodedados/conectar.php';
              $query = "select * from tipo_usuario";
              
              $resultado = mysqli_query($conexao, $query) or die('ERRO: '.mysqli_error($conexao).PHP_EOL.$query.PHP_EOL.print_r(debug_backtrace(), true));
              ?>
            Tipo: <select name="tipo_id">
              <?php
              while ($linha = mysqli_fetch_array($resultado)){
                  ?>               
                <option value="<?=$linha['id']?>"><?= ucfirst($linha['tipo'])?></option>
                
            <?php
              }
            ?>
            </select><br><br>
            <input type="submit" value="Inserir">
            <a href="form_login.php"><input type="button" value="Cancelar"></a>
        </form>
    <?php
            
            include './template/rodape.php';
