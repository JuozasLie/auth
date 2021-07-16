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