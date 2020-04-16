<?php

switch ($_GET['action']) {
    case 'register':
        include 'register.php';
        break;
    case 'login':
        include 'login.php';
        break;
    case 'addItem':
        include 'addItem.php';
        break;
    case 'changeItem':
        include 'changeItem.php';
        break;
    case 'deleteItem':
        include 'deleteItem.php';
        break;
    case 'getItem' :
        include 'getItem.php';
        break;
    case 'logout':
        include 'logout.php';
        break;
    default:
        header('HTTP1.1 500 Internal Server Error');
        echo json_encode(["error" => 'Something went wrong on server.']);
        exit();
}
