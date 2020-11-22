<?php

include_once 'connection.php';

if(isset($_POST['function']) && !empty($_POST['function'])){
	switch($_POST['function']){
		case 'Calendario':
			Calenderio($_POST['anno'],$_POST['mese']);
			break;
		case 'Eventi':
			Eventi($_POST['date']);
			break;
		default:
			break;
	}
}

function Genera_Calendario($mese = '',$anno = '')
{
    $data_anno = ($anno != '')?$anno:date("Y");
    $data_mese = ($mese != '')?$mese:date("m");
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

    $mese_prima = date("m",strtotime('-1 month', strtotime($date)));
    $anno_prima = date("Y",strtotime('-1 month', strtotime($date)));
    $tot_giornimese_prima = cal_days_in_month(CAL_GREGORIAN, $mese_prima,$anno_prima);

 

   
    $cont_giorni = 1;
    $n_eventi = 0;

    for($i = 1; i<=$boxdisplay;$i++)
    {
        if(($cb >= $pr_giornomese || $pr_giornomese==1) && $i<=($tot_giornimese_display))
        {
            $data_corrente = $data_anno.'-'.$data_mese.'-'.$cont_giorni;

             global $connection;
            $query = mysqli_query("SELECT Nome FROM impegni WHERE Data_impegno = '".$data_corrente."'");
            $n_eventi = $query->n_righe;
        }
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
            $select_op = 'select';
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
            $select_op = 'select';
        }
        else
        {
            $select_op ='';
        }

        $op .= '<option value="'.$i.'" '.$select_op.' >'.$i.'</option>';
    }
    return $op;
}

function Eventi($data ='') 
{
    if(!empty($data))
    {
        $data = $data;
    }
    else
    {
        $data = date("Y-m-d");
    }

    global $nomedb;
    $query = mysqli_query("SELECT Nome FROM impegni WHERE Data_impegno = '".$data."'"); 
   
}
   
?>

    <script>
		function Calendario(div, anno, mese){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'function=Calendario&anno='+anno+'&mese='+mese,
				success:function(html){
					$('#'+div).html(html);
				}
			});
		}
		
        function Eventi(date){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'function=Eventi&data='+date,
				success:function(html){
					$('#event_list').html(html);
				}
			});
		}
		
	</script>
