<?php
date_default_timezone_set("Asia/Manila");
class Log{

    public function saveLog(string $path, string $message){

        /*
            note
            $_SERVER['REMOTE_ADDR'] may not always provide the actual client IP address, as it can be the IP address of an intermediate server.
            Using $_SERVER['HTTP_CLIENT_IP'] and $_SERVER['HTTP_X_FORWARDED_FOR'] as fallbacks can help capture the real IP address in certain scenarios. 
        */

        $current = date("Y-m-d h:i:s A");
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $msg = "[{$current}], IP: {$ip} , Message: {$message}\n";

        file_put_contents($path,$msg,FILE_APPEND);
    }

}


?>