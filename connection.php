<?php
$host = 'localhost';
$user = 'agenda';
$password = '';
$nomedb = 'agenda';
$connection = mysqli_connect($host,$user,$password,$nomedb);

if($connection->connect_error)
{
    die("Connessione non riuscita: ".$connection->connect_error);
}else
{
    $file = fopen('Appuntamenti.csv','r');
    while(($dati = fgetcsv($file,100,","))!== FALSE)
    {
        $sql="insert into impegni(Id_Impegni,Nome, Descrizione, Data_impegno,Orario_impegno) values(NULL,'$dati[1]', NULL, '$dati[2]', '$dati[3]')";
	    mysqli_query($connection,$sql);
    }
    fclose($file);
}
mysqli_close($connection);
?>