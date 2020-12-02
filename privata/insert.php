<?php
session_start();
require_once('connection_privata.php');

$username="";
$msg="";
$Data_impegno="";
$Nome="";
if(isset($_POST['insert']))
{
    if(!isset($_SESSION['username']))
    {
        header('Location:indexlog.php');
    }else{
        $username=$_SESSION['username'];
    }
    if(isset($_POST['Nome'])&& isset($_POST['Data_impegno']))
    {
        $Nome=$_POST['Nome'];
        $Data_impegno=$_POST['Data_impegno'];
        if(empty($Nome) || empty($Data_impegno))
        {
            $msg="COMPILA TUTTI I CAMPI";
        }else{
            
            global $db;
            $query = $db->query("SELECT id_utenti FROM utenti WHERE username='".$username."'");
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){ 
                    $fkutenti = $row['id_utenti'];
                    $db->query("INSERT INTO impegni(Id_impegni,Nome,Data_impegno,fk_utente) VALUES(NULL,'$Nome','$Data_impegno','$fkutenti')");
                    $msg="inserimento effettuato con successo";
                }
            }
        }
            
        
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>STATO DELL'INSERIMENTO</title>
        <link rel="stylesheet" href="../registrazione/styleerrore.css">
    </head>
    <body>
        <h1>DETTAGLI DELLO STATO DI INSERIMENTO<h1>
            <div id="main">
                <div id ="errori">
                    <a><?php echo $msg ?></a>
                </div>
                <div id="buttoncontainer">
                    <form action="indexprivata.php">
                        <button type="submit" name="indietro">RITORNA ALL'AGENDA</button>
                    </form>
                    <form action="indexinsert.php">
                        <button type="submit" name="indietro">RITORNA ALLA PAGINA DI INSERIMENTO</button>
                    </form>
                </div>
            </div>
        
    </body>
    </html>
    <?php
}
?>