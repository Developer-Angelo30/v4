<?php
session_start();
require("../database/connection.php");

class UserModel extends DB {

    private $id;
    private $email;
    private $fullname;
    private $password;
    private $role;
    private $department;

    protected $log;
    protected $hash;
    protected $mailer;

    protected function loginAccount(){

        try{
            $current_time = date('Y-m-d H:i');
            $new_time = date('Y-m-d H:i', strtotime($current_time . ' +3 minutes'));
            
            $email = mysqli_real_escape_string($this->DBconnection(), $this->getEmail());
            $password = mysqli_real_escape_string($this->DBconnection(), $this->getPassword());

            $usersSQL = "SELECT users.* , attempts.* FROM users INNER JOIN attempts ON users.userID = attempts.userID WHERE  users.userEmail = '$email' ";
            $userResult = $this->DBconnection()->query($usersSQL);

            if($userResult->num_rows > 0){
                $users = $userResult->fetch_assoc();

                $attempt =  $users['attempt'];
                if($this->hash->customDehash($password ,  $users['userPassword'] )){

                    if($attempt != 0){

                        $_SESSION['fullname'] = $users['userFullname'];
                        $_SESSION['email'] = $users['userEmail'] ;
                        $_SESSION['password'] = $users['userPassword'] ;
                        $_SESSION['role'] = $users['userRole'] ;
                        $_SESSION['department'] = $users['userDepartment'] ;
                        $reset = $this->update('attempts', array("attempt"=>3),  array("userID"=>$users['userID']));
                        
                        switch($users['userRole']){
                            case 1:{
                                $output = json_encode(array("status"=>true,  "location"=>"./dean/dashboard.php"));
                                break;
                            }
                            case 2:{
                                $output = json_encode(array("status"=>true,  "location"=>"./superadmin/dashboard.php"));
                                break;
                            }
                            default:{
                                $output = json_encode(array("status"=>true,  "location"=>"./admin/dashboard.php"));
                                break;
                            }
                        }
                    }
                    else{
                        if(strtotime($current_time) >= strtotime($users['attempt_date'])){
                            $_SESSION['fullname'] = $users['userFullname'];
                            $_SESSION['email'] = $users['userEmail'] ;
                            $_SESSION['password'] = $users['userPassword'] ;
                            $_SESSION['role'] = $users['userRole'] ;
                            $_SESSION['department'] = $users['userDepartment'] ;
                            $reset = $this->update('attempts', array("attempt"=>3),  array("userID"=>$users['userID']));
                            
                            switch($users['userRole']){
                                case 1:{
                                    $output = json_encode(array("status"=>true,  "location"=>"./dean/dashboard.php"));
                                    break;
                                }
                                case 2:{
                                    $output = json_encode(array("status"=>true,  "location"=>"./superadmin/dashboard.php"));
                                    break;
                                }
                                default:{
                                    $output = json_encode(array("status"=>true,  "location"=>"./admin/dashboard.php"));
                                    break;
                                }
                            }
                        }
                        else{
                            $output = json_encode(array("status"=>false, "error"=>"global" , "message"=>"Please ty again , ".date("h:i A", strtotime($users['attempt_date']))));
                        }
                    } 
                }   
                else{
                    
                    if($attempt != 0){
                        $newValue = $attempt - 1;
                        $updateAttempt = $this->update('attempts', array("attempt"=>$newValue, "attempt_date"=>$new_time), array("userID"=>$users['userID']));
                        if($updateAttempt){
                            $output = json_encode(array("status"=>false, "error"=>"password" , "message"=>"Password not matched. $newValue attempt left"));
                        }
                    }
                    else{
                        if(strtotime($current_time) >= strtotime($users['attempt_date'])){
                            $reset = $this->update('attempts', array("attempt"=>2),  array("userID"=>$users['userID']));
                            if($reset){
                                $output = json_encode(array("status"=>false, "error"=>"password" , "message"=>"Password not matched. 2 attempt left"));
                            }
                        }
                        else{
                            $output = json_encode(array("status"=>false, "error"=>"global" , "message"=>"Please try again , ".date("h:i A", strtotime($users['attempt_date']))));
                        }
                    }

                }  
            }
            else{
                $output = json_encode(array("status"=>false, "error"=>"email" , "message"=>"Please double check you email"));
            }

        }
        catch(mysqli_sql_exception $mysqli_error){
            $this->log->saveLog("../../log.log", $mysqli_error);
            die("system error");
        }

        $this->DBclose($this->DBconnection());
        return $output;
    }

