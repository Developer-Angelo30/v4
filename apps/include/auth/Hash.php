<?php

class Hash{

    private $salt = "beba503c09729f48babceb45a7380f28";

    public function customHash($text){
        $combine = $this->salt.$text;
        $generate = password_hash($combine , PASSWORD_BCRYPT);
        return str_replace('$', '::' , $generate);
    }

    public function customDehash($text ,$hashed){
        $combine = $this->salt.$text;
        return password_verify( $combine , str_replace('::','$' , $hashed ));
    }
    
   
} 

?>