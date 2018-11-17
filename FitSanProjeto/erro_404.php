<?php
$pagina = "Ops.. Foi Mal!";
include_once './template/cabecalho.php';
include_once './template/menu.php';
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        404 Error Page
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Pagina não encontrada.</h3>
          <p>
            Não foi possível encontrar a página que você estava procurando. Enquanto isso, você pode   
            <a href="<?=URL_SITE?>pagina1.php">retornar para a pagina inicial</a> ou relaxar e assistir a esse video:
          </p>
          
       
          
          <?php
          $video_array = array
              ('https://www.youtube.com/embed/5t9uMjt-Dac',
              'https://www.youtube.com/embed/OuJYEKEUDEQ',
              'https://www.youtube.com/embed/SRq7XtDW0wg',
              'https://www.youtube.com/embed/f3SLMdf4PbM');
          shuffle($video_array);
          $video = $video_array[0];
          ?>

          <iframe width='560' height='315' src='<?php echo $video_array[rand(0, (count($video_array) - 1))]; ?>
                                               ' frameborder='0'  allowfullscreen></iframe>

          </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
  include_once './template/rodape_especial.php';
