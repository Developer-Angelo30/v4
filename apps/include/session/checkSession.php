<?php

include("./database/connection.php");
class mySession extends DB {

    public $email;
    public $password;
    public $role;
    public $department;

    public function __construct($email,$password,$role,$department)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->department = $department;
    }

    public function checkSession(){

        $check = $this->read("users", array(
                                "userEmail"=>$this->email,
                                "userPassword"=>$this->password,
                                "userRole"=>$this->role,
                                "userDepartment"=>$this->department
                             ));

        if(is_array($check)){
            $role = $check[0]['userRole'];
            switch($role){
                case 1:{
                    header("location: ./dean/dashboard.php");
                    break;
                }
                case 2:{
                    header("location: ./superadmin/dashboard.php");
                    break;
                }
                default:{
                    header("location: ./admin/dashboard.php");
                    break;
                }
            }
        }
        else{
            header("location: logout.php");
        }
    }

}

?>