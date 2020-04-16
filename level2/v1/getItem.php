<?php
$data = get();
echo json_encode($data);
function get(){
    $arrayFromUser = json_decode(file_get_contents("/assets/jsonGet.json"), true);
    return $arrayFromUser;
}
