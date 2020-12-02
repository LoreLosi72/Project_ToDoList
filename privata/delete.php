<?php
session_start();
require_once('connection_privata.php');

$username="";
$msg="";
$Data_impegno="";
$Nome="";
if(isset($_POST['delete']))
{
    if(!isset($_SESSION['username']))
    {
        header('Location:../login/indexlog.php');
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
                    $query1 = $db->query("SELECT Id_impegni FROM impegni WHERE Nome='".$Nome."' AND Data_impegno='".$Data_impegno."'");
                    if($query1->num_rows>0)
                    {
                    $db->query("DELETE FROM impegni WHERE fk_utente='".$fkutenti."' AND Nome='".$Nome."' AND Data_impegno='".$Data_impegno."'");
                    $msg="Eliminazione effettuata con successo";
                    }else{
                        $msg="NON È PRESENTE NELL'AGENDA L'EVENTO DA ELIMINARE";
                    }
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
        <title>STATO DELL'ELIMINAZIONE</title>
        <link rel="stylesheet" href="../registrazione/styleerrore.css">
    </head>
    <body>
        <h1>DETTAGLI DELLO STATO DI ELIMINAZIONE<h1>
            <div id="main">
                <div id ="errori">
                    <a><?php echo $msg ?></a>
                </div>
                <div id="buttoncontainer">
                    <form action="../privata/indexprivata.php">
                        <button type="submit" name="indietro">RITORNA ALL'AGENDA</button>
                    </form>
                    <form action="indexdelete.php">
                        <button type="submit" name="indietro">RITORNA ALLA PAGINA DI ELIMINAZIONE</button>
                    </form>
                </div>
            </div>
        
    </body>
    </html>
    <?php
}
?>