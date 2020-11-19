<?php

include_once 'connection.php';

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
?>
    <inizio class = "calendario-contenitore">
        <sezione class = "titolo-bar">
            <div class="titolo-bar_mese">
                <sezione class="mese-dropdown">
                </sezione>
            </div>
            <div class="titolo-bar_anno">
                <sezione class="anno-dropdown">
                </sezione>
            </div>
        </sezione> 

    <sezione class="calendario_giorni">
        <sezione class="calendario_top-bar">
            <giorno class ="top-bar giorni">Lunedì</giorno>
            <giorno class ="top-bar giorni">Martedì</giorno>
            <giorno class ="top-bar giorni">Mercoledì</giorno>
            <giorno class ="top-bar giorni">Giovedì</giorno>
            <giorno class ="top-bar giorni">Venerdì</giorno>
            <giorno class ="top-bar giorni">Sabato</giorno>
            <giorno class ="top-bar giorni">Domenica</giorno>
    </sezione>
}
