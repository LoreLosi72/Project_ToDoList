<?php
/*CREDENZIALI DEL DATABASE, DOVRANNO ESSERE MODIFICATE QUANDO SI UTILIZZERA UN'ALTRA MACCHINA*/
$host = 'localhost';
$user = 'calendar';
$password = '';
$nome = 'calendar';
$connection = mysqli_connect($host,$user,$password,$nome);

/*$file = fopen('EVENTI.csv','r');
while(($dati = fgetcsv($file,200,","))!== FALSE)
{
    $sql="insert into impegni(Id_impegni,Nome, Data_impegno,fk_utente) values(NULL,'$dati[1]','$dati[2]', '$dati[3]')";
	mysqli_query($connection,$sql);
}
fclose($file);
*/
?>

