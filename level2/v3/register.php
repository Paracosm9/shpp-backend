<?php
require __DIR__.'/PdoProcess.php';
$new_user = json_decode(file_get_contents('php://input'), true);
$name = $new_user["login"];
$pass = $new_user["pass"];
$pdo = new PdoProcess();
echo $pdo->register($name, $pass);