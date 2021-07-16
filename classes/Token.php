<?php
class Token {

    public static function generate(){
        return Session::put(Config::get('session/token_name'), bin2hex(random_bytes(12)));
    }
    public static function check($token){
        $tokenName = Config::get('session/token_name');
        if(Session::exist($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}