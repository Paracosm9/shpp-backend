<?php
if (!isset($_SESSION)) {
    session_start();
}
unset ($_SESSION['hash']);
setcookie("hash", time() - 60);
$_SESSION = array();
session_destroy();
echo json_encode(['ok' => true]);