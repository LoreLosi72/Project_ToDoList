<?php
include_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>AGENDA</title>
<meta charset="utf-8">
<link rel="stylesheet" href="stylepr.css">
<script src="../js/jquery.min.js"></script>
</head>
<body>
	<div id="calendar_div">
		<?php echo Genera_Calendario(); ?>
	</div>
</body>
</html>