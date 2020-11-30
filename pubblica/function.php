<?php

include_once 'connection.php';

if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'Genera_Calendario':
			Genera_Calendario($_POST['anno'],$_POST['mese']);
			break;
		default:
			break;
	}
}

function Genera_Calendario($anno='',$mese='')
{
    $data_anno = ($anno !='')?$anno:date("Y");
    $data_mese = ($mese !='')?$mese:date("m");
    $data_calendario = $data_anno.'-'.$data_mese.'-01';
    $pr_giornomese = date("N",strtotime($data_calendario));
    $tot_giornimese = cal_days_in_month(CAL_GREGORIAN, $data_mese, $data_anno);
    
    if($pr_giornomese==1)
    {
        $tot_giornimese_display = $tot_giornimese;
    }else
    {
        $tot_giornimese_display = $tot_giornimese + ($pr_giornomese - 1);
    }

    if($tot_giornimese_display<=35)
    {
        $boxdisplay = 35;
    }else
    {
        $boxdisplay = 42;
    }

    $mese_prima = date("m",strtotime('-1 mese', strtotime($data_calendario)));
    $anno_prima = date("Y",strtotime('-1 mese', strtotime($data_calendario)));
    $tot_giornimese_prima = cal_days_in_month(CAL_GREGORIAN, $mese_prima,$anno_prima);

?>
<ul>
    <li><a class="active" href = "../registrazione/indexreg.php">REGISTRAZIONE</a></li>
    <li><a href = "../login/indexlog.php">LOGIN</a></li>
</ul>
<div class="titolo">
    <h1><span>CALENDARIO</span></h1>
</div>
<div class="titolo-bar">
    <select class="mese-dropdown"><?php echo Lista_Mesi($data_mese); ?></select>
    <select class="anno-dropdown"><?php echo Lista_Anni($data_anno); ?></select>
</div>
<main class="calendario">
		<section class="calendario__giorni">
			<section class="calendario__top-bar">
				<b class="top-bar__giorni">LUN</b>
				<b class="top-bar__giorni">MAR</b>
				<b class="top-bar__giorni">MER</b>
				<b class="top-bar__giorni">GIO</b>
				<b class="top-bar__giorni">VEN</b>
				<b class="top-bar__giorni">SAB</b>
				<b class="top-bar__giorni">DOM</b>
			</section>
		    <?php
                    $cont_giorni = 1;
                    $n_eventi = 0;

                    echo '<section class="calendario__settimana">';
                    for($c = 1; $c<=$boxdisplay;$c++)
                    {
                        if(($c >= $pr_giornomese || $pr_giornomese==1) && $c<=($tot_giornimese_display))
                        {
                            $data_corrente = $data_anno.'-'.$data_mese.'-'.$cont_giorni;

                            global $connection;
                            $query = $connection->query("SELECT Nome FROM impegni WHERE Data_impegno = '".$data_corrente."'");
                            $n_eventi = $query->num_rows;

                            if(strtotime($data_corrente) == strtotime(date("Y-m-d"))){
                                $oggi = 'oggi';
                                echo '
                                    <div class="calendario__giorno oggi">
                                        <b class="calendario__data">'.$cont_giorni.'</b>
                                        <b class="calendario__task">'.$oggi.'</b>
                                    </div>';
                            
                            }else{
                                echo '
                                    <div class="calendario__giorno no-event">
                                        <b class="calendario__data">'.$cont_giorni.'</b>
                                    </div>
                                ';
                            }
                            $cont_giorni++;
                        }else{
                            if($c < $pr_giornomese){
                                $giorni_altromese = ((($tot_giornimese-$pr_giornomese)+1)+$c);
                                $giorni = 'Prima';
                            }else{
                                $giorni_altromese = ($c-$tot_giornimese_display);
                                $giorni = 'Dopo';
                            }
                            echo '
                                <div class="calendario__giorno inattivo">
                                    <b class="calendario__data">'.$giorni_altromese.'</b>
                                    <b class="calendario__task">'.$giorni.'</b>
                                </div>
                            ';
                        }
                        echo (($c%7 == 0) && ($c != $boxdisplay))?'</section><section class="calendario__settimana">':'';
                }
                echo '</section>';
            ?>
        </section>
    </main>
    <script>
        function Genera_Calendario(target_div,anno, mese){
			$.ajax({
				type:'POST',
				url:'function.php',
				data:'func=Genera_Calendario&anno='+anno+'&mese='+mese,
				success:function(html){
					$('#'+target_div).html(html);
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

?>

