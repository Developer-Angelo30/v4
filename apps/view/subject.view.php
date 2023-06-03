<?php
// header('Content-Type: application/json');
require_once("../model/subject.model.php");
require_once("../include/logs/log.php");
require_once("../include/validation/validation.php");

$log = new Log;
$validation = new Validation;


class SubjectView extends SubjectModel {

    public function __construct(Log $log  )
    {
        $this->log = $log;
    }

    public function readSubjects(){
        return $this->readSubject();
    }

    public function showDataSubjectUpdates(){
        return $this->showDataSubjectUpdate();
    }

}

$actionKey = $_POST['action-key'];
$key = array("readSubjects" , "showDataSubjectUpdates" );

if(!empty($actionKey) && in_array($actionKey, $key)){

    $view = new SubjectView(new Log);

    switch($actionKey){
        case "readSubjects":{
            echo $view->readSubjects();
            break;

        }
        case "showDataSubjectUpdates":{
            $view->setCode(array($_POST['code']));
            echo $view->showDataSubjectUpdates();
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