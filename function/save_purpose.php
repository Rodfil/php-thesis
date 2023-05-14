<?php
    require("../connection/db.php");
    $resultArray = $_POST['resultArray'];
    $result = "";
    foreach($resultArray as $list){

        $ID = $list['RecordID'];
        $DocumentID = $list['DocumentID'];
        $Purpose_Description = $list['Purpose_Description'];

        if($ID == 0){
            $query = "INSERT INTO purpose(DocumentID,Purpose_Description)
            VALUES ('$DocumentID','$Purpose_Description')";
    
            if ($mysqli->query($query)) {
                $result = $mysqli->insert_id;
            }
            else{
                $result = "Error";
            }
        }
        else{
            $query = "UPDATE purpose SET DocumentID = '$DocumentID', Purpose_Description = '$Purpose_Description' WHERE ID = $ID";
            if ($mysqli->query($query)) {
                $result = $ID;
            }
            else{
                $result = "Error";
            }
        }

    }

    echo json_encode(1);
?>