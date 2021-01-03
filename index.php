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
var_dump($_SESSION);
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$todolist = new todolist();

Switch ($request) {
    case '/':
        $tasks = $todolist->getTodoListTasks($_SESSION['userID'], null, true);

        $todayTasks = array_filter($tasks, function($task) {
            return $task["dueDate"] == date("Y-m-d");
        });
        require_once("./views/home.php");
        break;
    case '/show-lists':
        $lists = $todolist->getTodoLists($_SESSION['userID']);
        require_once("./views/show-lists.php");
        break;
    case '/create-list':
        require_once("./views/create-list.php");
        break;
    case '/edit-list':
        $list = $todolist->getTodoList($_GET['listid'], $_SESSION['userID']); 
        $tasks = $todolist->getTodoListTasks($_SESSION['userID'], $_GET['listid']);

        if (!empty($list)) {
            require_once("./views/edit-list.php");
        }
        else {
            header("Location: /");
        }
        break;
    case '/edit-task':
        $task = $todolist->getTodoListTask($_GET['taskid']);
        require_once("./views/edit-task.php");
        break;
    case '/add-task':
        require_once("./views/create-task.php");
        break;
    case '/updateTodoListTask':
        $result = $todolist->updateTodoListTask($_POST['taskid'], $_POST['tasktitle'], $_POST['taskdescription'], $_POST['dueDate']); 
        header("Location: /edit-list?listid=".$_POST['listid']);
        break;
    case '/taskDoneToggle':
        $todolist->taskDoneToggle($_POST['taskid']);
        break;
    case '/allTasksDone':
        $todolist->allTasksDone($_POST['listid']);
        break;
    case '/deleteTasksDone':
        $todolist->deleteTasksDone($_POST['listid']);
        break;
    case '/addTodoList':
        $listid = 0;
        $listid = $todolist->addTodoList($_POST['listtitle'], $_POST['listdescription'], $_SESSION['userID']);
        header("Location: /add-task?listid=".$listid);
        break;
    case '/addTodoListTask':
        $todolist->addTask($_POST['listid'], $_POST['tasktitle'], $_POST['taskdescription']);
        header("Location: /edit-list?listid=".$_POST['listid']);
        break;
    case '/deleteTask':
        $todolist->deleteTask($_POST['taskid']);
        break;
    case '/deleteList':
        $todolist->deleteList($_POST['listid']);
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
        user::userSignOut();
        header("Location: /");
        break;
    default:
        echo "No route found for {$request}.";
        break;
}




