<?php
namespace App;

class Config
{
    public static  $host, $email, $pass, $dateFormat, $maxEmails, $shown;
    private static $path = "../config.json";
    
    public static function read(){
        $file = fopen(Config::$path, "r");
        $configs = json_decode(fread($file, filesize(Config::$path)));
        
        Config::$host = $configs->host != '' ? $configs->host : '{imap.gmail.com:993/imap/ssl}INBOX';
        Config::$email = $configs->email != '' ? $configs->email : '';
        Config::$pass = $configs->password != '' ? $configs->password : '';
        Config::$dateFormat = $configs->dateFormat != '' ? $configs->dateFormat : 'd/m/Y';
        Config::$maxEmails = isset($configs->maxEmails) ? $configs->maxEmails : 20;
        Config::$shown = isset($configs->shown) ? $configs->shown : 50;
        
        fclose($file);
    }
}