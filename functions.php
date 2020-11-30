<?php

include_once 'connection_privata.php';
$username="";
session_start();
if(!isset($_SESSION['username']))
{
	header('Location:indexlog.php');
}else{
	$username=$_SESSION['username'];
}
if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'Genera_Calendario':
			Genera_Calendario($_POST['anno'],$_POST['mese']);
			break;
		case 'Genera_Eventi':
			Genera_Eventi($_POST['date']);
			break;
		default:
			break;
	}
}

function Genera_Calendario($anno = '', $mese = ''){
	$data_anno = ($anno != '')?$anno:date("Y");
	$data_mese = ($mese != '')?$mese:date("m");
	$data_calendario = $data_anno.'-'.$data_mese.'-01';
	$primo_giorno_mese = date("N",strtotime($data_calendario));
	$tot_giornimese = cal_days_in_month(CAL_GREGORIAN,$data_mese,$data_anno);
	$tot_giornimese_display = ($primo_giorno_mese == 1)?($tot_giornimese):($tot_giornimese + ($primo_giorno_mese - 1));
	$boxDisplay = ($tot_giornimese_display <= 35)?35:42;
	
	$mese_prima = date("m", strtotime('-1 month', strtotime($data_calendario)));
	$anno_prima = date("Y", strtotime('-1 month', strtotime($data_calendario)));
	$tot_giornimese_prima = cal_days_in_month(CAL_GREGORIAN, $mese_prima, $anno_prima);
?>
<div class="titolo">
	<h1><span>AGENDA</span></h1>
</div>
	<main class="calendar">
		<section class="title-bar">
			<a href="javascript:void(0);" class="title-bar__prev" onclick="Genera_Calendario('calendar_div','<?php echo date("Y",strtotime($data_calendario.' - 1 Month')); ?>','<?php echo date("m",strtotime($data_calendario.' - 1 Month')); ?>');"></a>
			<div class="title-bar__month">
				<select class="mese-dropdown">
					<?php echo Lista_Mesi($data_mese); ?>
				</select>
			</div>
			<div class="title-bar__year">
				<select class="anno-dropdown">
					<?php echo Lista_Anni($data_anno); ?>
				</select>
			</div>
			<a href="javascript:void(0);" class="title-bar__next" onclick="Genera_Calendario('calendar_div','<?php echo date("Y",strtotime($data_calendario.' + 1 Month')); ?>','<?php echo date("m",strtotime($data_calendario.' + 1 Month')); ?>');"></a>
		</section>
		
		<aside class="calendar__sidebar" id="event_list">
			<?php echo Genera_Eventi(); ?>
		</aside>
		
		<section class="calendar__days">
			<section class="calendar__top-bar">
				<span class="top-bar__days">LUN</span>
				<span class="top-bar__days">MAR</span>
				<span class="top-bar__days">MER</span>
				<span class="top-bar__days">GIO</span>
				<span class="top-bar__days">VEN</span>
				<span class="top-bar__days">SAB</span>
				<span class="top-bar__days">DOM</span>
			</section>
			
			<?php 
				$cont_giorni = 1;
				$n_eventi = 0;
				
				echo '<section class="calendar__week">';
				for($c=1;$c<=$boxDisplay;$c++){
					if(($c >= $primo_giorno_mese || $primo_giorno_mese == 1) && $c <= ($tot_giornimese_display)){
						
						$data_corrente = $data_anno.'-'.$data_mese.'-'.$cont_giorni;
						$username=$_SESSION['username'];
						
						global $db;
						$query = $db->query("SELECT Nome FROM impegni INNER JOIN utenti ON impegni.fk_utente=utenti.id_utenti WHERE utenti.username='".$username."' AND impegni.Data_impegno='".$data_corrente."'");
						$n_eventi = $query->num_rows;
						
						
						if(strtotime($data_corrente) == strtotime(date("Y-m-d"))){
							echo '
								<div class="calendar__day today" onclick="Genera_Eventi(\''.$data_corrente.'\');">
									<span class="calendar__date">'.$cont_giorni.'</span>
									<span class="calendar__task calendar__task--today">'.$n_eventi.' eventi</span>
								</div>
							';
						}elseif($n_eventi > 0){
							echo '
								<div class="calendar__day event" onclick="Genera_Eventi(\''.$data_corrente.'\');">
									<span class="calendar__date">'.$cont_giorni.'</span>
									<span class="calendar__task">'.$n_eventi.' eventi</span>
								</div>
							';
						}else{
							echo '
								<div class="calendar__day no-event" onclick="Genera_Eventi(\''.$data_corrente.'\');">
									<span class="calendar__date">'.$cont_giorni.'</span>
									<span class="calendar__task">'.$n_eventi.' eventi</span>
								</div>
							';
						}
						$cont_giorni++;
					}else{
						if($c < $primo_giorno_mese){
							$giorni_inattivi = ((($tot_giornimese_prima-$primo_giorno_mese)+1)+$c);
							$lbl_inattive = 'prima';
						}else{
							$giorni_inattivi = ($c-$tot_giornimese_display);
							$lbl_inattive = 'dopo';
						}
						echo '
							<div class="calendar__day inactive">
								<span class="calendar__date">'.$giorni_inattivi.'</span>
								<span class="calendar__task">'.$lbl_inattive.'</span>
							</div>
						';
					}
					echo ($c%7 == 0 && $c != $boxDisplay)?'</section><section class="calendar__week">':'';
				}
				echo '</section>';
			?>
		</section>
	</main>
<div id="buttons">
    <form action="indexinsert.php">
		<button type= "submit">INSERISCI EVENTO</button>
	</form>
	<form action="indexdelete.php">
		<button type= "submit">ELIMINA EVENTO</button>
	</form>
	<form action="logout.php">
		<button type= "submit">LOGOUT</button>
    </form>
</div>

	<script>
		function Genera_Calendario(target_div, anno, mese){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'func=Genera_Calendario&anno='+anno+'&mese='+mese,
				success:function(html){
					$('#'+target_div).html(html);
				}
			});
		}
		
		function Genera_Eventi(date){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'func=Genera_Eventi&date='+date,
				success:function(html){
					$('#event_list').html(html);
				}
			});
		}
		
		$(document).ready(function(){
			$('.mese-dropdown').on('change',function(){
				Genera_Calendario('calendar_div', $('.anno-dropdown').val(), $('.mese-dropdown').val());
			});
			$('.anno-dropdown').on('change',function(){
				Genera_Calendario('calendar_div', $('.anno-dropdown').val(), $('.mese-dropdown').val());
			});
		});
	</script>
