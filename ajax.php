<?php

function sendresponse($action, $data) {
  header('Content-Type: application/json;charset=utf-8');
  echo json_encode(['action' => $action, 'data' => $data]);
  die;
}

include dirname(__FILE__).'/database.php';
$project = getcurrentproject();


if (!$project) {
  sendresponse('changepage', 'selectproject'); 
}


$post = json_decode(file_get_contents('php://input'), true);

switch ($post["action"]) {
  case "addtask":
    addtask($project["PID"], $post["data"]["name"],$post["data"]["description"],$post["data"]["difficulty"]);
  break;
  case "passtask":
    passtask($project["PID"], $project["currenttask"]);
  break;
  case "donetask":
    donetask($project["PID"], $project["currenttask"]);
  break;
}

$task = getcurrenttask($project["currenttask"]);
$state = "";

if (!$task) {
  $state = "grey ";
  $task = [
    "taskname" => "No task availabe",
    "description" => "Check the freezed tasks list or add a new task if this project isn't done yet.",
    "done" => 0,
    "timeunits" => 0,
    "ttlunits" => 0,
    "usedunits" => 0,
    "freezed" => 0,
    "difficulty" => 0,
    "dependentscount" => 0,
    "passed" => 0,
    "notask" => 1
  ];
}

if ($task["done"]==0 && $task["passed"]>2*$task["difficulty"]) {//hard coded for testing
  $state = "red";
}

$state .= ($task["done"]==1?" done":"").($task["freezed"]==1?" freezed":"");


$task['state'] = $state;
sendresponse('updatedata', ['project' => $project, 'task' => $task]);


