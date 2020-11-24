<?php

include_once 'connection.php';

function Genera_Calendario()
{
    $data_anno = date("Y");
    $data_mese = date("m");
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

<main class="calendario">
		<section class="titolo-bar">
			<div class="titolo-bar__mese">
				<select class="mese-dropdown">
					<?php echo Lista_Mesi($data_mese); ?>
				</select>
			</div>
			<div class="titolo-bar__anno">
				<select class="anno-dropdown">
					<?php echo Lista_Anni($data_anno); ?>
				</select>
			</div>
		</section>
		
		
		<section class="calendario__giorni">
			<section class="calendario__top-bar">
				<a class="top-bar__giorni">Lun</a>
				<a class="top-bar__giorni">Mar</a>
				<a class="top-bar__giorni">Mer</a>
				<a class="top-bar__giorni">Gio</a>
				<a class="top-bar__giorni">Ven</a>
				<a class="top-bar__giorni">Sab</a>
				<a class="top-bar__giorni">Dom</a>
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
                                echo '
                                    <div class="calendario__giorno oggi">
                                        <a class="calendario__data">'.$cont_giorni.'</a>
                                        <a class="calendario__task calendario__task--oggi">'.$n_eventi.' Events</a>
                                    </div>';
                            }elseif($n_eventi > 0){
                                echo '
                                    <div class="calendario__giorno event">
                                        <a class="calendario__data">'.$cont_giorni.'</a>
                                        <a class="calendario__task">'.$n_eventi.' Eventi</a>
                                    </div>
                                ';
                            }else{
                                echo '
                                    <div class="calendario__giorno no-event">
                                        <a class="calendario__data">'.$cont_giorni.'</a>
                                        <a class="calendario__task">'.$n_eventi.' Eventi</a>
                                    </div>
                                ';
                            }
                            $cont_giorni++;
                        }else{
                            if($c < $pr_giornomese){
                                $giorni_altromese = ((($tot_giornimese-$pr_giornomese)+1)+$c);
                                $giorni = 'precedenti';
                            }else{
                                $giorni_altromese = ($c-$tot_giornimese_display);
                                $giorni = 'successivi';
                            }
                            echo '
                                <div class="calendario__giorno inattivo">
                                    <a class="calendario__data">'.$giorni_altromese.'</a>
                                    <a class="calendario__task">'.$giorni.'</a>
                                </div>
                            ';
                        }
                        echo (($c%7 == 0) && ($c != $boxdisplay))?'</section><section class="calendario__settimana">':'';
                }
                echo '</section>';
            ?>
        </section>
    </main>
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
            $seelct_op ='';
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




    