    protected function createSuperAdmin(){
        
        $userDepartment = $_SESSION['department'];
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sendPassword = substr(str_shuffle($chars), 0, 12);

        $email = $this->getEmail();
        $fullname = $this->getFullname();
        $password =  $this->hash->customHash($sendPassword);
        
        $checkEmail = $this->DataCheck('users', array("userEmail"=>$email));
        if(!$checkEmail){
            $this->mailer->sendPassword($this->getEmail(), $this->getFullname(), $sendPassword , $userDepartment );
            $createAccount = $this->create("users", array(
                    "userEmail"=>$email,
                    "userFullname"=>$fullname,
                    "userPassword"=>$password,
                    "userRole"=>2,
                    "userDeleted"=>1,
                    "userDepartment"=>$userDepartment
                ));

            $read = $this->read('users', array("userEmail"=> $email ));
            $userID = $read[0]['userID'];
            
            $createAttempt = $this->create('attempts', array("attempt"=> 3 , "attempt_date"=>date("Y-m-d H:i:s" ) , "userID"=>$userID ));

            if(is_bool($createAttempt)){
                return json_encode(array("status"=>true, "message"=>"Successfuly Created!"));
            }
            else{
                $this->log->saveLog("../../log.log", "Create account problems: $createAttempt ");
            }
        }
        else{
            return json_encode(array("status"=>false, "message"=>"This email is already registered."));
        }

    }

    protected function createDean(){
        
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sendPassword = substr(str_shuffle($chars), 0, 12);

        $userDepartment = $_SESSION['department'];

        $email = $this->getEmail();
        $fullname = $this->getFullname();
        $department = $this->getDepartment();
        $password =  $this->hash->customHash($sendPassword);
        
        $checkEmail = $this->DataCheck('users', array("userEmail"=>$email));
        if(!$checkEmail){

            $checkDepartment = $this->DataCheck('users' , array("userDepartment"=>$department, "userRole"=>1));

            if(!$checkDepartment || $department === $userDepartment ){
                $this->mailer->sendPassword($this->getEmail(), $this->getFullname(), $sendPassword , $department );
                $createAccount = $this->create("users", array(
                        "userEmail"=>$email,
                        "userFullname"=>$fullname,
                        "userPassword"=>$password,
                        "userRole"=>1,
                        "userDeleted"=>1,
                        "userDepartment"=>$department
                    ));

                $read = $this->read('users', array("userEmail"=> $email ));
                $userID = $read[0]['userID'];
            
                $createAttempt = $this->create('attempts', array("attempt"=> 3 , "attempt_date"=>date("Y-m-d H:i:s" ) , "userID"=>$userID ));

                if(is_bool($createAttempt)){
                    return json_encode(array("status"=>true, "message"=>"Successfuly Created!"));
                }
                else{
                    $this->log->saveLog("../../log.log", "Create account problems: $createAttempt ");
                }
            }
            else{
                return json_encode(array("status"=>false, "message"=>"You dont have permission to create account in this Department"));
            } 
        }
        else{
            return json_encode(array("status"=>false, "message"=>"Email is already registered."));
        }

    }

    protected function readAccount(){
        $userDepartment = $_SESSION['department'];

        $account = $this->read('users',array( "userRole"=>2 ,"userDepartment"=>$userDepartment , "userDeleted"=>1));
        if(is_array($account) || is_bool($account) ){
            return json_encode($account);
        }
        else{
            $this->log->saveLog("../../log.log", "Fetch Data account problems: $account ");
        }
    }

    protected function showDataAccountUpdate(){
        $id = $this->getID();
        $account = $this->read("users", array("userID"=>$id , "userDeleted"=>1) );
        if(is_array($account) || is_bool($account) ){
            return json_encode($account);
        }
        else{
            $this->log->saveLog("../../log.log", "Fetch Data Edit account problems: $account ");
        }
    }

    protected function actualAccountUpdate(){
        $id = $this->getID();
        $email = $this->getEmail();
        $fullname = $this->getFullname();
        $update = $this->update("users", array("userEmail"=>$email , "userFullname"=>$fullname ), array("userID"=>$id));
        if(is_bool($update)){
            return json_encode(array("status"=>true, "message"=>"Successfuly Updated."));
        }
        else{
            $this->log->saveLog("../../log.log", "Update account problems: $update ");
        }
        
    }

    protected function deleteAccount(){
        $id = $this->getID();
        $delete = $this->delete("users", array("userID"=>$id , "userDeleted"=>1));
        if(is_bool($delete)){
            return json_encode(array("status"=>true, "message"=>"Successfuly Deleted. $id "));
        }        
        else{
            $this->log->saveLog("../../log.log", "Delete account problems: $delete ");
        }
    }

    public function setID(int $id):void{
        $this->id = $id;
    } 

    protected function getID():int{
        return $this->id;
    }

    public function setEmail($email):void{
        $this->email = $email;
    } 

    protected function getEmail():string{
        return $this->email;
    }

    public function setFullname($fullname):void{
        $this->fullname = $fullname;
    } 

    protected function getFullname():string{
        return $this->fullname;
    }

    public function setPassword($password):void{
        $this->password = $password;
    } 

    protected function getPassword():string{
        return $this->password;
    }

    public function setRole($role):void{
        $this->role = $role;
    } 

    protected function getRole():string{
        return $this->role;
    }

    public function setDepartment($department):void{
        $this->department = $department;
    } 

    protected function getDepartment():string{
        return $this->department;
    }
}

?>

