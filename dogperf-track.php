<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_track = $_GET['track'];
$_track_id = $_track;

$_date = $_GET['date'];
$_group = $_GET['group'];

$_dateParam = date("Y-m-d");

$_dateLabel = date("M j", strtotime($_date));

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(races($_track, $_date, $_group));


?>

<!DOCTYPE html>

<html lang="en">

	<?php
  	include_once('header.php');
  	?>
	
	<body class="no-scroll">
	
		<div class="load-bar">
			  <div class="bar"></div>
			  <div class="bar"></div>
			  <div class="bar"></div>
		</div>
    <div class="stop-scroll"></div>
			
	
		<main>

				
		
			<?
						
			//loop
			$_html = '';
			
			foreach($_datas AS $_track => $_fArray){
			
			?>
		
			<div class="cd-main-content cd-dogperf-track">
			
        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">

						<div class="col-xs-4">
						
							<a href="<?php echo $folder; ?>/dogperf-list" data-type="x" style="color: #333;">
								
								<strong class="head-title pull-left fs-14"><i class="fa fa-chevron-left fs-12"></i> <?=$_dateLabel;?></strong>
							
							</a>
							
						</div>

						<div class="col-xs-4 text-center">
						
							<strong class="head-title fs-14"><?=ucwords (strtolower ($_track));?></strong>
						
						</div>

						<!--<div class="head-icons col-xs-4">
						
							<a href="#"><i class="fa fa-th-list active-button"></i></a>
							
							<a href="#"><i class="fa fa-clock-o"></i></a>
							
						</div>!-->

					</div>
					
				</header>

				<div class="main-wrapper container-fluid ">
				
					<div class="row">
					
						<?
						
						foreach($_fArray AS $_group => $_sArray){
						
						?>

						<div class="meeting-group col-xs-12 no-pad">
						
							<div class="meeting-header bg-444">
							
								<strong class="pull-left">Channel: <?=($_group == 'TV') ? 'RPGTV' : 'SIS';?></strong>
								
							</div>
							
							<?
							
							foreach($_sArray AS $_race => $_tArray){
							
							$_props = json_decode($_tArray->properties);


							$_tips = json_decode(get_race_tips($_track_id,$_date, $_tArray->race_uid, $_tArray->race_group));
							/*
							echo '<pre>';
							print_r($_tips);
							echo '</pre>';
							*/

							foreach($_tips AS $_race_id => $_fArray){

								foreach($_fArray AS $_time => $_sArray){

									if(isset($_sArray->current_race)){
														
										$curr_tips = '
													<div class="tb-row">
												
													<span>

														<b style="font-weight: 500; margin-right: 5px; display: inline-block; "> POST PICK: </b>
														<div class="tx-1st"><i class="dog-icon-16 num-' .$_sArray->current_race->post_pick[0]  . '"></i></div>
																
														<div class="tx-2nd"><i class="dog-icon-16 num-' . $_sArray->current_race->post_pick[1]  . '"></i></div>
																
														<div class="tx-3rd"><i class="dog-icon-16 num-' . $_sArray->current_race->post_pick[2]  . '"></i></div>
													
													</span>

													<span>

														<div class="tx-selection">' . $_sArray->current_race->dog_name  . '</div>

													</span>

													</div>
														
													';
													
									}													

								}

							}
							


								echo '<a href="'. $folder .'/card/' . $_tArray->race_group . '/' . $_tArray->race_uid . '/' . $_date . '" data-type="x">
								
									<div class="race-time col-xs-2"><strong>' . date('H:i', strtotime($_tArray->race_time )). '</strong></div>
									
									<div class="link-item race-meeting-2 col-xs-10">
									
										<span class="race-count">


											<div class="pull-left">
											
												<strong>Race ' . $_race . ' </strong>';
												
												echo ($_group == 'TV') ? '<span><i class="">Grade: (' . $_props->grade . ') Dis: ' . $_props->distance_meters . 'M Winr: &pound;' . $_props->prize . '</i></span>' : '<span><i class="">Grade: (' . $_props->grade . ') Dis: ' . $_props->distance_meters . 'M Winr: &pound;' . $_props->prize . '</i></span>';
												
											echo '</div>

										</span>
										<span class="post-pick">

											<font style="color:#333">'. $curr_tips .'</font>

										</span>
										
										<i class="fa fa-chevron-right pull-right fs-14"></i>
										
									</div>
									
								</a>';

							}
							
							?>

						</div>
						
						<?
						
						}
						
						?>

					</div>

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
			
			<?
			
			}
			
			?>
			
		</main>

		<div class="cd-cover-layer"></div>
		
		<div class="cd-loading-bar"></div>

		<?php
  		include_once('footer.php');
  		?>
		
	</body>
	
</html>