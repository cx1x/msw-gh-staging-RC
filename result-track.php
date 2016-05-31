<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_date = $_GET['date'];

$_trackID= $_GET['track'];

$_dateLabel = date("M j", strtotime($_date));

$_dateParam = date("Y-m-d");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(result_races($_trackID, $_date));

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

			

			<div class="cd-main-content cd-result-track">
				<?

				if (empty($_datas)){


					echo '<div id="no_item" name="no_item" style="font-size: 14px; color: #999; padding: 20px">Error 1004: Please try again later. Redirecting to home page in <strong class="timer_secs" style="color:#FC7012;">5 seconds</strong>.</div>';

				}


				else if(!empty($_datas)){ 


				foreach($_datas AS $_track => $_fArray){
				
				
				?>
        
        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">

						<div class="col-xs-4">
						
							<a href="<?php echo $folder; ?>/result/<?=$_date;?>" data-type="x" style="color: #fff;">
						
								<strong class="head-title pull-left fs-14"><i class="fa fa-chevron-left fs-12"></i> <?=$_dateLabel;?></strong>
							
							</a>
							
						</div>

						<div class="col-xs-4 text-center">
						
							<strong class="head-title fs-14"><?=ucwords (strtolower ($_track));?></strong>
						
						</div>

					</div>
					
				</header>

				<div class="main-wrapper container-fluid ">
				
					<div class="row">

						<div class="meeting-group col-xs-12 no-pad">
						
							<?
							
							foreach($_fArray AS $_raceID => $_tArray){
							
								foreach($_tArray AS $_raceNum => $_sArray){
							
									$_raceProps = json_decode($_sArray->properties);
									$_forecastProps = json_decode($_sArray->forecast_properties);
									$_tricastProps = json_decode($_sArray->tricast_properties);
									$_top3 = json_decode($_sArray->top3);
										
									echo '<a href="'. $folder .'/result-card/' . $_trackID . '/' . $_raceID . '/' . $_date . '" data-type="x" style="margin-top: 0.5%;">
									
										<div class="race-time-4 col-xs-2"><strong> ' . str_replace(".",":",$_sArray->race_time) . ' </strong></div>
										
										<div class="link-item race-meeting-4 col-xs-10">
										
											<span class="race-count-4">
											
												<div class="pull-left">';
												
										$_dist = '';
										
										foreach($_top3->$_raceID AS $_k => $_v){
											
											if(isset($_v->properties->distance)){
												$_dist .= $_v->properties->distance .', ';
											}
												
											switch($_v->final_position){
												case '1':
													$_position = '1st';
													break;
												case '2':
													$_position = '2nd';
													break;
												case '3':
													$_position = '3rd';
													break;
											
											}
											
											echo '
											
											<span>
											 
												<b>'. $_position . '</b>
												
												<div class="tx-4"><i class="dog-icon-16 num-' . $_v->trap . '"></i></div>
												
												<p class="tx-race-1st">' . $_v->dog_name . ' ' . $_v->properties->odds .'</p>
												
											</span>
											
											';
										
										}
										
											
										echo '		</div>
										
											</span>
											
											<span class="win-4">
											
												<font style="color:#FFF">
												
													<div class="tb-row">
													
														<span>
														
															<p> Win Time: </p> <b>' . $_raceProps->winnerstime_secs . '</b>
															
														</span>
														
														<span style="width:133px;">
														
															<p> Distance: </p> '.$_dist.'
															
														</span>
														
														
													</div>
													
												</font>
												
											</span>
											
											<i class="fa fa-chevron-right pull-right fs-14"></i>
											
										</div>
										
									</a>
									<div class ="race-fc">
							
										<div class="race-forecast-4 col-xs-2">
										
											<p> Forecast: </p> <b>(' . $_forecastProps[0]->trap1 . 'x' . $_forecastProps[0]->trap2 . ') ' . $_forecastProps[0]->value . '</b>
										
										</div>';
										
										if(isset($_tricastProps[0])){
										
											echo '  <div class="race-forecast-4 col-xs-2">
											
															<p> Tricast: </p> <b>(' . $_tricastProps[0]->trap1 . 'x' . $_tricastProps[0]->trap2 . ') ' . $_tricastProps[0]->value . '</b>
															
														</div>
														
													';
									
										}
										
										echo '</div>';
								
								}
							
							}
							
							?>

						</div>

					</div>
			
				</div>
        
				<footer class="container-fluid footer-container">

					<div class="row">

						<div class="col-xs-4">

							<a href="<?php echo $folder; ?>/dogperf-list" data-type="x"><span class="foot-icon-cards"></span>Cards</a>

						</div>

						<div class="col-xs-4">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><span class="foot-icon-results"></span>Results</a>
							
						</div>

						<div class="col-xs-4">
						
							<a href="<?php echo $folder; ?>/card/<?=$_next_race->race_group;?>/<?=$_next_race->race_uid;?>/<?=$_dateParam;?>" data-type="x"><span class="foot-icon-next"></span>Next Race</a>
							
						</div>

					</div>
					
				</footer>
				
				<?} } ?>
								
				<div id="myModal" class="modal fade" role="dialog">
							
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						
							<div class="modal-header">
							
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							
							<h4 class="modal-title"></h4>
							
							</div>
							
							<div class="modal-body">
							
								<div id="datetimepicker12">
								
									<input type="text" style="display:none;" id="selectedDate"></input>
									
								</div>
								
							</div>
							
							<div class="modal-footer">
							
								<a class="btn btn-default glyphicon glyphicon-ok" data-dismiss="modal" href="<?php echo $folder; ?>/result/" data-type="x" id="selectDate"></a>
								
							</div>
							
						</div>

					</div>
					
				</div>	

			</div>

		</main>

		<?php
  		include_once('footer.php');
  		?>



<script type="text/javascript">

$( document ).ready(function() {

	if($("#no_item").length != 0) {


		var t = 4;

		setInterval(function(){

			if(t > 1){

				$(".timer_secs").empty();

				$(".timer_secs").append(t+' seconds');

				t = t-1;		

			}

			else if(t == 1){

				$(".timer_secs").empty();

				$(".timer_secs").append(t+' second');

				t = t-1;

			}

			else if(t < 1){

				history.go(-1);

			}

		},1000);

	}

});

</script>
	

</body>
	
</html>