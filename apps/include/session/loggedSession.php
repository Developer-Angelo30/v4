<?php
session_start();
include_once("../database/connection.php");

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

    public function loggedSessionDean(){

        $email =  mysqli_real_escape_string($this->DBconnection(), $this->email);
        $password = mysqli_real_escape_string($this->DBconnection(), $this->password);
        $role = mysqli_real_escape_string($this->DBconnection(), $this->role);
        $department = mysqli_real_escape_string($this->DBconnection(), $this->department);


        if(isset($_SESSION['email']) || isset($_SESSION['password']) || isset($_SESSION['role']) || isset($_SESSION['department'])) {
            $sql = "SELECT * FROM users WHERE userEmail = '$email' AND userPassword = '$password' AND userRole = '$role' AND userDepartment = '$department' ";
            $result = mysqli_query($this->DBconnection(), $sql);
            if(mysqli_num_rows($result) > 0){
                if($role != 1){
                    if($role == 2){
                        header("location: ../superadmin/dashboard.php");
                    }

                    if($role == 3){
                        header("location: ../admin/dashboard.php");
                    }

                }
            }
            else{
                header("location: ../logout.php");
            }
        }
        else{
            header("location: ../logout.php");
        }
    }

    public function loggedSessionSuperAdmin(){

        $email =  mysqli_real_escape_string($this->DBconnection(), $this->email);
        $password = mysqli_real_escape_string($this->DBconnection(), $this->password);
        $role = mysqli_real_escape_string($this->DBconnection(), $this->role);
        $department = mysqli_real_escape_string($this->DBconnection(), $this->department);

        if(isset($_SESSION['email']) || isset($_SESSION['password']) || isset($_SESSION['role']) || isset($_SESSION['department'])) {
            $sql = "SELECT * FROM users WHERE userEmail = '$email' AND userPassword = '$password' AND userRole = '$role' AND userDepartment = '$department' ";
            $result = mysqli_query($this->DBconnection(), $sql);
            if(mysqli_num_rows($result) > 0){
                if($role != 2){
                    if($role == 1){
                        header("location: ../dean/dashboard.php");
                    }

                    if($role == 3){
                        header("location: ../admin/dashboard.php");
                    }
                }
            }
            else{
                header("location: ../logout.php");
            }
        }
        else{
            header("location: ../logout.php");
        }
    }

    public function loggedSessionAdmin(){

        $email =  mysqli_real_escape_string($this->DBconnection(), $this->email);
        $password = mysqli_real_escape_string($this->DBconnection(), $this->password);
        $role = mysqli_real_escape_string($this->DBconnection(), $this->role);
        $department = mysqli_real_escape_string($this->DBconnection(), $this->department);

        if(isset($_SESSION['email']) || isset($_SESSION['password']) || isset($_SESSION['role']) || isset($_SESSION['department'])) {
            $sql = "SELECT * FROM users WHERE userEmail = '$email' AND userPassword = '$password' AND userRole = '$role' AND userDepartment = '$department' ";
            $result = mysqli_query($this->DBconnection(), $sql);
            if(mysqli_num_rows($result) > 0){
                if($role != 3){
                    if($role == 1){
                        header("location: ../dean/dashboard.php");
                    }
    
                    if($role == 2){
                        header("location: ../superadmin/dashboard.php");
                    }
                }
            }
            else{
                header("location: ../logout.php");
            }
        }
        else{
            header("location: ../logout.php");
        }
    }
}

?>