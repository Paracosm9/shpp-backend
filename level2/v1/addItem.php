<?php

$newData = json_decode(file_get_contents("/assets/jsonAddInput.json"), true);
$oldData = getJsonFromText();
$assArrayWithData = createNewArray($oldData, $newData);
file_put_contents("/assets/jsonGet.json", json_encode($assArrayWithData));
$getIdForNewFile = $assArrayWithData["items"][count($assArrayWithData["items"]) - 1]["id"];
$idArray = array("id" => $getIdForNewFile);
file_put_contents("/assets/jsonAddOutput.json", json_encode($idArray));
return file_get_contents("/assets/jsonAddOutput.json");

function getJsonFromText()
{
    $var = "php://input";
    $arrayFromUser = json_decode(file_get_contents("/assets/jsonGet.json"), true);
    return $arrayFromUser;
}

function createNewArray($old, $new)
{
    $readId = readId();
    $newPart = $new["text"];
    $newArray = array(
        "id" => $readId,
        "text" => $newPart,
        "checked" => true
    );
    $bigJsonArray = null;
    if ($old["items"] !== null) {
        array_push($old["items"], $newArray);
    } else {
        $bigJsonArray = array(
            "items" => array(
                0 => $newArray
            )
        );
        $old = $bigJsonArray;
    }

    print_r($old);
    return $old;
}


/**
 * Reads id from file, for adding new.
 * @return mixed|string
 */
function readId()
{
    $id = file_get_contents(("idChange.txt"), true);
    $splitted = preg_split("/[=]/", $id);
    $newId = intval($splitted[1]) + 1;
    file_put_contents("idChange.txt", $splitted[0] . "=" . $newId);
    return $splitted[1];
}