<?php

changeItem();
echo json_encode(file_get_contents('/assets/jsonChangeOutput.json'),true);
function changeItem()
{
    $dataToFix = json_decode(file_get_contents('php://input'), true);
    $getOldData = json_decode(file_get_contents("/assets/jsonGet.json"), true);

    $newJson = createArrayWithChangedData($getOldData, $dataToFix);
    file_put_contents("/assets/jsonGet.json", json_encode($newJson));
}

function createArrayWithChangedData($oldArray, $dataToFix)
{
    $neededId = $dataToFix["id"];
    $newData = array(
        "items" => array(

        )
    );
    foreach ($oldArray as $item) {
        foreach ($item as &$item2) {
            if ($item2["id"] === $neededId) {
                array_push($newData["items"], $dataToFix);
            } else {
                array_push($newData["items"], $item2);
            }
        }
    }
    return $newData;
}