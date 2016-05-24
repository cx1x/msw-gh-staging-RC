<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include('config.php');

$_date = $_GET['date'];

$_dateLabel = date("M j", strtotime($_date));

$_dateParam = date("Y-m-d");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(result_meeting($_date));
// print_r(result_meeting($_date));

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

			
		
			<div class="cd-main-content cd-result">
			
        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">

						<div class="col-xs-8">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><strong class="head-title pull-left fs-14"><?=$_dateLabel;?></strong></a>
							
						</div>

					</div>
					
				</header>

				<div class="main-wrapper container-fluid ">
				
					<div class="row">

						<div class="col-xs-12 bg-222 no-pad">
						
							<div class="link-item next-race">
							
								<strong class="pull-left fs-14">Latest Results</strong>
								
								<i class="fa fa-chevron-right pull-right fs-14"></i>
								
							</div>
							
						</div>
						
						<?
						
						//loop
						$_html = '';
						
						if(!empty($_datas)){



						
						foreach($_datas AS $_date => $_fArray){

							foreach($_fArray AS $_group => $_sArray){
							
								$_group = $_group;

								switch ($_group) {
									case "TV":
										$_groupName = 'RP Greyhound TV';
										break;
									case "B":
										$_groupName = 'Bags';
										break;
									case "PC":
										$_groupName = 'Provincial Cards';
										break;
									case "MPC":
										$_groupName = 'Main NON-BAGS Cards';
										break;
									default:
										echo $_group;
								}
							
								$_html .= ' <div class="meeting-group col-xs-12 no-pad">';
								
								$_html .= ' <div class="meeting-header bg-444">
							
												<strong class="pull-left">' . $_groupName . '</strong>
												
											</div>';
								
								foreach($_sArray AS $_track => $_tArray){
									
										if(isset($_tArray->track_details->num_races))
											$_numRaces = $_tArray->track_details->num_races;
									
										if(isset($_tArray->track_details->race_time))
											$_raceTime = $_tArray->track_details->race_time;
										
										$_sizeArray = sizeof($_tArray->results->result); 
									
										if($_date == $_dateParam){
										
											if(isset($_tArray->results->fast_result)){	
											
												$_sizeFastResult = 0;
											
												foreach($_tArray->races AS $_raceID => $_rArray){
												
													$_sizeFastResult = $_sizeFastResult + 1;
												
												}
										
												$_html .= ' <a href="'. $folder .'/fastresult-track/'. $_tArray->results->fast_result->track_uid . '/' . $_date . '" data-type="page-transition">
										
																<div class="link-item race-meeting">
																
																	<div class="pull-left">
																	
																		<strong>' . ucwords (strtolower ($_track)) . '</strong>';
																		
																			if($_sizeFastResult == $_numRaces)
																				$_html .= ' <span>full meeting results available</span>';
																			else
																				$_html .= ' <span>' . $_sizeFastResult . ' of ' . $_numRaces . ' results available</span>';
																
																$_html .= ' </div>
																	
																	<i class="fa fa-chevron-right pull-right fs-14"></i>
																	
																</div>
																
															</a>';
											
											}
											
											else{
									
												$_html .= ' 										
																<div class="link-item race-meeting">
																
																	<div class="pull-left">
																	
																		<strong>' . ucwords (strtolower ($_track)) . '</strong>';
																		
																			$_html .= ' <span> ' . $_numRaces . ' races, starting at ' . date("H:i", strtotime($_raceTime)) . '</span>';
																
																$_html .= ' </div>
																	
																	<i class="fa fa-chevron-right pull-right fs-14"></i>
																	
																</div>
															
															';
											
											}
										
										}
										
										else{
									
										$_html .= ' <a href="'. $folder .'/result-track/'. $_tArray->results->result->track_uid . '/' . $_date . '" data-type="page-transition">
								
														<div class="link-item race-meeting">
														
															<div class="pull-left">
															
																<strong>' . ucwords (strtolower ($_track)) . '</strong>';
																
																	$_html .= ' <span>full meeting results available</span>';
														
														$_html .= ' </div>
															
															<i class="fa fa-chevron-right pull-right fs-14"></i>
															
														</div>
														
													</a>';
									
										}
								
								}
								
								$_html .= ' </div>';
							
							}

						}
					}
					else{

						$_html = '<div class="meeting-header bg-444"><strong class="pull-left" style="font-size: 14px; color: #FC7012; padding: 5px 0;">Error 1002: Please try again later.</strong></div>';
					}
						
						echo $_html;
						
						
						?> 

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
        
				<!-- Modal -->
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
								<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Select Date</button>-->
								<a class="btn btn-default glyphicon glyphicon-ok" data-dismiss="modal" href="<?php echo $folder; ?>/result/" data-type="page-transition" id="selectDate"></a>
							</div>
						</div>

					</div>
				</div>		
				
			</div>

		</main>

		<div class="cd-cover-layer"></div>
		
		<div class="cd-loading-bar"></div>

		<?php
  		include_once('footer.php');
  		?>

		<script type="text/javascript">
			$(function () {
				$('#datetimepicker12').datetimepicker({
					inline: true,
					format: 'YYYY-MM-DD',
					maxDate : 'now',
					minDate : '02/16/2016',
					showTodayButton: true
				});
				
				$("#selectDate").click(function(){
					var selectedDate = $('#selectedDate').val();
					// var _href = $(this).attr("href");
					$(this).attr("href", "/result/" + selectedDate);
				});
			});
		</script>
		
	</body>
	
</html>