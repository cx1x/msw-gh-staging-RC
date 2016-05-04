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

$_datas = json_decode(fastresult_races($_trackID, $_date));

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

			
			

			<div class="cd-main-content cd-fastresult-track">
				<?
				foreach($_datas AS $_track => $_fArray){
				
				
				?>
        
        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">

						<div class="col-xs-4">
						
							<a href="<?php echo $folder; ?>/result/<?=$_date;?>" data-type="x" style="color: #333;">
						
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
							
								foreach($_tArray AS $_raceTime => $_sArray){
							
									$_raceProps = json_decode($_sArray->race_details->race_props);
										
									echo '<a href="'. $folder .'/fastresult-card/' . $_trackID . '/' . $_raceID . '/' . $_date . '" data-type="x" style="margin-top: 0.5%;">
									
										<div class="race-time-4 col-xs-2"><strong> ' . date("H:i", strtotime(str_replace(".",":",$_raceTime))) . ' </strong></div>
										
										<div class="link-item race-meeting-4 col-xs-10">
										
											<span class="race-count-4">
											
												<div class="pull-left">';
												
										// $_dist = '';
										
										foreach($_sArray->dogs AS $_dogName => $_v){
										
											$_dogProps = json_decode($_v->dog_props);
											
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
											 
												<b>'. $_v->final_position . '</b>
												
												<div class="tx-4"><i class="dog-icon-16 num-' . $_dogProps->trap . '"></i></div>
												
												<p class="tx-race-1st">' . $_dogName . ' ' . $_dogProps->odds .'</p>
												
											</span>
											
											';
											
										}
										
											
										echo '		</div>
										
											</span>';
											
											// <span class="win-4">
											
												// <font style="color:#FFF">
												
													// <div class="tb-row">
													
														// <span>
														
															// <p> Win Time: </p> <b>' . $_raceProps->winnerstime_secs . '</b>
															
														// </span>
														
														// <span style="width:133px;">
														
															// <p> Distance: </p> '.$_dist.'
															
														// </span>
														
														
													// </div>
													
												// </font>
												
											// </span>
											
											echo '<i class="fa fa-chevron-right pull-right fs-14"></i>
											
										</div>
										
									</a>
									<div class ="race-fc">
							
										<div class="race-forecast-4 col-xs-2">
										
											<p> Forecast: </p> <b>(' . str_replace("-","x",$_sArray->race_details->forecast_trap) . ') £' . $_raceProps->forecast . '</b>
										
										</div>';
										
										if(isset($_raceProps->tricast)){
										
											echo '  <div class="race-forecast-4 col-xs-2">
											
															<p> Tricast: </p> <b>(0 x 0) £' . $_raceProps->tricast . '</b>
															
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
          
				<?}?>
								
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

</body>
	
</html>