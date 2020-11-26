<?php
require_once('connection.php');
$username="";
$password="";
$msg="";

if(isset($_POST['register']))
{
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
    }
    if(isset($_POST['password']))
    {
        $password = $_POST['password'];
    }
    $username_valido = filter_var($username,FILTER_VALIDATE_REGEXP,["options"=>["regexp"=>"/^[a-z\d_]{3,20}$/i"]]);
    $password_lun = mb_strlen($password);

    if(empty($username) || empty($password))
    {
        $msg = 'COMPILARE TUTTI CAMPI, SONO OBBLIGATORI';
    }else if(false ===$username_valido)
    {
        $msg ='USERNAME NON VALIDO, PUÒ CONTENERE SOLAMENTE L\'UNDERSCORE E CARATTERI ALFANUMERICI';
    }else if($password_lun<8 || $password_lun>20)
    {
        $msg ='LA PASSWORD INSERITA DEVE AVERE ALMENO 8 CARATTERI CON UN MASSIMO DI 20';
    }else
    {
        $password_hash=password_hash($password,PASSWORD_BCRYPT);
        $n_user=0;
        global $connection;
        $query = $connection->query("SELECT username FROM utenti WHERE username = '".$username."'");
        $n_user = $query->num_rows;

        if($n_user>0)
        {
            $msg='USERNAME IN USO';
        }else
        {
            global $connection;
            $connection->query("INSERT INTO utenti(id_utenti,username,password) VALUES(NULL,'$username','$password_hash')");
            $msg='registrazione effettuata con successo';
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ERRORI</title>
        <link rel="stylesheet"href="styleerrore.css">
    </head>
    <body>
        <h1>DETTAGLI DELL'ERRORE DI REGISTRAZIONE<h1>
        <div id="main">
            <div id="errori">
                <a><?php echo $msg ?><a>
            </div>
            <div id="buttoncontainer">
                <form action="index.php">
                    <button type="submit" name="indietro">RITORNA ALLA HOME PAGE</button>
                </form>
                <form action="indexreg.php">
                    <button type="submit" name="indietro">RITORNA ALLA PAGINA DI LOGIN</button>
                </form>
            </div>
        </div>
    </body>
    </html>
  <?php
}
?>
