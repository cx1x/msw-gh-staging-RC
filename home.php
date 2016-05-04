<?php

date_default_timezone_set("Europe/London");
include_once('_inc/function.php');
include_once('config.php');

$_dateParam = date("Y-m-d");

$_dateLabel = date("M j");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(meeting($_dateParam, 'list'));

if (!isset($_COOKIE['firsttime'])){
    setcookie("firsttime", "no", time() + (86400 * 30), "/");
    header('Location: '. $folder. '/card/'.$_next_race->race_group.'/'.$_next_race->race_uid.'/'.$_dateParam);
    exit();
}


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

		
			<div class="cd-main-content">
      
        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">

						<div class="col-xs-8">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><strong class="head-title pull-left fs-14"><?=$_dateLabel;?></strong></a>
							
						</div>

						<div class="head-icons col-xs-4">
						
							<a href="#"><i class="fa fa-th-list active-button"></i></a>
							
							<a href="<?php echo $folder; ?>/dogperf-time" data-type="x"><i class="fa fa-clock-o"></i></a>
							
						</div>

					</div>
					
				</header>
				
				<div class="main-wrapper container-fluid ">
				
					<div class="row">


						<!-- search div -->
						<div class="search-cont col-xs-12 bg-1a1 pad-8">
				          <div class="search-box input-group">
				            <input type="text" class="form-control" id="dog-search-text" placeholder="Dog Search...">
				            <span class="input-group-btn">
				              <a href="<?php echo $folder; ?>/search-result/1/" id="dog-search-button" data-type="x"><button class="btn btn-default" type="button" on><i class="fa fa-search"></i></button></a>
				            </span>
				          </div>
				        </div>
						<!-- searc div end -->


						<div class="col-xs-12 bg-222 no-pad">
						
							<div class="link-item next-race">								
								
								<a href="<?php echo $folder; ?>/card/<?=$_next_race->race_group;?>/<?=$_next_race->race_uid;?>/<?=$_dateParam;?>" data-type="x" style="color: #333;">
							
									<strong class="pull-left fs-14">Next Race Off</strong>
									
									<i class="fa fa-chevron-right pull-right fs-14"></i>
								
								</a>
								
							</div>
							
						</div>

						<?
						
						//loop
						$_html = '';
						
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
									
									$_endArray = end($_tArray); 
								
									$_html .= ' <a href="'. $folder .'/dogperf-track/'. $_tArray[0]->track_uid . '/' . $_dateParam . '/' . $_group . '" data-type="x">
							
													<div class="link-item race-meeting">
													
														<div class="pull-left">
														
															<strong>' . ucwords (strtolower ($_track)) . '</strong>';
															
															if(date('H:i', strtotime($_tArray[0]->race_time)) == date('H:i', strtotime($_endArray->race_time)))
															
																$_html .= ' <span>' . sizeof($_tArray). ' ' . $_tArray[0]->racegroup_type . ' Races <i class="">(' . date('H:i', strtotime($_tArray[0]->race_time)) . ')</i></span>';
																
															else
															
																$_html .= ' <span>' . sizeof($_tArray). ' ' . $_tArray[0]->racegroup_type . ' Races <i class="">(' . date('H:i', strtotime($_tArray[0]->race_time)) . ' - ' . date('H:i', strtotime($_endArray->race_time)) . ')</i></span>';
													
													$_html .= ' </div>
														
														<i class="fa fa-chevron-right pull-right fs-14"></i>
														
													</div>
													
												</a>';
								
								}
								
								$_html .= ' </div>';
							
							}

						}
						
						echo $_html;
						
						
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
							
								<a class="btn btn-default glyphicon glyphicon-ok" data-dismiss="modal" href="<?php echo $folder; ?>/result/" data-type="x" id="selectDate" ></a>
								
							</div>
							
						</div>

					</div>
					
				</div>
				
			</div>

		</main>

		<div class="cd-cover-layer">
		</div>
		
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

				
				$("#dog-search-text").keyup(function() {
				    var $th = $(this);
				    $th.val( $th.val().replace(/[^a-zA-Z ]/g, function(str) { alert('You typed " ' + str + ' ".\n\n Please use only letters.'); return ''; } ) );
				});


				$( "#dog-search-button" ).click(function() {

				  var str = $.trim( $("#dog-search-text").val() );

    				if( str == "" ) {
    					alert('Please enter name of dog or at least the two letters');
    					return false;
    				}
    				else {
    					//$(this).attr("href", "/greyhoundbet/search-result/1/" + $("#dog-search-text").val());
    					$(this).attr("href", "<?php echo $folder; ?>/search-result/1/" + $("#dog-search-text").val());
    				}
				});
			});
		</script>
		
	</body>
	
</html>