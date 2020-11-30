<?php
/*CREDENZIALI DEL DATABASE, DOVRANNO ESSERE MODIFICATE QUANDO SI UTILIZZERA UN'ALTRA MACCHINA*/
$host     = 'localhost';
$username ='calendar';
$password = '';
$name     = 'calendar';

$db = new mysqli($host, $username, $password, $name);

if ($db->connect_error) {
    die("Connessione fallita: " . $db->connect_error);
}