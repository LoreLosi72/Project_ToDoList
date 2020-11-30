<?php
require_once('../pubblica/connection.php');
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
        
        $n_user=0;
        global $connection;
        $query = $connection->query("SELECT username FROM utenti WHERE username = '".$username."'");
        $n_user = $query->num_rows;

        if($n_user>0)
        {
            $msg='USERNAME IN USO';
        }else
        {
            $password_hash=password_hash($password,PASSWORD_BCRYPT);
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
        <h1>STATO DI REGISTRAZIONE<h1>
        <div id="main">
            <div id="errori">
                <a><?php echo $msg ?><a>
            </div>
            <div id="buttoncontainer">
                <form action="../pubblica/index.php">
                    <button type="submit" name="indietro">RITORNA ALLA HOME PAGE</button>
                </form>
                <form action="../login/indexlog.php">
                    <button type="submit" name="indietro">VAI ALLA PAGINA DI LOGIN</button>
                </form>
                <form action="../registrazione/indexreg.php">
                    <button type="submit" name="indietro">RITORNA ALLA PAGINA DI REGISTRAZIONE</button>
                </form>
            </div>
        </div>
    </body>
    </html>
  <?php
}
?>
