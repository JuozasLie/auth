<?php 
require_once('core/init.php');
$insert = DB::getInstance();
if(!$insert->update('users', ["id", "=", 4], [
        "name" => "Juozasss"
])){
    echo "oops";
} else {
    echo "OK!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/index.css">
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