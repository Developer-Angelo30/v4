<?php
require_once("../model/subject.model.php");
require_once("../include/logs/log.php");
require_once("../include/validation/validation.php");

$validation = new Validation;


$log = new Log;
$validation = new Validation;

class SubjectController extends SubjectModel{

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function AddSubjects(){
        return $this->AddSubject();
    }


}

$actionKey = $_POST['action-key'];
$key = array("AddSubjects" );

if(!empty($actionKey) && in_array($actionKey, $key)){

    $controller = new SubjectController(new Log);

    switch($actionKey){
        //createSuperAdmin
        case "AddSubjects":{
            $code = $_POST['code'];
            $name = $_POST['name'];
            $year = $_POST['year'];
            $semester = $_POST['semester'];
            $laboratory = $_POST['laboratory'];
            $slot = $_POST['slot'];
            $hasError = false;

            foreach($code as $index=>$value){

                if($code[$index] == ""){
                    echo json_encode(array("status"=>false, "error"=>"code", "message"=>"This Field Required", "slot"=>$slot[$index]));
                    $hasError = true;
                    break;
                }
                else{
                    if(strlen($code[$index]) >= 20){
                        echo json_encode(array("status"=>false, "error"=>"code", "message"=>"20 max letters.", "slot"=>$slot[$index]));
                        $hasError = true;
                        break;
                    }
                    
                }

                if($name[$index] == ""){
                    echo json_encode(array("status"=>false, "error"=>"name", "message"=>"This Field Required", "slot"=>$slot[$index]));
                    $hasError = true;
                    break;
                }

                if($year[$index] == ""){
                    echo json_encode(array("status"=>false, "error"=>"name", "message"=>"This Field Required", "slot"=>$slot[$index]));
                    $hasError = true;
                    break;
                }

                if($semester[$index] == ""){
                    echo json_encode(array("status"=>false, "error"=>"name", "message"=>"This Field Required", "slot"=>$slot[$index]));
                    $hasError = true;
                    break;
                }

            }

            if(!$hasError){

                $errorDuplicate = false;

                for($i = 0; $i < count($code); $i++){
                    for($x= $i; $x < count($code); $x++ ){
                        if($code[$i] == $code[$x]){
                            $errorDuplicate = true;
                            echo json_encode(array("status"=>false, "message"=>"Duplicate subject code please review the input"));
                            break;
                        }
                    }
                }

                if(!$errorDuplicate){

                    $lab = array_map(function($value)use($conn){
                        if(!$value){
                            return 0;
                        }
                        return 1;
                        
                    }, $laboratory);

                    $controller->setCode($code);
                    $controller->setName($name);
                    $controller->setYear($year);
                    $controller->setSemester($semester);
                    $controller->setLaboratory($lab);
                    $controller->setSlot($slot);
                    echo $controller->AddSubjects();

                }
            }
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
