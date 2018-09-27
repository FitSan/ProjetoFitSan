<?php
$pagina = "Novos Exercícios";
require_once './template/cabecalho.php';


?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Novos exercícios</h1>
    </section>
    <br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Insira aqui um novo exercício</h3>
            <br><br>
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Nome: </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="novo_exercicio" placeholder="Exercício ...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Descrição: </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5" placeholder="Descreva seu exercício ..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">

                        <span class="btn  btn-file center-block"><span>
                                <img src="img/upload_img.png" height="40"></span>
                            <input type="file" name="imagens[]" multiple="multiple" hidden accept="image/png, image/jpeg"> <b>Foto</b></span>

                    </div>

                    <div class="box-footer">                        
                        <button type="reset" class="btn btn-default">Limpar</button>                        
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <a href="planilha_dados.php" class="btn btn-danger pull-right">Voltar</a><br><br>
                        
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px"><input type="checkbox"></th>
                <th>Nome</th>
                <th>Descrição</th>
                <th style="width: 40px"><i class="fa fa-image"></i></th>
                <th style="width: 40px"><i class="fa fa-arrow-up"></i></th>
                <th style="width: 40px"><i class="fa fa-trash-o"></i></th>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Rosca Alternada</td>
                <td><p>Fique em pé, com os pés ligeiramente afastados, joelhos levemente flexionados, e abdominal contraído.
                        Segure um halter em cada mão, mantendo a palma da mão para frente. Fixe a posição dos cotovelos na lateral de seu tronco 
                        e mantenha os pesos em frente à sua coxa.</p></td>
                <td><a href="#"><i class="fa fa-image"></i></a></td>
                <td><a href="#"><i class="fa fa-arrow-up"></i></a></td>
                <td><a href="#"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Remada Unilateral</td>
                <td><p>Segure um halter em uma das mãos e ajoelhe-se no banco com o joelho oposto. 
                        Incline-se para a frente e mantenha as costas paralelas ao chão, apoiando o peso do corpo sobre sua mão livre.
                        Mantenha o cotovelo do braço que segura o peso levemente flexionado.</p>
                </td>
                <td><a href="#"><i class="fa fa-image"></i></a></td>
                <td><a href="#"><i class="fa fa-arrow-up"></i></a></td>
                <td><a href="#"><i class="fa fa-trash-o"></i></a></td>
            </tr>
        </table>
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
    </div>       
</div>




<?php
require_once './template/rodape_especial.php';
?>
