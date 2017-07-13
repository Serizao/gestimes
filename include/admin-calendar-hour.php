
<?php
if (user::check_admin($_SERVER['HTTP_REFERER'])) {
	?>
<link href='./css/fullcalendar.min.css' rel='stylesheet' />
<link href='./css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='./js/moment.min.js'></script>
<script src='./js/jquery.min.js'></script>
<script src='./js/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			defaultDate: <?php echo '\''.(new \DateTime())->format('Y-m-d').'\''; ?>,
			navLinks: true, // can click day/week names to navigate views
			contentHeight: 450,
			weekNumbers: true,
			weekNumbersWithinDays: true,
			weekNumberCalculation: 'ISO',

			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: [
				<?php
					$bdd= new bdd;
					$bdd->cache('select b.nom as cat_name, a.date as date , a.nb as hour from heure a, categorie b where id_user=? and b.id=a.id_cat',array($id_user));
					$event = $bdd->exec();
					for($i=0;$i<count($event[0]);$i++){
						$hour=sectohour($event[0][$i]['hour']);
						echo '{
								title: \''.$hour["h"].':'.$hour["m"].'---'.$event[0][$i]["cat_name"].' \' ,
								start: \''.$event[0][$i]['date'].'\'
							},';
					}

				?>
			]
		});
		
	});

</script>
<style>



	#calendar {
		
		margin: 0 auto;
	}

</style>


	<div id='calendar'></div>


<?php
}
?>