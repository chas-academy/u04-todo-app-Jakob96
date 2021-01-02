<?php

class todolist {
    public function getTodoLists($userID) {
        $result = '';

        $dbconn = new db();
        $result = $dbconn->get('* FROM `lists` WHERE `userID`=:userID', array('userID' => $userID));
        
        return $result;
    }

    public function getTodoList($listID, $userID) {
        $result = '';

        $dbconn = new db();
        $result = $dbconn->get('* FROM `lists` WHERE `ID`=:ID AND `userID`=:userID', array('ID' => $listID, 'userID' => $userID), false);
        
     return $result;
    }

    public function getTodoListTasks($listID, $userID) {
        $result = '';

        $dbconn = new db();
        $result = $dbconn->get('tasks.ID, tasks.dueDate, tasks.title, tasks.description, tasks.done FROM `tasks` INNER JOIN lists ON (tasks.listID = lists.ID) WHERE lists.userID =:userID AND lists.ID =:listID ORDER BY tasks.dueDate', array(':userID' => $userID, ':listID' => $listID));
        
     return $result;
    }

    public function getTodoListTask($taskID) {
        $result = "";

        $dbconn = new db();
        $result = $dbconn->get("dueDate, title, description FROM `tasks` WHERE ID=:taskID", array(":taskID" => $taskID));
        
     return $result;
    }

    public function addTodoList($title, $description, $userID) {
        $dbconn = new db();
        $dbconn->insertInto("`lists` (`ID`, `title`, `description`, `userID`) VALUES (NULL, :title, :description, :userID);", array(":title" => $title, ":description" => $description, ":userID" => $userID));

     return $dbconn->getLastId();
    }

    public function addTask($listID, $title, $description) {
        $dbconn = new db();
        $dbconn->insertInto("`tasks` (`ID`, `listID`, `dueDate`, `title`, `description`, `done`) VALUES (NULL, :listID, CURRENT_TIMESTAMP, :title, :description, '0');", array(":listID" => $listID, ':title' => $title , ':description' => $description));
    }

    public function updateTodoListTask($taskID, $title, $description, $dueDate) {
        $dbconn = new db();
        $dbconn->update("`tasks` set title=:title, description=:description, dueDate=:dueDate WHERE ID=:ID", array(":title" => $title, ":description" => $description, ":dueDate" => $dueDate, ":ID" => $taskID));
    }

    public function taskDoneToggle($taskID) {
        $dbconn = new db();
        $result = $dbconn->get("done from `tasks` WHERE ID=:ID", array(":ID" => $taskID), false);
        $done = ($result["done"]) ? 0 : 1;
        $dbconn->update("`tasks` set done=:done WHERE ID=:ID", array(":ID" => $taskID, ":done" => $done));
    }

    public function allTasksDone($listID) {
        $dbconn = new db();
        $dbconn->update("`tasks` set done=1 WHERE listID=:listID", array(":listID" => $listID));
    }

    public function deleteTasksDone($listID) {
        $dbconn = new db();
        $dbconn->delete("`tasks` WHERE listID=:listID AND done=1", array(":listID" => $listID));
    }

    public function deleteTask($taskID) {
        $dbconn = new db();
        $dbconn->delete("`tasks` WHERE ID=:ID", array(":ID" => $taskID));
    }

    public function deleteList($listID) {
        $dbconn = new db();
        $dbconn->delete("`lists` WHERE ID=:ID", array(":ID" => $listID));
    }
}