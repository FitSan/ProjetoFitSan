<?php
$pagina = "Busca";
require_once './template/cabecalho.php';

if (isset($_POST['busca'])){
    $busca = $_POST['busca'];
    $busca = trim($busca);
    $_SESSION['busca'] = $busca;
} elseif (isset($_SESSION['busca'])){
    $busca = $_SESSION['busca'];
}
if (!empty($busca) && (strlen($busca) >= 3)) {
    $busca = preg_replace('{[^\\w\\d]+}', '%', $busca); //expressão regular
    $busca = ('%' . $busca . '%');
    if (tipoLogado('profissional')) {
        $query = "select * from usuario u left join vinculo v on v.aluno_id = u.id and v.profissional_id = $_SESSION[id] where u.status = 'ativado' and u.tipo_id=1 and concat(u.nome, ' ' , u.sobrenome) like '$busca'";
        $usuario_busca = 'aluno_id';
    } else {
        $query = "select * from usuario u left join vinculo v on v.profissional_id = u.id and v.aluno_id = $_SESSION[id] where u.status = 'ativado' and u.tipo_id=2 and concat(u.nome, ' ' , u.sobrenome) like '$busca'";
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
    ");
} else {
    $dicas = $usuarios = null;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $pagina ?></h1>
    </section>
 
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Usuários</h3>
            </div>

            <div class="box-body">
                <?php
                if (empty($usuarios)) {
                    echo 'Usuário não encontrado';
                } else {
                    ?>
                    <table id="buscauser" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Nome</th> 
                                <th>E-mail</th>
                                <th>Status</th>                         
                            </tr>  
                        </thead>
                        
                            <tbody><?php
                        foreach ($usuarios as $linha) {
                            ?>
                                <tr>
                                    <td><a href="<?=URL_SITE?>perfil_externo.php?id=<?= $linha['id'] ?>"><?= $linha['nome'] . ' ' . $linha['sobrenome'] ?></a></td>
                                    <td><?= $linha['email'] ?></td>
                                    <?php
                                    if ($linha[$usuario_busca] == $_SESSION['id']) {
                                        ?>
                                        <td><a href="<?=URL_SITE?>desvincular.php?id=<?= $linha['id'] ?>"><span class="label label-danger">Deixar de seguir</span></a></td>               
                                        <?php
                                    } elseif ($linha['status'] === 'aprovado') {
                                        ?>
                                        <td><a href="<?=URL_SITE?>desvincular.php?id=<?= $linha['id'] ?>"><span class="label label-danger">Deixar de seguir</span></a></td>                
                                        <?php
                                    } elseif ($linha['status'] === 'espera') {
                                        if (tipoLogado($linha['solicitante'])) {
                                            ?>
                                            <td><span class="label label-warning">Aguardando...</span></td>                
                                            <?php
                                        } else {
                                            ?>
                                            <td><a href="<?=URL_SITE?>status_vinculo.php?id=<?= $linha['id'] ?>&status=aprovado"><span class="label label-success">Aceitar</span></a> <a href="status_vinculo.php?id=<?= $linha['id'] ?>&status=negado"><span class="label label-danger">Negar</span></a></td>                
                                            <?php
                                        }
                                    } else {
                                        ?>
                                            <td><a href="<?=URL_SITE?>vincular.php?id=<?= $linha['id'] ?>"><span class="label label-primary">Seguir</span></a></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                        <?php
                }
                ?>
                    
                <?php
                if (empty($dicas)) {
                    echo 'Dica não encontrada';
                } else {
                    ?>
                    <table id="buscadicas" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Nome</th> 
                                <th style="width: 10px">Data</th>                        
                            </tr>  
                        </thead>
                        
                            <tbody><?php
                        foreach ($dicas as $linha) {
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($linha['profissional_nome']) ?></td>
                                    <td style="width: 10px"><?= htmlspecialchars(date('d/m/Y H:i:s', dataParse($linha['data_envio']))) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?= nl2br(htmlspecialchars($linha['texto'])) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                        <?php
                }
                ?>

            </div>
        </div>
    </section>
<!--</div>-->

<?php
include './template/rodape_especial.php';

