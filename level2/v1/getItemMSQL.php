<?php
$dbh = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root','Lol123');
$query = $dbh->query('SELECT * FROM ToDo');
echo json_encode($query->fetchAll(2));


