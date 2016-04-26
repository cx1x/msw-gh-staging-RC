<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_dateParam = date("Y-m-d");

$_dateLabel = date("M j");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(meeting($_dateParam,'time'));

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

		
			<div class="cd-main-content cd-dogperf-time">
			
        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">

						<div class="col-xs-8">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><strong class="head-title pull-left fs-14"><?=$_dateLabel;?></strong></a>
							
						</div>

						<div class="head-icons col-xs-4">
						
							<a href="<?php echo $folder; ?>/dogperf-list" data-type="x"><i class="fa fa-th-list"></i></a>
							
							<a href="#"><i class="fa fa-clock-o active-button"></i></a>
							
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
								
								<a href="<?php echo $folder; ?>/card/<?=$_next_race->race_group;?>/<?=$_next_race->race_uid;?>/<?=$_dateParam;?>" data-type="x" style="color: #fff;">
							
									<strong class="pull-left fs-14">Next Race Off</strong>
									
									<i class="fa fa-chevron-right pull-right fs-14"></i>
								
								</a>
								
							</div>
							
						</div>

						<div class="meeting-group col-xs-12 no-pad">
						
							<div class="meeting-header bg-444">
							
								<strong class="pull-left">Betting races in time order</strong>
								
							</div>
							
							<?
						
							//loop
							$_html = '';
							
							foreach($_datas AS $_date => $_fArray){
							
								foreach($_fArray AS $_k => $_v){
								
									$_props = json_decode($_v->properties);
									
									echo '
									
											<a href="'. $folder .'/card/' . $_v->race_group . '/' . $_v->race_uid . '/' . $_date . '" data-type="x">
											
												<div class="race-time col-xs-2"><strong>' . date('H:i', strtotime($_v->race_time)) . '</strong></div>
												
												<div class="link-item race-meeting-3 col-xs-10">
												
													<div class="pull-left">';
													
														echo ($_v->race_group != 'TV') ? '<strong>' . $_v->track . ' <i class="">SIS</i></strong>' : '<strong>' . $_v->track . ' <i class="">RPGTV</i></strong>';
														
														echo '<span>Race ' . $_v->race_number . '</span>
														
														<span><i class="">Grade: (' . $_props->grade . ') Dis: ' . $_props->distance_meters . 'M Winr: &pound;' . $_props->prize . '</i></span>
														
													</div>
													
													<i class="fa fa-chevron-right pull-right fs-14"></i>
													
												</div>
												
											</a>
											
											';
								
								}
							
							}
							
							?>

						</div>

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
								<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Select Date</button>-->
								<a class="btn btn-default glyphicon glyphicon-ok" data-dismiss="modal" href="/result/" data-type="x" id="selectDate"></a>
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
					var _href = $(this).attr("href");
					$(this).attr("href", _href + selectedDate);
				});

				$("#dog-search-text").keyup(function() {
				    var $th = $(this);
				    $th.val( $th.val().replace(/[^a-zA-Z ]/g, function(str) { alert('You typed " ' + str + ' ".\n\n Please use only letters.'); return ''; } ) );
				});

				$( "#dog-search-button" ).click(function() {
				  //alert( $("#dog-search-text").val() );
				  // window.location.href = "/greyhoundbet/search-result/1/" + $("#dog-search-text").val();

				  var str = $.trim( $("#dog-search-text").val() );

    				if( str == "" ) {
    					alert('Please enter name of dog or at least the two letters');
    					return false;
    				}
    				else {
    					$(this).attr("href", "<?php echo $folder; ?>/search-result/1/" + $("#dog-search-text").val());
    				}
				});
			});
		</script>
		
	</body>
	
</html>