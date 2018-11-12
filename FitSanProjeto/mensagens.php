<?php
$pagina = "Mensagens";
require_once './template/cabecalho.php';

if (!tipoLogado("aluno", "profissional")){
    header('Location: '.URL_SITE.'pagina1.php');
    exit;
}

// Iniciando variraveis
$acao = (!empty($_GET['acao']) ? $_GET['acao'] : 'consultar'); 
$id = (!empty($_GET['id']) ? $_GET['id'] : null); 
$destinatario = (!empty($_GET['destinatario']) ? $_GET['destinatario'] : null); 
$erros = array();

//referente a inclusão/alteração no banco.
if ($acao == 'incluir'){
    if (!empty($_POST)) {
        $texto = (!empty($_POST['texto']) ? $_POST['texto'] : null);
        $usuario = (!empty($_POST['usuario']) ? $_POST['usuario'] : $destinatario);
        if (empty($texto)) $erros[] = "Preencha a mensagem.";
        if (empty($usuario)) $erros[] = "Preencha o Texto.";
    }
    if (empty($erros) && !empty($texto) && !empty($usuario)) {
        dbquery("
            insert into chat (
                datahora,
                status,
                origem,
                aluno_id,
                profissional_id,
                mensagem
            ) values (
                now(),
                'pendente',
                " . mysqliEscaparTexto(getTipo()) . ",
                " . mysqliEscaparTexto(tipoLogado("aluno") ? $_SESSION['id'] : $usuario) . ",
                " . mysqliEscaparTexto(tipoLogado("profissional") ? $_SESSION['id'] : $usuario) . ",
                " . mysqliEscaparTexto($texto) . "
            )
        ");
        criarNotificacao('INFO',
            'Você tem uma nova mensagem de ' . $_SESSION['nome'] . " " . $_SESSION['sobrenome']  . '<br><a href="'.URL_SITE.'mensagens.php?id='.$_SESSION['id'].'">Lêr</a>',
            tipoLogado('aluno') ? $usuario : null,
            tipoLogado('profissional') ? $usuario : null,
            [
                'aluno_id' => (tipoLogado("aluno") ? $_SESSION['id'] : $usuario),
                'profissional_id' => (tipoLogado("profissional") ? $_SESSION['id'] : $usuario),
                'table' => 'chat',
            ]
        );
        header('Location: '.url_param_add(null, array('acao' => null, 'id' => null)));
        exit();
    }
} elseif ($acao == 'excluir') {
    if ($id !== null) {
        $query = "delete from chat where id = " . mysqliEscaparTexto($id);
        mysqli_query($conexao, $query) or die_mysql($query, __FILE__, __LINE__);
    }
    header('Location: '.url_param_add(null, array('acao' => null, 'id' => null)));
    exit();
}

if (tipoLogado("profissional")){
    $campo_origem = 'profissional';
    $campo_destino = 'aluno';
} else {
    $campo_origem = 'aluno';
    $campo_destino = 'profissional';
}

$query = "select
    u.*,
    (select count(c.id) from chat c where c.aluno_id = v.aluno_id and c.profissional_id = v.profissional_id) as mensagens
from
    vinculo v join
    usuario u on u.id = v.{$campo_destino}_id
where
    u.status = 'ativado' and
    v.status = 'aprovado' and
    v.{$campo_origem}_id = " . mysqliEscaparTexto($_SESSION['id']) . "
order by
    case
        when u.id = " . mysqliEscaparTexto($destinatario) . " then 2
        when mensagens > 0 then 1
        else 0
    end desc,
    u.nome
";
$usuarios = dbquery($query);
if (empty($usuarios)) $usuarios = array();

//monta o sql de consulta
$query = array();
$query['from'] = "
    chat c left join
    usuario a on a.id = c.aluno_id left join
    usuario p on p.id = c.profissional_id
";
$query['where'] = array(
    "c.{$campo_origem}_id = " . mysqliEscaparTexto($_SESSION['id']),
    "c.{$campo_destino}_id = " . mysqliEscaparTexto($destinatario),
);

//referente à paginação
$query['select'] = array(
    'count(*) as total',
);
$pagina = array(
    'total' => intval(dbquery($query, 'col', 'total')),
    'quantidade' => (!empty($_GET['quantidade']) ? $_GET['quantidade'] : 10),
    'pagina' => (!empty($_GET['pagina']) ? $_GET['pagina'] : 1),
);
$pagina['offset'] = (($pagina['pagina'] - 1) * $pagina['quantidade']);
$pagina['paginas'] = ceil($pagina['total'] / $pagina['quantidade']);

//referente à consulta
$query['select'] = array(
    'c.*',
    'a.nome as aluno_nome',
    'a.sobrenome as aluno_sobrenome',
    'a.foto as aluno_foto',
    'p.nome as profissional_nome',
    'p.sobrenome as profissional_sobrenome',
    'p.foto as profissional_foto',
);
$query['order'] = array(
    'c.datahora',
);
$query['outro'] = "
limit
    ". $pagina['quantidade'] . "
offset
    " . $pagina['offset']
;
$resultado = dbquery($query);


?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Mensagens</h1>
    </section><br>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Destinatários com mensagem</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach ($usuarios as $value){ if (!$value['mensagens'] && ($value['id'] != $destinatario)) continue; ?>
                        <li value="<?php echo htmlspecialchars($value['id']); ?>"><a href="<?=url_param_add(null, array('destinatario' => $value['id'])) ?>"><?php
                        if ($value['id'] == $destinatario) echo '<strong>';
                        echo htmlspecialchars($value['nome'] . ' ' . $value['sobrenome']);
                        if ($value['id'] == $destinatario) echo '</strong>';
                        ?><span class="badge bg-aqua"><?php echo htmlspecialchars($value['mensagens']); ?></span></a></li>
                        <?php } ?>      
                        
                    </ul>
                </div>
            </div>
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Destinatários novos</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach ($usuarios as $value){ if ($value['mensagens'] || ($value['id'] == $destinatario)) continue; ?>
                        <li value="<?php echo htmlspecialchars($value['id']); ?>"><a href="<?=url_param_add(null, array('destinatario' => $value['id'])) ?>"><?php
                        if ($value['id'] == $destinatario) echo '<strong>';
                        echo htmlspecialchars($value['nome'] . ' ' . $value['sobrenome']);
                        if ($value['id'] == $destinatario) echo '</strong>';
                        ?></a></li>
                        <?php } ?>      
                        
                    </ul>
                </div>
            </div>
            
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Mensagem</h3>
               
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="box-header"><form class="form-horizontal" action="<?=url_param_add(null, array('acao' => 'incluir')) ?>" method="POST" enctype="multipart/form-data">
                         <textarea class="form-control" name="texto" rows="6" cols="50"></textarea>  
                        
                        <div class="pull-right">
                            <br>
                            <button type="reset" class="btn btn-default" > Cancelar</button>
                            <button type="submit" class="btn btn-primary" ><i class="fa fa-paper-plane-o"></i> Enviar</button>
                        </div>  
                    </div>
                </div>
            </div>
    </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
<?php if ($destinatario){ ?>
                    <h3 class="box-title">Conversa entre <?php echo htmlspecialchars($_SESSION['nome'] . ' ' . $_SESSION['sobrenome']) ?> e <?php echo htmlspecialchars($usuarios[0]['nome'] . ' ' . $usuarios[0]['sobrenome']) ?></h3>
<?php } else { ?>
                    <h3 class="box-title">Seleção</h3>
<?php } ?>
                    <div class="box-body"><br>
                    <?php if (!empty($resultado)){ 
                        
                        if (isset($_GET['notificacao'])) {
                            echo leituraNotificacao($_GET['notificacao']);
                            echo '<script>window.location = ' . json_encode(url_param_add(url_current(), 'notificacao', null)) . ';</script>';
                            exit;
                        }
                        ?>
                        
                        
                    <ul class="timeline timeline-inverse">
                        <?php
                            $dataanterior = '';
                            foreach ($resultado as $linha) {
                            $dataatual = date('d/m/Y', dataParse($linha['datahora']));
                            if ($dataanterior != $dataatual){
                                ?> 
                        <li class="time-label">
                            <span class="bg-red">
                                <?= $dataatual ?>
                            </span>
                        </li>
                        <?php
            $dataanterior = $dataatual;
        }
        ?> 
                        <li>
                                    <i class="fa fa fa-weixin bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> <?= date('H:i:s', dataParse($linha['datahora'])) ?></span>
                                        <h3 class="user-block" style="padding: 10px">
                                            <img class="img-circle img-bordered-sm" src="<?php echo htmlspecialchars(!empty($linha[$linha['origem'] . '_foto']) ? $linha[$linha['origem'] . '_foto'] : URL_SITE . 'img/user-avatar-placeholder.png'); ?>" alt="User profile picture">
                                            <span class="username"><br>
                                                <?php echo htmlspecialchars($linha[$linha['origem'] . '_nome'] . ' ' . $linha[$linha['origem'] . '_sobrenome']); ?> 
                                            </span>
                                        </h3>
                                        <hr style="height:1px; border:none; color:#ccc; background-color:#ccc; margin-top: 0px; margin-bottom: 0px;"/>

                                        <div class="timeline-body">
                                            <?= nl2br(htmlentities($linha['mensagem'])) ?>
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-social-icon" href="<?= url_param_add(null, array('acao' => 'excluir', 'id' => $linha['id'])) ?>">
                                               <i class="fa fa-trash-o"></i>    
                                            </a>
                                        </div>
                                    </div>
                                </li> 
        <?php
}
        ?>
        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>
                    </div>
    </ul>
                
                    
                        
                        
                          
              
<?php if ($paginacao['paginas'] > 1){ ?>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li class="<?php echo (($paginacao['pagina'] == 1) ? 'disabled' : '') ?>"><a href="<?=url_param_add(null, array('pagina' => null))?>">&laquo;</a></li>
<?php for ($pag = 1; $pag <= $paginacao['paginas']; $pag++){ ?>
                <li class="<?php echo (($paginacao['pagina'] == $pag) ? 'active' : '') ?>"><a href="<?=url_param_add(null, array('pagina' => $pag))?>"><?php echo $pag ?></a></li>
<?php } ?>
                <li class="<?php echo (($paginacao['pagina'] == $paginacao['paginas']) ? 'disabled' : '') ?>"><a href="<?=url_param_add(null, array('pagina' => $paginacao['paginas']))?>">&raquo;</a></li>
            </ul>
        </div>
<?php } ?>

<?php } elseif (!$destinatario){ ?>
<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Selecione um destinatário ao lado.</b></h3></div>
<?php } else { ?>
<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center"><h3><b>Não foi enviada nenhuma mensagem ainda.</b></h3></div>
<?php } ?>
                            
                      
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>


<?php
require_once './template/rodape_especial.php';
