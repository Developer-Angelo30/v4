<?php
session_start();
require("../database/connection.php");

class SubjectModel extends DB {

    private array $code;
    private array $name;
    private array $year;
    private array $semester;
    private array $laboratory;
    private array $slot;

    protected $log;

    public function __construct(Log $log )
    {
        $this->log = $log;
    }

    protected function AddSubject(){
        $code = $this->getCode();
        $name = $this->getName();
        $year = $this->getYear();
        $semester = $this->getSemester();
        $laboratory = $this->getLaboratory();
        $department = $_SESSION['department'];

        $duplicates = [];
        $subjects = [];
        
        $sql = "SELECT subCode FROM subjects WHERE subDepartment = '$department'";
        $result = $this->DBconnection()->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subjects[] = $row['subCode'];
            }
        }
        
        foreach ($code as $index => $value) {
            if (in_array($value, $subjects)) {
                $duplicates[] = "#{$this->getSlot()[$index]}, $value already recorded.";
            }
        }
        
        if(empty($duplicates)){
            foreach($code as $key=>$value){
                $insert = $this->create("subjects", array(
                    "subCode"=>$value,
                    "subName"=>$name[$key],
                    "subYear"=>$year[$key],
                    "subSemester"=>$semester[$key],
                    "subLaboratory"=>$laboratory[$key],
                    "subDeleted"=>1,
                    "subDepartment"=>$department
                ));
            }
            $output = json_encode(array('status'=>true, "message"=>"Successfuly Created."));
        }
        else{
            $output =  json_encode(array("status"=>false , "message"=>$duplicates));
        }

        $this->DBclose($this->DBconnection());
        return $output;
        
    }

    protected function readSubject(){
        return json_encode($this->read('subjects'));
    }

    public function showDataSubjectUpdate (){
        $code = $this->getCode()[0];

        $show = $this->read('subjects', array("subCode"=>$code));
        if(is_array($show)){
            return json_encode($show);
        }
        else{
            $this->log->saveLog("../../log.log", $code);
        }
    }

    public function setCode(array $code){
        $this->code = $code;
    }

    protected function getCode(){
        return $this->code;
    }

    public function setName(array $name){
        $this->name = $name;
    }

    protected function getName(){
        return $this->name;
    }

    public function setYear(array $year){
        $this->year = $year;
    }

    protected function getYear(){
        return $this->year;
    }

    public function setSemester(array $semester){
        $this->semester = $semester;
    }

    protected function getSemester(){
        return $this->semester;
    }

    public function setLaboratory(array $laboratory){
        $this->laboratory = $laboratory;
    }

    protected function getLaboratory(){
        return $this->laboratory;
    }

    public function setSlot(array $slot){
        $this->slot = $slot;
    }

    protected function getSlot(){
        return $this->slot;
    }
    
}

?>

