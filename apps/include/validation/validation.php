<?php

class Validation{

    public function email($email){
        return (filter_var($email , FILTER_VALIDATE_EMAIL))? filter_var($email, FILTER_SANITIZE_EMAIL): false;
    }

    public function validate($data, $pattern):bool{
        return preg_match($pattern, $data);
    }

}


?>