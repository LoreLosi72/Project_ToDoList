<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSERIMENTO EVENTI</title>
    <link rel="stylesheet" href="styleinsert.css">
</head>
<body>
<form method="post" action="insert.php">
        <h1>INSERIMENTO EVENTI</h1>
        <input type="text" id="nome" placeholder="Nome" name="Nome" maxlength="255" required>
        <input type="date"  name="Data_impegno" required>
        <div id="buttoncontainer">
            <button type="submit" name="insert">Conferma Inserimento</button>
        </div>
    </form>
    
</body>
</html>