$(document).ready(function(){
    $('a[data-confirm]').click(function(ev){
       var href = $(this).attr('href');
       if(!$('#confirm-delete').length){
           $('body').append('<div class="modal" id="confirm-delete" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Excluir dica</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body"><p> Você tem certeza que deseja excluir sua dica? Deseja continuar?</p></div><div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Não</button><a class="btn btn-info" role="button" id="dataConfirmOK">Sim</a></div></div></div></div>');
       }
       $('#dataConfirmOK').attr('href', href);
       $('#confirm-delete').modal({show: true});
       return false;
    });
});


