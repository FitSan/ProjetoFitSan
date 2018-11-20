<?php
require_once './autenticacao.php';

$output = '';
$itens_por_pag = 5;
if(isset($_GET['pag'])){
    $pagina = intval($_GET['pag']);
}else{
    $pagina = 1;
}
$offset = ($pagina-1)*$itens_por_pag;
if(isset($_POST['meta_id'])){
    if($_POST['meta_id']!=''){
        $query_meta_id = "select * from meta where id=".mysqliEscaparTexto($_POST[meta_id]);
        $query_dados = "select * from dados_meta where meta_id='".$_POST['meta_id']."' order by data_add LIMIT $offset, $itens_por_pag";
        $query_dados_all = "select * from dados_meta where meta_id='".$_POST['meta_id']."' order by data_add";
        
        $resultado_meta_id = mysqli_query($conexao, $query_meta_id);
        $linha_meta_id = mysqli_fetch_array($resultado_meta_id);
        $resultado_dados = mysqli_query($conexao, $query_dados);
        $resultado_dados_all = mysqli_query($conexao, $query_dados_all);
        
        $num_dados = mysqli_num_rows($resultado_dados);
        $num_dados_all = mysqli_num_rows($resultado_dados_all);
        $num_pag = ceil($num_dados_all/$itens_por_pag);
        
        $output .= '<div class="box box-primary" >
                        <div class="box-header with-border">
                                        <h2 class="box-title" style="padding: 7px;"><b>'.date('d M Y', dataParse($linha_meta_id['data_inicial'])) . ' - ' . date('d M Y', dataParse($linha_meta_id['data_final'])) .'</b><a class="btn-default" data-toggle="modal" data-target="#deleteMeta" data-meta_id="'.$linha_meta_id['id'].'" data-dado_id="" style="margin: 5px 10px;"><i class="fa fa-trash" style="padding: 5px; font-size: 20px;"></i></a></h2> 
                                    </div>
                                    <div class="box-body" >
                                        <table class="table table-bordered table-hover">';
                        while ($linha_dados = mysqli_fetch_array($resultado_dados)) {
                            $output .= '<tr onclick="showDescDado()">
                                            <td style="padding: 5px;">'. date('d M Y', dataParse($linha_dados['data_add'])) .'</td>
                                            <td style="padding: 5px;">'.$linha_dados['peso_add'].'kg';
                                            if($linha_dados['descricao']!=null){ 
                            $output .= '<a data-toggle="modal" data-target="#modalDadoMeta" data-data="'.date('d M Y', dataParse($linha_dados['data_add'])).'" data-desc="'.$linha_dados['descricao'].'" style="padding: 5px;"><i class="fa fa-question-circle"></i></a>';                    
                                            }
                            $output .= '<a class="btn-default" data-toggle="modal" data-target="#deleteMeta" data-meta_id="'.$linha_meta_id['id'].'" data-dado_id="'.$linha_dados['id'].'" style="margin: 5px 10px;"><i class="fa fa-trash" style="padding: 5px; font-size: 17px;"></i></a></td></tr>';
                                    }
                            $output .= '</table>    
                            <div class="box-footer dados_meta_pag">';
                            if($num_pag>1){
                                $output .= '<nav aria-label="Page navigation example">
                                    <ul class="pagination">';
                            if($pagina>1){
                                    $output .= '<li class="page-item">
                                            <a class="page-link" id="'.($pagina-1).'" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>';
                                }
                            for ($i = 1; $i < $num_pag+1; $i++) {
                                $active = '';                               
                                
                                if($pagina == $i){
                                    $active = "active";
                                }
                                $output .= ' <li class="page-item '.$active.'"><a class="page-link" id="'.$i.'">'.$i.'</a></li>';
                            }
                                if($pagina<$num_pag){       
                                        $output .= '<li class="page-item">
                                            <a class="page-link" id="'.($pagina+1).'" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>';
                                }
                                $output .= '</ul>
                                </nav>';
                            }
                            $output .= '</div>
                        </div>
                    </div>';
            echo $output;
    }
}
