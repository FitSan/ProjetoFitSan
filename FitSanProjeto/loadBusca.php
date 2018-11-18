<?php
require_once('autenticacao.php');

$page = $_POST['page'];
$qntd = 10;
$inicio = $qntd * $page;

if (isset($_POST['busca'])) {
    $busca = $_POST['busca'];
    $busca = trim($busca);
    $_SESSION['busca'] = $busca;
} elseif (isset($_SESSION['busca'])) {
    $busca = $_SESSION['busca'];
}
if (!empty($busca) && (strlen($busca) >= 3)) {
    $busca = preg_replace('{[^\\w\\d]+}', '%', $busca); //expressão regular
    $busca = ('%' . $busca . '%');
    if (tipoLogado('profissional')) {
        $query = "select * from usuario u left join vinculo v on v.aluno_id = u.id and v.profissional_id = $_SESSION[id] where u.status = 'ativado' and u.tipo_id=1 and concat(u.nome, ' ' , u.sobrenome) like '$busca' LIMIT $inicio,$qntd";
        $usuario_busca = 'aluno_id';
    } else {
        $query = "select * from usuario u left join vinculo v on v.profissional_id = u.id and v.aluno_id = $_SESSION[id] where u.status = 'ativado' and u.tipo_id=2 and concat(u.nome, ' ' , u.sobrenome) like '$busca' LIMIT $inicio,$qntd";
        $usuario_busca = 'profissional_id';
    }
    $usuarios = dbquery($query);
    $dicas = dbquery("
    select
        *
    from
        dica
    where
        texto like '$busca' or
        profissional_nome like '$busca'
            order by data_envio desc
    LIMIT $inicio,$qntd");
} else {
    $usuarios = null;
}
?>

<?php
if (empty($usuarios) && $page == 0) {
    echo '<thead><tr><th>Usuários</th></tr></thead><tbody><tr><td><b style="padding: 6px;">Usuário não encontrado</b></td></tbody>';
} else if (empty($dicas) && $page > 0) {
    ?>
    <?php
} else {
    if ($page == 0) {
        ?>
        

            <thead>
                <tr>
                    <td colspan="3"><h3>Usuários</h3></td>
                </tr>
                <tr>
                    <th>Nome</th> 
                    <th>E-mail</th>
                    <th>Status</th>                         
                </tr>  
            </thead>

            <?php }
        ?>
            
                <?php
                foreach ($usuarios as $linha) {
                    ?>
            <tbody>
                    <tr>
                        <td><a href="<?= URL_SITE ?>perfil_externo.php?id=<?= $linha['id'] ?>"><?= $linha['nome'] . ' ' . $linha['sobrenome'] ?></a></td>
                        <td><?= $linha['email'] ?></td>
                        <?php
                        if ($linha[$usuario_busca] == $_SESSION['id']) {
                            ?>
                            <td><a href="<?= URL_SITE ?>desvincular.php?id=<?= $linha['id'] ?>"><span class="label label-danger">Deixar de seguir</span></a></td>               
                            <?php
                        } elseif ($linha['status'] === 'aprovado') {
                            ?>
                            <td><a href="<?= URL_SITE ?>desvincular.php?id=<?= $linha['id'] ?>"><span class="label label-danger">Deixar de seguir</span></a></td>                
                            <?php
                        } elseif ($linha['status'] === 'espera') {
                            if (tipoLogado($linha['solicitante'])) {
                                ?>
                                <td><span class="label label-warning">Aguardando...</span></td>                
                                <?php
                            } else {
                                ?>
                                <td><a href="<?= URL_SITE ?>status_vinculo.php?id=<?= $linha['id'] ?>&status=aprovado"><span class="label label-success">Aceitar</span></a> <a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=negado"><span class="label label-danger">Negar</span></a></td>                
                                <?php
                            }
                        } else {
                            ?>
                            <td><a href="<?= URL_SITE ?>vincular.php?id=<?= $linha['id'] ?>"><span class="label label-primary">Seguir</span></a></td>
                            <?php
                        }
                        ?>
                    </tr>                    
            </tbody>
                    <?php
                }
            }
            ?>

            