<?php
}

function Lista_Mesi($select = '')
{
    $op = '';
    
    for($i=1;$i<=12;$i++)
    {
        if($i<10)
        {
            $val = '0'.$i;
        }else
        {
            $val = $i;
        }
        if($val==$select)
        {
            $select_op = 'selected';
        }else
        {
            $select_op ='';
        }
        
        $op .='<option value="'.$val.'" '.$select_op.' >'.date("F",mktime(0,0,0,$i+1,0,0)).'</option>';
    }
    return $op;
}

function Lista_Anni($select = '')
{
    $op = '';
    
    if(!empty($select))
    {
        $anno_in = $select;
    }else
    {
        $anno_in = date("Y");
    }
    
    $anno_prec =($anno_in-3);
    $anno_succ =($anno_in+3);
    
    for($i=$anno_prec;$i<=$anno_succ;$i++)
    {
        if($i == $select)
        {
            $select_op = 'selected';
        }
        else
        {
            $select_op ='';
        }

        $op .= '<option value="'.$i.'" '.$select_op.' >'.$i.'</option>';
    }
    return $op;
}


function Genera_Eventi($date = ''){
	$username=$_SESSION['username'];

	$date = $date?$date:date("Y-m-d");
	
	$lista_eventi = '<h2 class="sidebar__heading">'.date("l", strtotime($date)).'<br>'.date("F d", strtotime($date)).'</h2>';
	

	global $db;
	$query = $db->query("SELECT Nome FROM impegni INNER JOIN utenti ON impegni.fk_utente=utenti.id_utenti WHERE utenti.username='".$username."' AND impegni.Data_impegno='".$date."'");
	if($query->num_rows > 0){
		$lista_eventi .= '<ul class="sidebar__list">';
		$lista_eventi .= '<li class="sidebar__list-item sidebar__list-item--complete">EVENTI</li>';
		$i=0;
		while($row = $query->fetch_assoc()){ $i++;
            $lista_eventi .= '<li class="sidebar__list-item"><span class="list-item__time">'.$i.'.</span>'.$row['Nome'].'</li>';
        }
		$lista_eventi .= '</ul>';
	}
	echo $lista_eventi;
}



