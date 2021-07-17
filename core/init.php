<?php 

session_start();
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'auth'
    ),
    'remember' => array(
        'cookie_name' => 'remember_me',
        'cookie_expiry' => 2592000

    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
);

spl_autoload_register(function($name){
    require_once("classes/{$name}.php");
});

require_once('functions/sanitize.php');

//if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exist(Config::get('session/session_name'))){
//    $hash = Cookie::get(Config::get('remember/cookie_name'));
//    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
//    if($hashCheck->count()){
//        $user = new User($hashCheck->first()->user_id);
//        $user->login();
//    }
//}