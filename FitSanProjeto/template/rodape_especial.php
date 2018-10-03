<br>

</div>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="">FitSan</a>.</strong> Todos os direitos reservados.
</footer>


<!--Modal sair-->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deseja sair?</h4>
            </div>
            <div class="modal-body">
                <p>Não saia agora! Treine mais um pouco&hellip;<br> Tem certeza que quer continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Não</button>
                <a class="btn btn-primary" href="http://localhost/FitSan/logout.php" role="button">Sim</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Modal SALVAR -->
<div class="modal fade" id="modal-salvar">

    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Insira sua Senha para Atualizar!</h4>
            </div>
            <form action="./atualizar_conf.php" method="post" >
                
                <input type="hidden" id="novo_nome" name="novo_nome" >
                
            <div class="login-box-body">
                <label class="sr-only" for="insira_senha">Senha</label>
                <input type="password" name="insira_senha" class="form-control" placeholder=" Senha">
                <span class="glyphicon  form-control-feedback"></span>
            </div>
                


            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-primary">Pronto</button>
            </div>
            
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>










<div class="modal" id="modalDesativarP" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Excluir Perfil</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span> 

                </button>

            </div>

            <div class="modal-body">
                <p>Não faça isso! Temos certeza que sua experiência <i>fit</i> não chegou ao fim. Tem certeza que quer continuar?</p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <a class="btn btn-info" href="http://localhost/FitSan/desativarP.php" role="button">Sim</a>

            </div>

        </div>
    </div>



</div>
<!--<div class="modal" id="modalLogin" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Erro</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span> 
                    
                </button>
                
            </div>
            
            <div class="modal-body">
                <p>Dados não conferem!</p>
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tente novamente</button>                
                
            </div>
            
        </div>
    </div>
        
    
    
</div>-->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->


<div class="modal" id="modalAltSenha" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmar Senha Atual</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span> 

                </button>

            </div>

            <div class="modal-body">
                <form>
                    Senha atual: <input type="text" name="senha" required>    
                    Nova senha: <input type="text" name="senhaAlt" required>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <a class="btn btn-info" href="http://localhost/FitSan/confirmSenha.php" role="button">Sim</a>

            </div>

        </div>
    </div>  
</div>


<div class="modal fade" id="editar-dica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Dica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="alterar_dica.php">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Data:</label>
                        <input type="text" class="form-control" id="data_envio" name="data_envio" readonly value="">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Dica:</label>
                        <textarea class="form-control" id="texto" name="texto"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Alterar</button>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</div>


<div class="modal" id="excluir-dica" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir dica</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> Você tem certeza que deseja excluir sua dica? Deseja continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <form method="post" action="excluirDica.php">
                    <input type="hidden" id="id" name="id">
                    <button type="submit" class="btn btn-primary">Sim</button>
                </form>
            </div>
        </div>
    </div>
</div>    

<!--<div class="modal fade" id="erro-dica" role="dialog">
    <div class="modal-dialog">
    
       Modal content
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Erro</h4>
        </div>
        <div class="modal-body">
          <p>Campo vazio! Formulário não enviado.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>-->





<?php //if($erro){ ?>   
<!--<script>
        $(document).ready(function(){
            $("#erro-dica").modal();
        });
</script>-->
<?php
//}
//
?>
</div>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="bower_components/ckeditor/ckeditor.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>


<script>
  $(function () {
    $('.planilha').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    })
  })
</script>


<script>
  $(function () {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass   : 'iradio_flat-green'
    })
  })
</script>




<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>



<script type="text/javascript">
    $('#datanasc').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        endDate: '-3d'
    });
</script>
<script type="text/javascript">
    $('#editar-dica').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')
        var data_envio = button.data('data')
        var texto = button.data('texto')
        //// Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #id').val(id)
        modal.find('.modal-body #data_envio').val(data_envio)
        modal.find('.modal-body textarea').val(texto)
    })
</script>
<script type="text/javascript">
    $('#excluir-dica').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')
        //// Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-footer #id').val(id)
    })
</script>
<script>
    function hideUpload(up, check) {
        var label = 'label'+up;
    // Get the checkbox    
    if (check.checked === true) {
        document.getElementById(up).style.display = "none";   
        document.getElementById(label).innerHTML="+";
//        $(label' b').text('+');
	}else{
            document.getElementById(up).style.display = "inline";
            document.getElementById(label).innerHTML="x";
//            $(label' b').text('X');
        }
  }
</script>


<script>
  $(function () {
    $('.duplicador').each(function(){
        var box = $(this);
        var modelo = box.find('.duplicador-item').eq(0).clone(true);
        function duplicar(){
            var este = $(this);
            var novo = modelo.clone(true).appendTo(box);
            novo.find('.duplicador-mais').on('click', duplicar).find('i').removeClass('fa-minus').addClass('fa-plus');
            novo.find(':input').val('');
            este.off('click').on('click', remover).find('i').removeClass('fa-plus').addClass('fa-minus');
        }
        function remover(){
            var este = $(this);
            este.parents('.duplicador-item').remove();
        }
        var botoes = box.find('.duplicador-mais');
        botoes.each(function(i){
            var este = $(this);
            if (i >= (botoes.length - 1)){
                este.on('click', duplicar).find('i').removeClass('fa-minus').addClass('fa-plus');
            } else {
                este.on('click', remover).find('i').removeClass('fa-plus').addClass('fa-minus');
            }
        });
    });
  });
</script>

<script>
    $(function(){
        if (typeof(grupomusccard) == 'undefined') return;
        var grupo = $('#adicionar_novo select[name="areas"]');
        var exercicios = $('#adicionar_novo select[name="exercicios"]');
        $.each(grupomusccard, function(key, val){
            $('<option/>').val(val.id).text(val.nome).appendTo(grupo);
        });
        grupo.on('change keyup', function(){
            var id = $(this).val();
            exercicios.find('option').not('[value=""]').remove();
            if (id == '') return;
            $.each(grupomusccard[id].exercicios, function(key, val){
                $('<option/>').val(val.id).text(val.nome).appendTo(exercicios);
            });
        }).change();
    })
</script>

</body>
</html>
