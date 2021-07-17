<?php
include_once "core/init.php";
$user = new User();
$user->checkCookie();
if(!$user->isLoggedIn()){
    Redirect::to('login.php');
}
if(Session::exist('success')){
    echo Session::flash('success');
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
        <h1>Welcome to the admin area, <?php echo escape($user->data()->name); ?>!</h1>
    </header>
    <main>
        <ul>
            <li><a href="update.php">Name change</a></li>
            <li><a href="changepassword.php">Password change</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </main>
</body>
</html>