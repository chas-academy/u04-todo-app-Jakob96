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
$toDoList = new ToDoList();
$pageTitle = "";

Switch ($request) {
    case '/':
        if (isset($_SESSION['userID'])) {
            $tasks = $toDoList->getTodoListTasks($_SESSION['userID'], null, true);

            $todayTasks = array_filter($tasks, function($task) {
                return $task["dueDate"] == date("Y-m-d");
            });

            $pageTitle = "Mina aktiviteter";
            require_once("./views/home.php");
        }
        else {
            header("Location: /sign-in");
        }   
        break;
    case '/sign-in':
        if (!isset($_SESSION['userID'])) {
            $pageTitle = "Logga in";
            require_once("./views/sign-in.php");
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/show-lists':
        if (isset($_SESSION['userID'])) {
            $lists = $toDoList->getTodoLists($_SESSION['userID']);

            $pageTitle = "Mina listor";
            require_once("./views/show-lists.php");
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/create-list':
        if (isset($_SESSION['userID'])) {
            $pageTitle = "Skapa ny Att göra-lista";
            require_once("./views/create-list.php");
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/edit-list':
        if (isset($_SESSION['userID'])) {
            $list = $toDoList->getTodoList($_GET['listid'], $_SESSION['userID']); 
            $tasks = $toDoList->getTodoListTasks($_SESSION['userID'], $_GET['listid']);

            if (!empty($list)) {
                $pageTitle = $list["title"];
                require_once("./views/edit-list.php");
            }
            else {
                header("Location: /");
            }
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/edit-task':
        if (isset($_SESSION['userID'])) {
            $task = $toDoList->getTodoListTask($_GET['taskid']);

            $pageTitle = "Redigera aktivitet";
            require_once("./views/edit-task.php");
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/add-task':
        if (isset($_SESSION['userID'])) {
            $pageTitle = "Lägg till ny aktivitet";
            require_once("./views/create-task.php");
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/updateTodoListTask':
        if (isset($_SESSION['userID'])) {
            $result = $toDoList->updateTodoListTask($_POST['taskid'], $_POST['tasktitle'], $_POST['taskdescription'], $_POST['dueDate']); 
            header("Location: /edit-list?listid=".$_POST['listid']);
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/taskDoneToggle':
        if (isset($_SESSION['userID'])) {
            $toDoList->taskDoneToggle($_POST['taskid']);
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/allTasksDone':
        if (isset($_SESSION['userID'])) {
            $toDoList->allTasksDone($_POST['listid']);
        }
        else {
            header("Location: /sign-in");
        }   
        break;
    case '/deleteTasksDone':
        if (isset($_SESSION['userID'])) {
            $toDoList->deleteTasksDone($_POST['listid']);
        }
        else {
            header("Location: /sign-in");
        }   
        break;
    case '/addTodoList':
        if (isset($_SESSION['userID'])) {
            $listid = 0;
            $listid = $toDoList->addTodoList($_POST['listtitle'], $_POST['listdescription'], $_SESSION['userID']);
            header("Location: /add-task?listid=".$listid);
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/addTodoListTask':
        if (isset($_SESSION['userID'])) {
            $toDoList->addTask($_POST['listid'], $_POST['tasktitle'], $_POST['taskdescription'], $_POST["dueDate"]);
            header("Location: /edit-list?listid=".$_POST['listid']);
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/deleteTask':
        if (isset($_SESSION['userID'])) {
            $toDoList->deleteTask($_POST['taskid']);
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/deleteList':
        if (isset($_SESSION['userID'])) {
            $toDoList->deleteList($_POST['listid']);
        }
        else {
            header("Location: /sign-in");
        }
        break;
    case '/signIn':
        if ($_POST["email"]) {
           $user = new User($_POST['email']);
        
           if ($user->userExists()) {
              $user->userLogin();
           }
           else {
              $user->registerUser();
              $user->userLogin();
           }
        
           header("Location: /");
        }
        else {
            header("Location: /sign-in");
        }
        
        break;
    case '/signOut':
        if (isset($_SESSION['userID'])) {
            user::userSignOut();
            header("Location: /sign-in");
        }
        else {
            header("Location: /");
        }
        break;
    default:
        $pageTitle = "Error 404";
        require_once("./views/404.php");
        break;
}




