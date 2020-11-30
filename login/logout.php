<?php
session_start();
session_destroy();
header('Location:../pubblica/index.php');
exit;
?>