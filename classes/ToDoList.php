<?php

/*
This class handles the todolist actions (Create, read, update and delete lists and tasks).
*/

class ToDoList {
    //Returns an array with all lists owned by the signed in user 
    public function getTodoLists($userID) :array {
        $result = array();
        $db = new Database();

        $result = $db->get('* FROM `lists` WHERE `userID`=:userID', array(':userID' => $userID));
        
        return $result;
    }

    //Returns an array with a specific list depending on provided listID
    public function getTodoList($listID, $userID) :array {
        $result = array();
        $db = new Database();

        $result = $db->get('* FROM `lists` WHERE `ID`=:ID AND `userID`=:userID', array(':ID' => $listID, ':userID' => $userID), false);
        
     return $result;
    }

    //Returns an array with tasks from a list, if listID is provided. Otherwise all tasks owned by signed in user will be returned. If $filterDone is true, only tasks which has done=false will be returned. 
    public function getTodoListTasks($userID, $listID = null, $filterDone = false) :array {
        $result = array();
        $data = array();
        $db = new Database();

        $query = "tasks.ID, tasks.dueDate, tasks.title, tasks.description, tasks.done FROM `tasks` INNER JOIN lists ON (tasks.listID = lists.ID) WHERE lists.userID =:userID";
        

        if ($listID) {
            $query .= " AND lists.ID =:listID";
            $data = array(':userID' => $userID, ':listID' => $listID);
        }
        else {
            $data = array(':userID' => $userID);
        }

        if ($filterDone) {
            $query .= " AND tasks.done=0";
        }

        $query .= " ORDER BY tasks.dueDate";
        $result = $db->get($query, $data);
        
     return $result;
    }

    //Get a single task from its ID
    public function getTodoListTask($taskID) :array {
        $result = array();
        $db = new Database();

        $result = $db->get("dueDate, title, description FROM `tasks` WHERE ID=:taskID", array(":taskID" => $taskID));
        
     return $result;
    }

    //Creates a new list and returns the ID of it 
    public function addTodoList($title, $description, $userID) :int {
        $db = new Database();
        $db->insertInto("`lists` (`ID`, `title`, `description`, `userID`) VALUES (NULL, :title, :description, :userID);", array(":title" => $title, ":description" => $description, ":userID" => $userID));

     return $db->getLastId();
    }

    //Adds a new task to a list
    public function addTask($listID, $title, $description, $dueDate) {
        $db = new Database();
        $db->insertInto("`tasks` (`ID`, `listID`, `dueDate`, `title`, `description`, `done`) VALUES (NULL, :listID, :dueDate, :title, :description, '0');", array(":listID" => $listID, ':title' => $title , ':description' => $description, ':dueDate' => $dueDate));
    }

    //Updates a task
    public function updateTodoListTask($taskID, $title, $description, $dueDate) {
        $db = new Database();
        $db->update("`tasks` set title=:title, description=:description, dueDate=:dueDate WHERE ID=:ID", array(":title" => $title, ":description" => $description, ":dueDate" => $dueDate, ":ID" => $taskID));
    }

    //Toggles done, true and false on a task
    public function taskDoneToggle($taskID) {
        $result = array();
        $db = new Database();
        
        $result = $db->get("done from `tasks` WHERE ID=:ID", array(":ID" => $taskID), false);
        $done = ($result["done"]) ? 0 : 1;
        $db->update("`tasks` set done=:done WHERE ID=:ID", array(":ID" => $taskID, ":done" => $done));
    }

    //Setts every tasks in a list to done
    public function allTasksDone($listID) {
        $db = new Database();
        $db->update("`tasks` set done=1 WHERE listID=:listID", array(":listID" => $listID));
    }

    //Deletes every task in a list where done = true
    public function deleteTasksDone($listID) {
        $db = new Database();
        $db->delete("`tasks` WHERE listID=:listID AND done=1", array(":listID" => $listID));
    }

    //Deletes a task depending on taskID
    public function deleteTask($taskID) {
        $db = new Database();
        $db->delete("`tasks` WHERE ID=:ID", array(":ID" => $taskID));
    }

    //Deletes a list depending on listID
    public function deleteList($listID) {
        $db = new Database();
        $db->delete("`lists` WHERE ID=:ID", array(":ID" => $listID));
    }
}