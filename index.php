<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function autoloader($classname) {
    $filename = "./classes/" . $classname . ".php";
    
    try {
        include $filename;
    }
    catch (Exception $e) {
        echo $e->getMessage(), "\n";
    }
}
spl_autoload_register("autoloader");

session_start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$todolist = new todolist();

Switch ($request) {
    case '/':
        if (isset($_SESSION['userID'])) {
            $tasks = $todolist->getTodoListTasks($_SESSION['userID'], null, true);

            $todayTasks = array_filter($tasks, function($task) {
                return $task["dueDate"] == date("Y-m-d");
            });
        }
            require_once("./views/home.php");
        break;
    case '/show-lists':
        if (isset($_SESSION['userID'])) {
            $lists = $todolist->getTodoLists($_SESSION['userID']);
            require_once("./views/show-lists.php");
        }
        else {
            header("Location: /");
        }
        break;
    case '/create-list':
        if (isset($_SESSION['userID'])) {
            require_once("./views/create-list.php");
        }
        else {
            header("Location: /");
        }
        break;
    case '/edit-list':
        if (isset($_SESSION['userID'])) {
            $list = $todolist->getTodoList($_GET['listid'], $_SESSION['userID']); 
            $tasks = $todolist->getTodoListTasks($_SESSION['userID'], $_GET['listid']);

            if (!empty($list)) {
                require_once("./views/edit-list.php");
            }
            else {
                header("Location: /");
            }
        }
        else {
            header("Location: /");
        }
        break;
    case '/edit-task':
        if (isset($_SESSION['userID'])) {
            $task = $todolist->getTodoListTask($_GET['taskid']);
            require_once("./views/edit-task.php");
        }
        else {
            header("Location: /");
        }
        break;
    case '/add-task':
        if (isset($_SESSION['userID'])) {
            require_once("./views/create-task.php");
        }
        else {
            header("Location: /");
        }
        break;
    case '/updateTodoListTask':
        if (isset($_SESSION['userID'])) {
            $result = $todolist->updateTodoListTask($_POST['taskid'], $_POST['tasktitle'], $_POST['taskdescription'], $_POST['dueDate']); 
            header("Location: /edit-list?listid=".$_POST['listid']);
        }
        else {
            header("Location: /");
        }
        break;
    case '/taskDoneToggle':
        if (isset($_SESSION['userID'])) {
            $todolist->taskDoneToggle($_POST['taskid']);
        }
        else {
            header("Location: /");
        }
        break;
    case '/allTasksDone':
        if (isset($_SESSION['userID'])) {
            $todolist->allTasksDone($_POST['listid']);
        }
        else {
            header("Location: /");
        }   
        break;
    case '/deleteTasksDone':
        if (isset($_SESSION['userID'])) {
            $todolist->deleteTasksDone($_POST['listid']);
        }
        else {
            header("Location: /");
        }   
        break;
    case '/addTodoList':
        if (isset($_SESSION['userID'])) {
            $listid = 0;
            $listid = $todolist->addTodoList($_POST['listtitle'], $_POST['listdescription'], $_SESSION['userID']);
            header("Location: /add-task?listid=".$listid);
        }
        else {
            header("Location: /");
        }
        break;
    case '/addTodoListTask':
        if (isset($_SESSION['userID'])) {
            $todolist->addTask($_POST['listid'], $_POST['tasktitle'], $_POST['taskdescription']);
            header("Location: /edit-list?listid=".$_POST['listid']);
        }
        else {
            header("Location: /");
        }
        break;
    case '/deleteTask':
        if (isset($_SESSION['userID'])) {
            $todolist->deleteTask($_POST['taskid']);
        }
        else {
            header("Location: /");
        }
        break;
    case '/deleteList':
        if (isset($_SESSION['userID'])) {
            $todolist->deleteList($_POST['listid']);
        }
        else {
            header("Location: /");
        }
        break;
    case '/signIn':
        $user = new user($_POST['email']);
        if ($user->userExists()) {
            $user->userLogin();
        }
        else {
            $user->registerUser();
            $user->userLogin();
        }
        header("Location: /");
        break;
    case '/signOut':
        if (isset($_SESSION['userID'])) {
            user::userSignOut();
            header("Location: /");
        }
        else {
            header("Location: /");
        }
        break;
    default:
        echo "No route found for {$request}.";
        break;
}




