<?php
include_once "core/init.php";
$user = new User();
$user->checkCookie();
if(!$user->isLoggedIn()){
    Redirect::to('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome to the admin area, <?php echo escape($user->data()->username); ?>!</h1>
    </header>
    <main>
        <ul>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </main>
</body>
</html>