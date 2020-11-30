<?php
session_start();
require_once('../pubblica/connection.php');
$username="";
$password="";
$msg="";
if(isset($_POST['login']))
{
    if(isset($_POST['username']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];
        if(empty($username)||empty($password))
        {
            $msg='COMPILA TUTTI I CAMPI';
        }
        else
        {
            $n_user=0;
            global $connection;
            $query = $connection->query("SELECT * FROM utenti WHERE username = '".$username."'");
            $n_user = $query->num_rows;
            if($n_user>0){
                $dati_utente = $query->fetch_array();
                if(password_verify($password,$dati_utente['password']))
                {
                    $_SESSION['username'] = $username;
                    header("location:../privata/indexprivata.php");
                }else 
                {
                    $msg="UTENTE O PASSWORD ERRATI";
                }
            }else{
                $msg="L'UTENTE NON RISULTA REGISTRATO";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ERRORI</title>
        <link rel="stylesheet"href="../registrazione/styleerrore.css">
    </head>
    <body>
        <h1>DETTAGLI DELL'ERRORE DI ACCESSO<h1>
        <div id="main">
            <div id="errori">
                <a><?php echo $msg ?><a>
            </div>
            <div id="buttoncontainer">
                <form action="../pubblica/index.php">
                    <button type="submit" name="indietro">RITORNA ALLA HOME PAGE</button>
                </form>
                <form action="indexlog.php">
                    <button type="submit" name="indietro">RITORNA ALLA PAGINA DI LOGIN</button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>