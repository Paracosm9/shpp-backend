<?php
deleteItem();

echo json_encode(file_get_contents('/assets/jsonChangeOutput.json'),true);
function deleteItem()
{
    $dataToFix = json_decode(file_get_contents('php://input'), true);
    $oldData = json_decode(file_get_contents("/assets/jsonGet.json"), true);
    $changed = deleteData($oldData, $dataToFix);
    file_put_contents("/assets/jsonGet.json", json_encode($changed));
}

function deleteData($old, $needToDel)
{
    $newData = array(
        "items" => array(

        )
    );
    $flagForChangeId = false;
    foreach ($old as $item) {
        foreach ($item as &$item2) {
            if ($item2["id"] == $needToDel["id"]) {
                $flagForChangeId = true;
            }
            else if ($flagForChangeId){
                array_push($newData["items"], $item2);
            }
            else {
                array_push($newData["items"], $item2);
            }

        }
    }
    return $newData;
}