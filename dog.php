<?

date_default_timezone_set("Europe/London");

include_once('_inc/function.php');
include_once('config.php');

$_track = $_GET['track'];

$_raceid = $_GET['race'];

$_date = $_GET['date'];

$_dogid = $_GET['dog'];

$_dateParam = date("Y-m-d");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

$_datas = json_decode(dog_details($_raceid,$_date,$_dogid));

$_details_props = json_decode($_datas->dog_details->properties);

$_race_props = json_decode($_datas->dog_details->race_props);

$_track_name = array(
				'CRAYFORD'                        	=> 'Cryfd',
				'HARLOW'                         	=> 'Harlow',
				'KINSLEY'                           => 'Kinsly',
				'NEWCASTLE'                     	=> 'Newc',
				'NOTTINGHAM'                		=> 'Notts',
				'PERRYBARR'                     	=> 'PerB',
				'POOLE'                             => 'Poole',
				'SHEFFIELD'                         => 'Sheff',
				'SITTINGBOURNE'            			=> 'Stgbrn',
				'SUNDERLAND'                  		=> 'Sland',
				'TOWCESTER'                     	=> 'Towc',
				'BELLEVUE'                         	=> 'Bvue',
				'HALLGREEN'                     	=> 'HallG',
				'HOVE'                              => 'Hove',
				'PETERBOROUGH'            			=> 'Pbrgh',
				'ROMFORD'                        	=> 'Romfd',
				'SWINDON'                         	=> 'Swndn',
				'YARMOUTH'                      	=> 'Yrmth',
				'HENLOW'                            => 'Hnlow',
				'MONMORE'                      		=> 'Monmr',
				'WIMBLEDON'                   		=> 'Wdom',
				'DONCASTER'                     	=> 'Donc',
				'MILDENHALL'                    	=> 'Mldhl',
				'PELAWGRANGE'             			=> 'Pelaw',
				'SHAWFIELD'                      	=> 'Shawf'
			);

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

			<div class="cd-main-content cd-dog">

        <div class="desk-logo"></div>
				<header class="container-fluid header-container head-orange">
				
					<div class="row">
					
						<div class="col-xs-4">
						
							<a href="<?php echo $folder ?>/card/<?=$_datas->dog_details->race_group;?>/<?=$_raceid;?>/<?=$_date;?>" data-type="x">
							
								<strong class="head-title pull-left fs-14"><i class="fa fa-chevron-left fs-12"></i> <?=date('H.i', strtotime($_datas->dog_details->race_time));?></strong>
							
							</a>
							
						</div>

						<div class="col-xs-4 text-center">

							<strong class="head-title fs-14"><?=$_datas->dog_details->trap;?> OF 6</strong>

						</div>

						<div class="col-xs-4 text-center">
						
							<strong class="head-title pull-right fs-14">

								<a href="<?php echo $folder ?>/dogs/<?=$_track;?>/<?=$_raceid;?>/<?=$_date;?>/<?=get_next_dog($_raceid, $_datas->dog_details->trap, 'prev');?>" data-type="x"><i class="fa fa-angle-up fa-2x"></i></a>
								
								&nbsp;&nbsp;
								
								<a href="<?php echo $folder ?>/dogs/<?=$_track;?>/<?=$_raceid;?>/<?=$_date;?>/<?=get_next_dog($_raceid, $_datas->dog_details->trap, 'next');?>" data-type="x"><i class="fa fa-angle-down fa-2x"></i></a>
							
							</strong>

						</div>

					</div>
					
				</header>

				<div class="main-wrapper container-fluid ">
				
					<div class="row">

						<div class="dog-card-4 col-xs-12 no-pad">

							<!-- Tab panes -->
							<div class="dog-info tb-container">

								<div class="link-item race-meeting-2 dog-card col-xs-12">
								
									<div class="pull-left">
									
										<span><i class="dog-icon-28 num-<?=$_datas->dog_details->trap;?>"></i><?=$_datas->dog_details->dog_name;?></span>
										
									</div>
									
								</div>

								<div class="col-xs-12 pad-8 pedigree-info">
								
									<span class="pull-left">
									
										<p>Sire <strong><?=$_details_props->sire_name;?></strong></p>
										
										<p><strong><?=$dog_color_attr[strtoupper($_details_props->colour)]; ?><?php echo ($_details_props->sex == 'd') ? " Dog" : " Bitch"; ?></strong></p>
										
									</span>                  
									
									<span class="pull-right">
									
										<p>Dam <strong><?=$_details_props->dam_name;?></strong></p>
										
										<p><strong><?=date('dMy', strtotime($_details_props->whelp));?></strong></p>
										
									</span>
									
								</div>

								<div class="tb-row tb-titles bg-444">
								
									<div class="">STATISTICS - AT <?=ucwords (strtolower ($_track));?></div>
									
								</div>

								<div class="chart-performance">
								
									<ul class="list-unstyled">
								
										<p>Wins to runs at <?=ucwords (strtolower ($_track));?></p>
										<?
										
										$_width = max(array($_datas->dog_details->runs, $_datas->dog_details->trap_runs == 0, $_datas->dog_details->grade_runs == 0));
										
										// print_r($_width);
										
										// exit;
					
										echo ($_width == 0) ? '<li>' : '<li style="width:'.($_width * 100)/$_width.'%;">';
										  echo ($_datas->dog_details->runs == 0) ? '' : '<div class="bar-bg" style="width:'.($_datas->dog_details->runs * 100)/$_width.'%;"></div>';
										  echo ($_datas->dog_details->wins == 0) ? '' : '<div class="bar-fill" style="width:'.($_datas->dog_details->wins * 100)/$_width.'%;position:absolute;"></div>';
										  echo '<span>'.$_datas->dog_details->wins.'/'.$_datas->dog_details->runs.'</span>
										</li>
										
										';
							
										?>
										<p>Wins to runs from Trap <?=$_datas->dog_details->trap;?> at <?=ucwords (strtolower ($_track));?></p>
										<?
					
										echo ($_width  == 0) ? '<li>' : '<li style="width:'.($_width  * 100)/$_width .'%;">';
										  echo ($_datas->dog_details->trap_runs == 0) ? '' : '<div class="bar-bg" style="width:'.($_datas->dog_details->trap_runs * 100)/$_width.'%;"></div>';
										  echo ($_datas->dog_details->trap_wins == 0) ? '' : '<div class="bar-fill" style="width:'.($_datas->dog_details->trap_wins * 100)/$_width.'%;position:absolute;"></div>';
										  echo '<span>'.$_datas->dog_details->trap_wins.'/'.$_datas->dog_details->trap_runs.'</span>
										</li>
										
										';
							
										?>

										<p>Wins to runs in <?=$_race_props->grade;?> at <?=ucwords (strtolower ($_track));?></p>
										<?
					
										echo ($_width  == 0) ? '<li>' : '<li style="width:'.($_width  * 100)/$_width .'%;">';
										  echo ($_datas->dog_details->grade_runs == 0) ? '' : '<div class="bar-bg" style="width:'.($_datas->dog_details->grade_runs * 100)/$_width.'%;"></div>';
										  echo ($_datas->dog_details->grade_wins == 0) ? '' : '<div class="bar-fill" style="width:'.($_datas->dog_details->grade_wins * 100)/$_width.'%;position:absolute;"></div>';
										  echo '<span>'.$_datas->dog_details->grade_wins.'/'.$_datas->dog_details->grade_runs.'</span>
										</li>
										
										';
							
										?>
										
									</ul>
									
								</div>

								<div class="dog-card-tb">
								
									<div class="tb-row tb-titles bg-444">
									
										<div class="">LIFETIME FORM SINCE GBGB/IGB REGISTERED</div>
										
									</div>
									
									<div class="tb-row tb-titles">
									
										<div class="tb-date">Date</div>
										
										<div class="tb-track">Track</div>
										
										<div class="tb-dis">Dis</div>
										
										<div class="tb-trp">Trp</div>
										
										<div class="tb-split">Split</div>
										
										<div class="tb-fin">Fin</div>
										
										<div class="tb-sp">SP</div>
										
										<div class="tb-grade">Grade</div>
										
										<div class="tb-caltm">CalTm</div>
										
									</div> 

									<?
									
									foreach($_datas->race_history AS $_date => $_props){
									
										$_history_props = json_decode($_props->properties);
									
										echo '
											<div class="tb-row">
											
												<div class="tb-date">'.date('dMy', strtotime($_date)).'</div>
												
												<div class="tb-track">'.$_track_name[$_track].'</div>';
												
												echo (!empty($_history_props->dist)) ? '<div class="tb-dis">'.$_history_props->dist.'m</div>' : '<div class="tb-dis">&nbsp;</div>';
												
												echo (!empty($_history_props->trap)) ? '<div class="tb-trp">['.$_history_props->trap.']</div>' : '<div class="tb-trp">&nbsp;</div>';
												
												echo (!empty($_history_props->sectional_time)) ? '<div class="tb-split">'.$_history_props->sectional_time.'</div>' : '<div class="tb-split">&nbsp;</div>';
												
												echo (!empty($_history_props->position)) ? '<div class="tb-fin">'.$_history_props->position.'</div>' : '<div class="tb-fin">&nbsp;</div>';
												
												echo (!empty($_history_props->converted_odds)) ? '<div class="tb-sp">'.$_history_props->converted_odds.'</div>' : '<div class="tb-sp">&nbsp;</div>';
												
												echo (!empty($_history_props->grade)) ? '<div class="tb-grade">'.$_history_props->grade.'</div>' : '<div class="tb-grade">&nbsp;</div>';
												
												echo (!empty($_history_props->calc_time)) ? '<div class="tb-caltm">'.$_history_props->calc_time.'</div>' : '<div class="tb-caltm">&nbsp;</div>';
												
											echo '</div>
										';
									
									}
									
									?>
									
								</div>
								
							</div>

						</div>

					</div>

				</div>
        
				<footer class="container-fluid footer-container">

					<div class="row">

						<div class="col-xs-4">

							<a href="<?php echo $folder ?>/dogperf-list" data-type="x"><span class="foot-icon-cards"></span>Cards</a>

						</div>

						<div class="col-xs-4">
						
							<a href="#myModal" data-toggle="modal" data-target="#myModal"><span class="foot-icon-results"></span>Results</a>
							
						</div>

						<div class="col-xs-4">
						
							<a href="<?php echo $folder ?>/card/<?=$_next_race->race_group;?>/<?=$_next_race->race_uid;?>/<?=$_dateParam;?>" data-type="x"><span class="foot-icon-next"></span>Next Race</a>
							
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
							
								<a class="btn btn-default glyphicon glyphicon-ok" data-dismiss="modal" href="/result/" data-type="x" id="selectDate"></a>
								
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
			
				e.preventDefault()
				
				$(this).tab('show')
				
			})  
			
		</script>
		
	</body>
	
</html>