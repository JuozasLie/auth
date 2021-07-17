<?php
class Hash {
    public static function make($string){
        return password_hash($string, PASSWORD_DEFAULT);
    }
    public static function reMake($hash){
        return password_needs_rehash($hash, PASSWORD_DEFAULT);
    }
    public static function check($string, $hash){
        return password_verify($string, $hash);
    }
}