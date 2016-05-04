<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_raceid = $_GET['race'];

$_date = $_GET['date'];

$_group = $_GET['group'];

$_dateParam = date("Y-m-d");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_races = json_decode(race_lists($_raceid,$_date,$_group));

?><!DOCTYPE html>

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

			

			<div class="cd-main-content cd-stats">

				<?

				foreach($_races AS $_date => $_fArray){

					foreach($_fArray AS $_track => $_sArray){
					
						// $_track = $_trackName;

						echo '<div class="desk-logo"></div>
            
            <header class="container-fluid header-container">

							<div class="row">

								<div class="col-xs-4">

									<a href="'.$folder.'/dogperf-track/' . $_sArray->race_details->track_uid . '/' . $_date . '/' . $_sArray->race_details->race_group  . '" data-type="x">

										<strong class="head-title pull-left fs-14"><i class="fa fa-chevron-left fs-12"></i> ' . date('M j', strtotime($_date)) . '</strong>
							
									</a>

								</div>

								<div class="col-xs-4 text-center">

									<strong class="head-title fs-14">' . ucwords (strtolower ($_track)) . '</strong>

								</div>

								<div class="col-xs-4 text-center">
									
									<a href="'. $folder .'/predictor/' .$_sArray->race_details->race_group. '/' . $_raceid . '/' . $_date . '" data-type="x">


										<strong class="head-title pull-right fs-14">Predictor</strong>
										
									</a>

								</div>

							</div>

						</header>';

					
					}

				}					
				?>

				<div class="main-wrapper container-fluid ">
				
					<div class="row">

						<div class="head-clock-wrapper">

						<div id="time-carousel" class="carousel slide" data-ride="carousel">

										<?
										
										/* $_trackName = array(); */
										
										foreach($_races AS $_date => $_fArray){
										
											foreach($_fArray AS $_track => $_sArray){
											
												$_trackName = $_track;
										
												$_race_time = json_decode(race_time($_sArray->race_details->track_uid,$_date,$_group));
											
												echo '<ol class="carousel-indicators">';
										
													foreach($_race_time AS $_k => $_v){
													
														echo ($_v->race_uid == $_raceid) ? '<li data-target="'.$folder.'/stats/'.$_group.'/'.$_v->race_uid.'/'.$_v->track_date.'" data-slide-to="0" class="active"></li>' : '<li data-target="/stats/'.$_group.'/'.$_v->race_uid.'/'.$_v->track_date.'" data-slide-to="0"></li>';
														
													}
													
												echo '</ol>';
													
												echo '<div class="row">
													
														<div class="col-xs-offset-3 col-xs-6">
														
															<div class="carousel-inner">';
															
											
															foreach($_race_time AS $_k => $_v){
															
																echo ($_v->race_uid == $_raceid) ? '<div class="item active">' : '<div class="item">';
																
																	echo '
																		
																		<div class="carousel-content">
																	
																			<span>' . date('H:i', strtotime($_v->race_time)) . '</span>
																		
																		</div>
																	
																</div>';
													
															}

															echo '
															
															</div>
															
														</div>
														
													</div>';
													
													foreach($_race_time AS $_k => $_v){
													
														if($_v->race_uid == $_raceid){
														
															if(get_next_raceid($_sArray->race_details->track_uid, $_v->race_time, $_v->track_date, 'less', $_group) == '#'){
															
																echo ' ';
																
															}
															else{
															
																echo '
																
																<a class="left carousel-control" href="'.$folder.'/stats/' . $_group . '/'.get_next_raceid($_sArray->race_details->track_uid, $_v->race_time, $_v->track_date, 'less', $_group).'/'.$_v->track_date.'" data-slide="prev" data-type="x">
																
																	<span class="fa fa-chevron-left"></span>
																	
																</a>';
															
															}
														
															if(get_next_raceid($_sArray->race_details->track_uid, $_v->race_time, $_v->track_date, 'greater', $_group) == '#'){
															
																echo '';
																
															}
															else{
															
																echo '
																
																<a class="right carousel-control" href="'.$folder.'/stats/' . $_group . '/'.get_next_raceid($_sArray->race_details->track_uid, $_v->race_time, $_v->track_date, 'greater', $_group).'/'.$_v->track_date.'" data-slide="next" data-type="x">
																
																	<span class="fa fa-chevron-right"></span>
																	
																</a>
																
																';
															
															}
														
														}
													
													}
											
											
											}
										
										}
										
										?>
						</div>
						</div>

						<div class="meeting-group dog-tips col-xs-12 no-pad">

							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
							
								<li role="presentation"><a href="<?=$folder;?>/card/<?=$_group;?>/<?=$_raceid;?>/<?=$_date;?>" data-type="x">Card</a></li>
								
								<li role="presentation"><a href="<?=$folder;?>/form/<?=$_group;?>/<?=$_raceid;?>/<?=$_date;?>" data-type="x">Form</a></li>
								
								<li role="presentation" class="active"><a href="#messages" aria-controls="messages" role="tab" data-type="x">Stats</a></li>
								
								<li role="presentation"><a href="<?=$folder;?>/tips/<?=$_group;?>/<?=$_raceid;?>/<?=$_date;?>" data-type="x">TIPS</a></li>
							
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
							
								<div role="tabpanel" class="tab-pane fade" id="home"></div>
								
								<div role="tabpanel" class="tab-pane fade in active" id="profile">

									<div class="dog-stats">

										<?

										$_stats = json_decode(get_stats($_raceid, $_date, $_trackName));

										?>

										<div class="chart-performance">
										
											<h4>1/4 Dogs Performance</h4>
											
											<p>Individual runner's career wins-to-runs at <?=ucwords (strtolower ($_trackName));?></p>
											
											<ul class="list-unstyled">

												<?

												foreach($_stats->perf AS $_trackID => $_fArray){

													foreach($_fArray AS $_k => $_v){

														echo '
														
															<li style="width:'.($_v->high_runs * 100)/$_v->high_runs.'%;">
															
															<i class="dog-icon-28 num-'.$_k.'"></i>';
															
															echo ($_v->runs == 0) ? '' : '<div class="bar-bg" style="width:'.($_v->runs * 100)/$_v->high_runs.'%;"></div>';
															
															echo ($_v->wins == 0) ? '' : '<div class="bar-fill" style="width:'.($_v->wins * 100)/$_v->high_runs.'%;position:absolute;"></div>';
															
															echo '<span>'.$_v->wins.'/'.$_v->runs.'</span>
															
															</li>
															
														';
															
													}

												}

												?>

											</ul>
											
										</div>

										<div class="chart-trap-record">
										
											<h4>2/4 Trap Record</h4>
											
											<p>Individual runner's career wins-to-runs at <?=ucwords (strtolower ($_trackName));?> from the trap it is running from today</p>

											<ul class="list-unstyled">

												<?

												foreach($_stats->perf AS $_trackID => $_fArray){

													foreach($_fArray AS $_k => $_v){

														echo '
														
															<li style="width:'.($_v->high_trap_runs * 100)/$_v->high_trap_runs.'%;">
															
															<i class="dog-icon-28 num-'.$_k.'"></i>';
															
															echo ($_v->trap_runs == 0) ? '' : '<div class="bar-bg" style="width:'.($_v->trap_runs * 100)/$_v->high_trap_runs.'%;"></div>';
															
															echo ($_v->trap_wins == 0) ? '' : '<div class="bar-fill" style="width:'.($_v->trap_wins * 100)/$_v->high_trap_runs.'%;position:absolute;"></div>';
															
															echo '<span>'.$_v->trap_wins.'/'.$_v->trap_runs.'</span>
															
															</li>
															
														';
															
													}

												}

												?>
												
											</ul>
											
										</div>

										<div class="chart-record-class">
										
											<h4>3/4 Record in this Class</h4>
											
											<p>Individual runner's career wins-to-runs at <?=ucwords (strtolower ($_trackName));?> in the class it is running in today</p>

											<ul class="list-unstyled">

												<?

												foreach($_stats->perf AS $_trackID => $_fArray){

													foreach($_fArray AS $_k => $_v){

														echo '
														
															<li style="width:'.($_v->high_grade_runs * 100)/$_v->high_grade_runs.'%;">
															
															<i class="dog-icon-28 num-'.$_k.'"></i>';
															
															echo ($_v->grade_runs == 0) ? '' : '<div class="bar-bg" style="width:'.($_v->grade_runs * 100)/$_v->high_grade_runs.'%;"></div>';
															
															echo ($_v->grade_wins == 0) ? '' : '<div class="bar-fill" style="width:'.($_v->grade_wins * 100)/$_v->high_grade_runs.'%;position:absolute;"></div>';
															
															echo '<span>'.$_v->grade_wins.'/'.$_v->grade_runs.'</span>
															
															</li>
															
														';
															
													}

												}

												?>
												
											</ul>
											
										</div>

										<div class="chart-recent-trap">
										
											<h4>4/4 Recent Trap Stats</h4>
											
											<p>The recent wins-to-runs of each trap at <?=ucwords (strtolower ($_trackName));?></p>

											<?

											$_totalRace = $_stats->stats->TrapStats_Recently_total_races;

											$_trapStats = json_decode($_stats->stats->trap_stats);

											?>

											<ul class="list-unstyled">
											
												<li style="width:<?=($_totalRace * 100)/$_totalRace;?>%;">
												
													<i class="dog-icon-28 num-1"></i>
													
													<div class="bar-bg" style="width:<?=($_totalRace * 100)/$_totalRace;?>%;"></div>
													
													<div class="bar-fill" style="width:<?=($_trapStats->trap_1_wins * 100)/$_totalRace;?>%;position:absolute;"></div>
													
													<span><?=$_trapStats->trap_1_wins;?>/<?=$_totalRace;?></span>
													
												</li>

												<li style="width:<?=($_totalRace * 100)/$_totalRace;?>%;">
												
													<i class="dog-icon-28 num-2"></i>
													
													<div class="bar-bg" style="width:<?=($_totalRace * 100)/$_totalRace;?>%;"></div>
													
													<div class="bar-fill" style="width:<?=($_trapStats->trap_2_wins * 100)/$_totalRace;?>%;position:absolute;"></div>
													
													<span><?=$_trapStats->trap_2_wins;?>/<?=$_totalRace;?></span>
													
												</li>

												<li style="width:<?=($_totalRace * 100)/$_totalRace;?>%;">
												
													<i class="dog-icon-28 num-3"></i>
													
													<div class="bar-bg" style="width:<?=($_totalRace * 100)/$_totalRace;?>%;"></div>
													
													<div class="bar-fill" style="width:<?=($_trapStats->trap_3_wins * 100)/$_totalRace;?>%;position:absolute;"></div>
													
													<span><?=$_trapStats->trap_3_wins;?>/<?=$_totalRace;?></span>
													
												</li>

												<li style="width:<?=($_totalRace * 100)/$_totalRace;?>%;">
												
													<i class="dog-icon-28 num-4"></i>
													
													<div class="bar-bg" style="width:<?=($_totalRace * 100)/$_totalRace;?>%;"></div>
													
													<div class="bar-fill" style="width:<?=($_trapStats->trap_4_wins * 100)/$_totalRace;?>%;position:absolute;"></div>
													
													<span><?=$_trapStats->trap_4_wins;?>/<?=$_totalRace;?></span>
													
												</li>

												<li style="width:<?=($_totalRace * 100)/$_totalRace;?>%;">
												
													<i class="dog-icon-28 num-5"></i>
													
													<div class="bar-bg" style="width:<?=($_totalRace * 100)/$_totalRace;?>%;"></div>
													
													<div class="bar-fill" style="width:<?=($_trapStats->trap_5_wins * 100)/$_totalRace;?>%;position:absolute;"></div>
													
													<span><?=$_trapStats->trap_5_wins;?>/<?=$_totalRace;?></span>
													
												</li>

												<li style="width:<?=($_totalRace * 100)/$_totalRace;?>%;">
												
													<i class="dog-icon-28 num-6"></i>
													
													<div class="bar-bg" style="width:<?=($_totalRace * 100)/$_totalRace;?>%;"></div>
													
													<div class="bar-fill" style="width:<?=($_trapStats->trap_6_wins * 100)/$_totalRace;?>%;position:absolute;"></div>
													
													<span><?=$_trapStats->trap_6_wins;?>/<?=$_totalRace;?></span>
													
												</li>
												
											</ul>
											
										</div>

									</div>

								</div>

								<div role="tabpanel" class="tab-pane fade" id="messages">.333333..</div>
								
								<div role="tabpanel" class="tab-pane fade" id="settings">.44444..</div>
								
							</div>

						</div>

					</div>

					</div>
        
        <footer class="container-fluid footer-container">

					<div class="row">

						<div class="col-xs-4">

							<a href="<?=$folder;?>/dogperf-list" data-type="x"><span class="foot-icon-cards"></span>Cards</a>

						</div>

						<div class="col-xs-4">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><span class="foot-icon-results"></span>Results</a>
							
						</div>

						<div class="col-xs-4">
						
							<a href="<?=$folder;?>/card/<?=$_next_race->race_group;?>/<?=$_next_race->race_uid;?>/<?=$_dateParam;?>" data-type="x"><span class="foot-icon-next"></span>Next Race</a>
							
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
							
								<a class="btn btn-default glyphicon glyphicon-ok" data-dismiss="modal" href="<?=$folder;?>/result/" data-type="x" id="selectDate"></a>
								
							</div>
							
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
			$(document).ready(function() {
				$('.carousel').carousel({
					interval: false
				}); 

			});
		</script>
	</body>
</html>