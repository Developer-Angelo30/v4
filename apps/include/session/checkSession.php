<?php
session_start();
include("./database/connection.php");
class mySession extends DB {

    private $email;
    private $password;
    private $role;
    private $department;

    public function __construct($email,$password,$role,$department)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->department = $department;
    }

    public function checkSession(){

        $email =  mysqli_real_escape_string($this->DBconnection(), $this->email);
        $password = mysqli_real_escape_string($this->DBconnection(), $this->password);
        $role = mysqli_real_escape_string($this->DBconnection(), $this->role);
        $department = mysqli_real_escape_string($this->DBconnection(), $this->department);

        $sql = "SELECT * FROM users WHERE userEmail = '$email' AND userPassword = '$password' AND userRole = '$role' AND userDepartment = '$department' ";
        $result = mysqli_query($this->DBconnection(), $sql);
        if(mysqli_num_rows($result) > 0){
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