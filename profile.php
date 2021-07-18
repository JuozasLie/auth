<?php
require_once 'core/init.php';
$user = new User();
$user->checkCookie();
if(!$username = Input::get('user')){
    Redirect::to('dashboard.php');
} else {
    if(!$user->exists() || $user->data()->id !== Session::get(Config::get('session/session_name'))){
        Redirect::to('dashboard.php');
    } else {
        $data = $user->data();
    }
}
?>
<h1>Hi <?php echo $data->username ?></h1>
<h2>Hi <?php echo $data->name ?></h2>
<h3>Hi <?php echo $user->getType() ?></h3>

