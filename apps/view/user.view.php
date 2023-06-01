<?php
header('Content-Type: application/json');
require_once("../model/user.model.php");
require_once("../include/auth/Hash.php");
require_once("../include/logs/log.php");
require_once("../include/validation/validation.php");

$log = new Log;
$validation = new Validation;


class UserView extends UserModel {

    public function __construct(Hash $hash, Log $log  )
    {
        $this->hash = $hash;
        $this->log = $log;
    }

    public function loginAccounts(){
        return $this->loginAccount();
    }

    public function readAccounts(){
        return $this->readAccount();
    }

    public function showDataAccountUpdates(){
        return $this->showDataAccountUpdate();
    }


}

$actionKey = $_POST['action-key'];
$key = array("loginAccounts" , "readAccounts" , "showDataAccountUpdates" );

if(!empty($actionKey) && in_array($actionKey, $key)){

    $view = new UserView(new Hash , new Log);

    switch($actionKey){
        case "loginAccounts":{

            $email = $_POST['email'];
            $password = $_POST['password'];

            if(!empty($email)){
                if(!empty($_POST['password'])){
                    if($validation->email($email)!= false){
                        if(strlen($password) >= 8){
                            $view->setEmail($email);
                            $view->setPassword($password);
                            echo $view->loginAccounts();
                        }
                        else{
                            echo json_encode(array("status"=>false, "error"=>"password", "message"=>"Password must be atleast 8 charaters."));
                        }
                    }
                    else{
                        echo json_encode(array("status"=>false, "error"=>"email" , "message"=>"Please input valid email address." ));
                    }
                }
                else{
                    echo json_encode(array("status"=>false, "error"=>"password" , "message"=>"This field is required." ));
                }
            }
            else{
                echo json_encode(array("status"=>false, "error"=>"email" , "message"=>"This field is required." ));
            } 

            break;

        }
        case "readAccounts":{
            echo $view->readAccounts();
            break;
        }
        case "showDataAccountUpdates":{
            $view->setID($_POST['id']);
            echo  $view->showDataAccountUpdates();
            break;
        }
        default: {
            $log->saveLog( "../../log.log" , "Action-key not found!");
            die("action key not found");
            break;
        }
    }
}
else{
    $log->saveLog("../../log.log", "Action-key not found!");
    die("action key not found");
}

?>