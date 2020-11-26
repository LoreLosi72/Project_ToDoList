<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRAZIONE</title>
    <link rel="stylesheet" href="stylelog.css">
</head>
<body>
    <form method="post" action="registrazione.php">
        <h1>REGISTRAZIONE</h1>
        <input type="text" id="username" placeholder="username" name="username" maxlength="50" required>
        <input type="password" id="password" placeholder="password" name="password" required>
        <div id="buttoncontainer">
            <button type="submit" name="register">Registrati</button>
        </div>
    </form>
</body>
</html>