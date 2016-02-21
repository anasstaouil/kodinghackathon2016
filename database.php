<?php 

require_once dirname(__FILE__).'/medoo.php';

global $database;
$database = new medoo([
	'database_type' => 'mysql',
	'database_name' => 'hackaton',
	'server' => 'localhost',
	'username' => 'test',
	'password' => 't3stp@ssw0rd',
	'charset' => 'utf8',
]);

function getcurrentproject() {
    global $database;
    $data = $database->select("projects", ["PID", "projectname","description","onbreak","currenttask"], ["workingon" => 1]);
    
    if (!$data || count($data) == 0) {
        return false;
    }
    
    $all = $database->select("tasks", ["TID"], ["project" => $data[0]["PID"]]);
    
    if (!$all) {
        $data[0]["all"] = 0;
    }
    else {
        $data[0]["all"] = count($all);
    }
    
    $freezed = $database->select("tasks", ["TID"], ["freezed" => 1, "project" => $data[0]["PID"]]);
    
    if (!$freezed) {
        $data[0]["freezed"] = 0;
    }
    else {
        $data[0]["freezed"] = count($freezed);
    }
    
    $green = $database->query('SELECT count(*) FROM tasks WHERE done = 1 AND project = '.$data[0]["PID"]);
    
    if (!$green) {
        $data[0]["done"] = 0;
    }
    else {
        $data[0]["done"] = $green->fetch()[0];
    }
    
    $red = $database->query('SELECT count(*) FROM tasks WHERE passed > 2 * difficulty and project = '.$data[0]["PID"]);
    
    if (!$red) {
        $data[0]["red"] = 0;
    }
    else {
        $data[0]["red"] = $red->fetch()[0];
    }
    
    return $data[0];
}


function getcurrenttask($idfromproject = null) {
    global $database;
    
    if (!$idfromproject) {
        $project = getcurrentproject();
        
        if (!$project) {
            return false;
        }
        
        $idfromproject = $project["currenttask"];
    }
    
    $fields = [
        "TID",
        "taskname",
        "done",
        "description",
        "timeunits",
        "ttlunits",
        "usedtimeunits",
        "freezed",
        "difficulty",
        "passed",
        "project"
        ];
    $data = $database->select("tasks", $fields, ["TID" => $idfromproject]);
    
    if (!$data || count($data) == 0) {
        return false;
    }
    
    $dependents = $database->select("dependencies", ["ID"], ["dependee" => $idfromproject]);
    
    if (!$dependents) {
        $data[0]["dependentscount"] = 0;
    }
    else {
        $data[0]["dependentscount"] = count($dependents);
    }
    
    if ($data[0]["done"] == 1) {
      setcurrenttask(false);
      return getcurrenttask();
    }
    else {
      return $data[0];
    }
}

function addtask($pid,$name,$description,$difficulty) {
  global $database;
  
  $id = $database->insert("tasks", ["taskname"=>$name, "description"=>$description,"passed"=>0,"done"=>0,"freezed"=>0,"difficulty"=>$difficulty,"project"=>$pid]);
  setcurrenttask(true, $id);
}

function setcurrenttask($checkcurrent, $id = -1) {
  global $database;
  $project = getcurrentproject();
  
  if (!$project) {
    return;
  }
  
  if ($project["currenttask"] != -1 && $checkcurrent) {
    $task = getcurrenttask($project["currenttask"]);
    
    if ($task && $task["done"] == 0) {
      return;
    }
  }
  
  $ordered = $database->pdo->prepare('SELECT TID, (difficulty*2-passed) AS score FROM tasks WHERE done = 0 AND project = :project ORDER BY score DESC;');
  $ordered->bindParam(":project",$project["PID"]);
  $ordered->execute();
  $database->update("projects", ["currenttask"=>$ordered->fetch()["TID"]], ["PID" => $project["PID"]]);
}

function passtask($pid, $id) {
  global $database;
  
  $database->update("tasks", ["passed[+]"=>1], ["TID" => $id]);
  setcurrenttask(false);
}

function donetask($pid, $id) {
  global $database;
  
  $database->update("tasks", ["done"=>1], ["TID" => $id]);
  setcurrenttask(false);
}