<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_date = $_GET['date'];

$_raceID = $_GET['race'];

$_trackID = $_GET['track'];

$_dateLabel = date("M j", strtotime($_date));

$_dateHeader = date("d/m/y", strtotime($_date));

$_dateParam = date("Y-m-d");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(fastresult_runners($_raceID, $_date));

$_race_time = json_decode(fastresult_race_time($_trackID, $_date));

// print_r(fastresult_race_time($_trackID, $_date));

// exit;

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

			<div class="cd-main-content cd-result-card">
				
					<?
					
					foreach($_datas AS $_track => $_fArray){
					
						foreach($_fArray AS $_raceID => $_sArray){
				
					?>
          
					<div class="desk-logo"></div>
					<header class="container-fluid header-container">
					
						<div class="row">

							<div class="col-xs-4">
							
								<a href="<?php echo $folder; ?>/fastresult-track/<?=$_trackID;?>/<?=$_date;?>" data-type="x" style="color: #333;">
								
									<strong class="head-title pull-left fs-14"><i class="fa fa-chevron-left fs-12"></i> <?=$_dateLabel;?></strong>
									
								</a>
								
							</div>

							<div class="col-xs-4 text-center">
							
								<strong class="head-title fs-14"><?=ucwords (strtolower ($_track));?> <?=$_dateHeader;?></strong>
							
							</div>

						</div>
						
					</header>

					<div class="main-wrapper container-fluid ">
					
						<div class="row">

							<div class="head-clock-wrapper">

								<div id="time-carousel" class="carousel slide" data-ride="carousel">
								
										<?
										
											echo '<ol class="carousel-indicators">';
									
												foreach($_race_time AS $_k => $_v){
												
													echo ($_v->race_uid == $_raceID) ? '<li data-target="'. $folder .'/form/'.$_v->race_uid.'/'.$_v->track_date.'" data-slide-to="0" class="active"></li>' : '<li data-target="#time-carousel" data-slide-to="0"></li>';
													
												}
												
											echo '</ol>';
												
											echo '<div class="row">
												
													<div class="col-xs-offset-3 col-xs-6">
													
														<div class="carousel-inner">';
														
										
														foreach($_race_time AS $_k => $_v){
														
															echo ($_v->race_uid == $_raceID) ? '<div class="item active">' : '<div class="item">';
															
																echo '
																	
																	<div class="carousel-content">
																
																		<span>' . date("h:i", strtotime(str_replace(".",":",$_v->race_time))). '</span>
																	
																	</div>
																
															</div>';
												
														}

														echo '
														
														</div>
														
													</div>
													
												</div>';
												
												foreach($_race_time AS $_k => $_v){
												
													if($_v->race_uid == $_raceID){
													
														if(get_next_fastresult_raceid($_trackID, $_v->race_time, $_v->track_date, 'less') == '#'){
														
															echo ' ';
															
														}
														else{
														
															echo '
															
															<a class="left carousel-control" href="'. $folder .'/fastresult-card/'.$_trackID.'/'.get_next_fastresult_raceid($_trackID, $_v->race_time, $_v->track_date, 'less').'/'.$_v->track_date.'" data-slide="prev" data-type="x">
															
																<span class="fa fa-chevron-left"></span>
																
															</a>';
														
														}
													
														if(get_next_fastresult_raceid($_trackID, $_v->race_time, $_v->track_date, 'greater') == '#'){
														
															echo '';
															
														}
														else{
														
															echo '
															
															<a class="right carousel-control" href="'. $folder .'/fastresult-card/'.$_trackID.'/'.get_next_fastresult_raceid($_trackID, $_v->race_time, $_v->track_date, 'greater').'/'.$_v->track_date.'" data-slide="next" data-type="x">
															
																<span class="fa fa-chevron-right"></span>
																
															</a>
															
															';
														
														}
													
													}
												
												}
												
												?>
									

								</div>
								
							</div>

							<div class="meeting-group-2 dog-cards col-xs-12 no-pad">
							
								<!--Status-->
								<?
								
								$_raceProps = json_decode($_sArray->race_details->race_props);
								
								echo '<div class="statusBox">
								
									<span data-eventid="results_title_toggle" id="circle-race-title" class="button">Race ' . $_raceProps->race_number . ' £' . substr($_raceProps->prize_sterling1, 0, strpos($_raceProps->prize_sterling1, ".")) . ' (' . $_raceProps->grade . ') ' . $_raceProps->distance_meters . 'm</span>
									
								</div>';
								
								?>
								
								<!-- Tab panes -->
								<div class="tab-content">
								
									<div role="tabpanel" class="tab-pane fade in active" id="home">
										
										<?
										
										foreach($_sArray->dog_details AS $_dogID => $_v){
											
											$_dogProps = json_decode($_v->dog_props);
											$_trainer= json_decode($_v->dog_trainer);
											
											switch($_v->final_position){
												case '1':
													$_position = 'st';
													break;
												case '2':
													$_position = 'nd';
													break;
												case '3':
													$_position = 'rd';
													break;
												default:
													$_position = 'th';
												
											}
											
											// switch($_dogProps->colour){
												// case 'Black':
													// $_colour = 'bk';
													// break;
												// case 'Fawn':
													// $_colour = 'f';
													// break;
												// case 'Brind':
													// $_colour = 'bd';
													// break;
												// case 'Blue':
													// $_colour = 'be';
													// break;
												// default:
													// $_colour = $_dogProps->colour;
												
											// }
											
											echo '
											
											<a href="'. $folder .'/dogs-result/' . preg_replace('/\s+/', '', $_track) . '/' . $_raceID . '/' . $_date . '/' . $_dogID . '" data-type="x">
											
												<div class="race-position col-xs-1">
												
													<strong>' . $_v->final_position . '<small>' . $_position . '</small></strong>
												
												</div>
												
												<div class="link-item race-meeting-5 col-xs-10">
												
													<div class ="hr">
													
														<span class="win-5">
														
															<div class="pull-left">
															
																<div class = "dog-race-group">
																
																	<div class="tx-4"><i class="dog-icon-28 num-' . $_dogProps->trap . '" style="display: block"></i></div>
																	
																	<div class= "dog-race-detail">
																	
																		<p class="dog-name">' . $_v->dog_name . '</p>
																		
																		<span>';
																		
																			if($_v->final_position == 1)
																				echo '<p class="dog-col">' . $_raceProps->winnerstime_secs . '</p>';
																			else
																				echo '<p class="dog-col">&nbsp;</p>';
																				
																		echo '<p class="dog-col-1">' . $_dogProps->odds . '</p>
																		
																			  <p class="dog-col-1">T: ' . $_trainer->trainer_name . '</p>
																			
																		</span>
																		
																	</div>
																	
																</div>
																
															</div>
															
														</span>
													
													</div>	
													
													<span class="bottom">
													
														<div class="pull-left">
														
															<i class="comment">  </i>
															
														</div>
														
													</span>
													
												</div>
												
												<i class="fa fa-chevron-right pull-right fs-14 race-meeting-5-i"></i>
													
											</a>
											
											';
										
										}
										
										?>		

									</div>
									
									<div role="tabpanel" class="tab-pane fade" id="profile">..22222.</div>
									
									<div role="tabpanel" class="tab-pane fade" id="messages">.333333..</div>
									
									<div role="tabpanel" class="tab-pane fade" id="settings">.44444..</div>
									
								</div>

							</div>

						</div>

					</div>
					
					<?
					
						}
						
					}
					?>
		
				</div>	
							
			
				<footer class="container-fluid footer-container">

					<div class="row">

						<div class="col-xs-4">

							<a href="<?php echo $folder; ?>/" data-type="x"><span class="foot-icon-cards"></span>Cards</a>

						</div>

						<div class="col-xs-4">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><span class="foot-icon-results"></span>Results</a>
							
						</div>

						<div class="col-xs-4">
						
							<a href="<?php echo $folder; ?>/card/<?=$_next_race->race_group;?>/<?=$_next_race->race_uid;?>/<?=$_dateParam;?>" data-type="x"><span class="foot-icon-next"></span>Next Race</a>
							
						</div>

					</div>
					
				</footer>	
        
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

		<script>
		
			$('.carousel').carousel({
			
				interval: false
				
			}); 

			$('#myTabs a').click(function (e) {
			
				e.preventDefault();
				
				$(this).tab('show');
				
			})  
			
		</script>
		
	</body>
	
</html>