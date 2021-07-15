<?php 
require_once('core/init.php');
$db = DB::getInstance();
$db->get('users', ["username", "=", "juozas"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/index.css" type="text/css">
    <title>Login and register</title>
</head>
<body>
    <header>
        <h1>Login and register system</h1>
    </header>
    <main>
        <div>
            <a href="login.php">Click here to login in!</a>
        </div>
        <div>
            <a href="register.php">Click here to register!</a>
        </div>
    </main>
</body>
</html>