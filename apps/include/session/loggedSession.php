<?php
include_once("../database/connection.php");

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

    public function loggedSessionDean(){

        $check = $this->read("users", array(
                                "userEmail"=>$this->email,
                                "userPassword"=>$this->password,
                                "userRole"=>$this->role,
                                "userDepartment"=>$this->department
                            ));
        if(is_array($check)){
            $role = $check[0]['userRole'];
            if((int)$role != 1){
                if((int)$role === 2){
                    header("location: ../superadmin/dashboard.php");
                }
                
                if((int)$role === 3){
                    header("location: ../admin/dashboard.php");
                }
            }
        }
        else{
            header("location: ../logout.php");
        }
    }

    public function loggedSessionSuperAdmin(){

        $check = $this->read("users", array(
                                "userEmail"=>$this->email,
                                "userPassword"=>$this->password,
                                "userRole"=>$this->role,
                                "userDepartment"=>$this->department
                            ));
        if(is_array($check)){
            $role = $check[0]['userRole'];
            if($role != 2){
                if((int)$role === 1){
                    header("location: ../dean/dashboard.php");
                }
                
                if((int)$role === 3){
                    header("location: ../admin/dashboard.php");
                }
            }
        }
        else{
            header("location: ../logout.php");
        }
    }

    public function loggedSessionAdmin(){

        $check = $this->read("users", array(
                                "userEmail"=>$this->email,
                                "userPassword"=>$this->password,
                                "userRole"=>$this->role,
                                "userDepartment"=>$this->department
                            ));
        if(is_array($check)){
            $role = $check[0]['userRole'];
            if($role != 3){
                if((int)$role === 1){
                    header("location: ../dean/dashboard.php");
                }
                
                if((int)$role === 2){
                    header("location: ../superadmin/dashboard.php");
                }
            }
        }
        else{
            header("location: ../logout.php");
        }
    }
}

?>