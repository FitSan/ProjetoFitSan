<?php
require_once('autenticacao.php');

$page = $_POST['page'];
$qntd = 5;
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
    $dicas = null;
}
?>

            <?php
            if (empty($dicas) && $page == 0) {
                echo '<thead><tr><th>Dicas</th></tr></thead><tbody><tr><td><b style="padding: 6px;">Dica não encontrada</b></td></tbody>';
            } else if (empty($dicas) && $page > 0) {
                ?>
        <?php
    } else {
        if ($page == 0) {
            ?>                    
        
                <thead>
                    <tr>
                        <th colspan="2"><h3>Dicas</h3></th>
                    </tr>
                    <tr>
                        <th>Nome</th> 
                        <th style="width: 10px">Data</th>                        
                    </tr>  
                </thead>

        <?php }
        ?> 
                    <?php
                    foreach ($dicas as $linha) {
                        ?>
                <tbody>
                        <tr>
                            <td><?= htmlspecialchars($linha['profissional_nome']) ?></td>
                            <td style="width: 10px"><?= htmlspecialchars(date('d/m/Y H:i:s', dataParse($linha['data_envio']))) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= nl2br(htmlspecialchars($linha['texto'])) ?>
                                <?php
                                $query_dica = "select * from upload_dica where dica_id = " . htmlspecialchars($linha['id']);
                                $resultado_upload = mysqli_query($conexao, $query_dica);
                                if (mysqli_num_rows($resultado_upload) > 0) {
                                    $count = 0;
                                    while ($linha_upload = mysqli_fetch_array($resultado_upload)) {
                                        if (htmlspecialchars($linha_upload['tipo']) != 'img') {
                                            if (htmlspecialchars($linha_upload['tipo']) == 'vid') {
                                                ?> 
                                <div style="max-width: 800px; margin: 0 auto; "><div class="embed-container"><iframe  src="<?= htmlspecialchars($linha_upload['nome_arq']) ?>" frameborder="0" allowfullscreen></iframe></div>                                  
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div><a href="<?= htmlspecialchars($linha_upload['nome_arq']) ?>"  target="_blank"><?= htmlspecialchars($linha_upload['nome_arq']) ?></a>
                                                        <?php
                                                    }
                                                    $img = false;
                                                } else {
                                                    $count += 1;
                                                    $img = true;
                                                    $id = htmlspecialchars($linha['id']);
                                                    if ($count == 1) {
                                                        ?>
                                                        <div class="wrap" id="<?= $id ?>">
                                                            <section class="container galery-container">
                    <?php }
                    ?>  
                                                            <div class="mySlides" <?= ($count > 1) ? ' style="display: none;"' : '' ?>><img class="imgslide img img-responsive " src="<?= URL_SITE ?>uploads/dicas/<?= htmlspecialchars($linha_upload['nome_arq']) ?>" style="padding: 5px; margin: 0 auto;"></div>                

                                                            <?php
                                                        }
                                                    } if ($img) {
                                                        if ($count > 1) {
                                                            ?>
                                                            <a class="menos_img" onclick="plusSlides(-1, <?= $id ?>)">&#10094;</a>
                                                            <a class="mais_img" onclick="plusSlides(1, <?= $id ?>)">&#10095;</a>
                                                    <?php } ?>
                                                    </section>
                                            <?php } ?>                                                
                                            </div>
                                        <?php } ?>   </td>
                                        </tr>
                                        </tbody>
                                        <?php
                                    }
                                }
                                ?>
                                                    