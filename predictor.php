<?
date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_group = $_GET['group'];

$_raceid = $_GET['race'];

$_date = $_GET['date'];

$_datas = json_decode(predict($_raceid,$_date));


?>

<!DOCTYPE html>
<html lang="en">
  
  <?php
  include_once('header.php');
  ?>
  
  <body>
  
	<div class="load-bar">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </div>

    <main>

      

      <div class="cd-main-content cd-predictor">
      
      <div class="desk-logo"></div>
      <header class="container-fluid header-container">
      <div class="row">
       <?
    foreach($_datas AS $_fdate => $_fArray){
    ?>  
      <?
    foreach($_fArray AS $_name => $_gArray){
    foreach($_gArray AS $_raceTime => $_tArray){
    ?>
        
        <div class="col-xs-4">
          <strong class="head-title pull-left fs-14"></strong>
        </div>
    
        <div class="col-xs-4 text-center">
          <strong class="head-title fs-14"><?= $_name ?> <?=date('H:i', strtotime($_raceTime ));?></strong>
        </div>
       

    <div class="col-xs-4 text-center">
      
      <a href="<?php echo $folder; ?>/card/<?= $_group ?>/<?= $_raceid ?>/<?= $_fdate ?>" data-type="x">


        <strong class="head-title pull-right fs-14">DONE</strong>
        
      </a>

    </div>

      </div>
    </header>
    
    <div class="main-wrapper container-fluid ">
      <div class="row">
                
        <div class="predictor-container col-xs-12 no-pad">
          
          <ul class="list-unstyled">
      <?
      
        foreach($_tArray AS $_dogs => $_sArray){
      ?>
        <li><div class="anim-cont"  style="left:calc(100% - <?= $_sArray->percent_predict?>%);"><div id="predictor-dog-<?= $_sArray->trap ?>"></div></div></li>
      <? } } } }?>
            
          </ul>
          
        </div>
        
      </div>
      
    </div>
    </div>
  </main>

    <?php
    include_once('footer.php');
    ?>
    
    <script>
 
    
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
    
    // Predictor background if portrait or landscape
     $(window).on("resize", function() {  
      
        var screenHeight = $(window).height();
        var screenWidth = $(window).width();
            
          //Portrait
          if($(window).width() <= screenHeight) {
            $('.predictor-container').css('background-image', 'url(https://mswmedia.net/greyhoundbet/img/predictor-bg-port.png)');
          }
          //Landscape
          if($(window).height() <= screenWidth) {
            $('.predictor-container').css('background-image', 'url(https://mswmedia.net/greyhoundbet/img/predictor-bg.png)');
          }
        
      })
      .resize();
    </script>
  </body>
</html>