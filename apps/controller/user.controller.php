<?php
require_once("../model/user.model.php");
require_once("../include/logs/log.php");
require_once("../include/validation/validation.php");
require_once("../include/auth/Hash.php");
require_once("../Email/email.php");

$validation = new Validation;


$log = new Log;
$validation = new Validation;

class UserController extends UserModel{

    public function __construct(Log $log, Hash $hash, Email $mailer)
    {
        $this->log = $log;
        $this->hash = $hash;
        $this->mailer = $mailer;
    }

    public function createSuperAdmins(){
        return $this->createSuperAdmin();
    }

    public function createDeans(){
        return $this->createDean();
    }

    public function actualAccountUpdates(){
        return $this->actualAccountUpdate();
    }

    public function deleteAccounts(){
        return $this->deleteAccount();
    }

}

$actionKey = $_POST['action-key'];
$key = array("createAccountSuperAdmins","createAccountDeans" , "actualAccountUpdates" , "deleteAccounts" );

if(!empty($actionKey) && in_array($actionKey, $key)){

    $controller = new UserController(new Log, new Hash, new Email);

    switch($actionKey){
        //createSuperAdmin
        case "createAccountSuperAdmins":{
            $controller->setEmail($_POST['email']);
            $controller->setFullname($_POST['fullname']);
            echo $controller->createSuperAdmins();
            break;
        }
        //createDean
        case "createAccountDeans":{
            $controller->setEmail($_POST['email']);
            $controller->setFullname($_POST['fullname']);
            $controller->setDepartment($_POST['department']);
            echo $controller->createDeans();
            break;
        }
        case "actualAccountUpdates":{
            $controller->setID($_POST['id']);
            $controller->setEmail($_POST['email']);
            $controller->setFullname($_POST['fullname']);
            echo $controller->actualAccountUpdates();
            break;
        }
        case "deleteAccounts":{
            $controller->setID($_POST['id']);
            echo $controller->deleteAccounts();
            break;
        }
        default: {
            $log->saveLog( "../../log.log" , "Action-key not found!");
            die(json_encode(array("status"=>false , "error"=>"global", "message"=>"Action key not found!")));
            break;
        }
    }
}
else{
    $log->saveLog( "../../log.log", "Action-key not found!");
    die(json_encode(array("status"=>false , "error"=>"global", "message"=>"Action key not found!")));
}

?>