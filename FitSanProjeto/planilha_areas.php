<?php
$pagina = "Áreas";
require_once './template/cabecalho.php';


?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Áreas de atuação</h1>
    </section>
    <br>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Insira aqui as áreas de atuação</h3>
            <br><br>
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label  class="col-sm-1 control-label">Nome: </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="planilha_area" placeholder="Área de atuação ...">
                        </div>
                    </div>                                      

                    <div class="box-footer">                        
                        <button type="reset" class="btn btn-default">Limpar</button>                        
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <a href="planilha_dados.php" class="btn btn-danger pull-right">Voltar</a><br><br>
<!--                        <button type="submit" class="btn btn-danger pull-right">Voltar para planilha</button>-->
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        <table class="table table-bordered table-striped planilha">
            <thead>
            <tr>
                <th style="width: 10px"><input type="checkbox"></th>
                <th>Nome</th>
                <th style="width: 40px"><i class="fa fa-arrow-up"></i></th>
                <th style="width: 40px"><i class="fa fa-trash-o"></i></th>
            </tr>
            </thead>
            <tr>
                <td><input type="checkbox"></td>
                <td>Cárdio</td>
                <td><a href="#"><i class="fa fa-arrow-up"></i></a></td>
                <td><a href="#"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Remada Unilateral</td>
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
