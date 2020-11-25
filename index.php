<?php
include_once 'function.php';
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
<title>CALENDARIO</title>
<meta charset="utf-8">
<link rel ="stylesheet" href="style.css">
<script src="jquery.min.js"></script>
</head>

<body>
	<div id="calendar_div">
		<?php echo Genera_Calendario(); ?>
	</div>
</body>
</html>