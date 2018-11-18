<?php
$pagina = "Usuarios";
require_once './template/cabecalho.php';
require_once './template/menu.php';

if (!tipoLogado("admin")){
    header('Location: '.URL_SITE.'pagina1.php');
    exit;
}

// Iniciando variraveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); //obtendo ação
$id = (!empty($_GET['id']) ? $_GET['id'] : null); //obtendo id de alteração
$erros = array();

if (($acao == 'status') || ($acao == 'excluir')) {
    if ($id !== null) {
        if ($acao == 'status'){
            $query_status = "select status from usuario where id= " . mysqliEscaparTexto($id);
            $resultado_status = mysqli_query($conexao, $query_status) or die_mysql($query_status, __FILE__, __LINE__);
            $linha_status = ($resultado_status?mysqli_fetch_array($resultado_status):array());
            $status = (isset($linha_status['status']) ? $linha_status['status'] : 'ativado');
            if (!strcasecmp($status, 'ativado')){
                $status = 'desativado';
            } elseif (!strcasecmp($status, 'desativado')){
                $status = 'ativado';
            }
        } else {
            $status = 'excluido';
        }
        $query = "update usuario set status = " . mysqliEscaparTexto($status) . " where id= " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
    }
    header('Location: '.URL_SITE.basename(__FILE__));
    exit();
}

$query_pagina = "
    select
        count(u.id) as total
    from
        usuario u left join
        tipo_usuario t on t.id = u.tipo_id
    where
        u.tipo_id is not null and u.status <> 'excluido'
";
$resultado_pagina = mysqli_query($conexao, $query_pagina) or die_mysql($query_pagina, __FILE__, __LINE__);
$pagina = ($resultado_pagina?mysqli_fetch_array($resultado_pagina):array());
$pagina = array_merge(array(
    'total' => 0,
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 2),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
), array_map('intval', (array)$pagina));
$pagina['offset'] = (($pagina['pagina'] - 1) * $pagina['quantidade']);
$pagina['paginas'] = ceil($pagina['total'] / $pagina['quantidade']);



$query = "
    select
        u.*,
        t.tipo
    from
        usuario u left join
        tipo_usuario t on t.id = u.tipo_id
    where
        u.tipo_id is not null and u.status <> 'excluido'
    order by
        u.nome
    limit
        ". $pagina['quantidade'] . "
    offset
         " . $pagina['offset']
        ;
$resultado = mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 style="padding: 10px">Usuários</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Gerencie os usuários</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nome</th>
                                    <th>E-Mail</th>
                                    <th>Cadastrado em</th>
                                    <th>Data de Nascimento</th>
                                    <th>Sexo</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Ações</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($linha = mysqli_fetch_array($resultado)) {
                                    ?>
                                <tr>
                                        <td style="width: 100px"><img class="profile-user-img img-responsive img-circle" src="<?= htmlspecialchars(!empty($linha['foto']) ? $linha['foto'] : 'img/user-avatar-placeholder.png') ?>" alt="User profile picture"></td>
                                        <td style="width: 150px"><?= $linha['nome'] ?> <?= $linha['sobrenome'] ?></td>
                                        <td style="width: 300px"><?= $linha['email'] ?></td>
                                        <td style="width: 300px"><?= date('d/m/Y H:i:s', dataParse($linha['datahora']))  ?></td>
                                        <td style="width: 300px"><?= (!empty($linha['datanasc']) ? date('d/m/Y', dataParse($linha['datanasc'])) : '(Não definido)') ?></td>
                                        <td style="width: 300px"><?= $linha['sexo'] ?></td>
                                        <td style="width: 300px"><?= $linha['tipo'] ?></td>
                                        <td style="width: 50px"><?php
                                                if ($linha['status'] === 'ativado') {
                                                    ?><a href="<?=URL_SITE?><?php echo basename(__FILE__) ?>?acao=status&id=<?= $linha['id'] ?>">Ativado</a><?php
                                                } else {
                                                    ?><a href="<?=URL_SITE?><?php echo basename(__FILE__) ?>?acao=status&id=<?= $linha['id'] ?>">Desativado</a><?php
                                                }
                                                ?></td>
                                            <td style="width: 50px">
                                                <a href="<?=URL_SITE?><?php echo basename(__FILE__) ?>?acao=excluir&id=<?= $linha['id'] ?>">Excluir</a>
                                            </td>
                                </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                            <?php if ($pagina['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($pagina['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?=URL_SITE?><?php echo basename(__FILE__) ?>">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $pagina['paginas']; $pag++){ ?>
                <li class="<?php echo (($pagina['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?=URL_SITE?><?php echo basename(__FILE__) ?>?pagina=<?php echo $pag ?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($pagina['pagina'] == $pagina['paginas']) ? 'disabled' : '') ?>"><a href="<?=URL_SITE?><?php echo basename(__FILE__) ?>?pagina=<?php echo $pagina['paginas'] ?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
<!--</div>-->


<?php
include './template/rodape_especial.php';


