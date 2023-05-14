<?php
    require("../connection/db.php");
    $resultArray = array();
    if (isset($_GET['documentID'])) {
        $documentID = $_GET['documentID'];
        $query = "SELECT ID, Purpose_Description FROM `purpose` WHERE DocumentID = '$documentID'";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
              $resultArray[] = $row;
            }
          } 
    }
    echo json_encode($resultArray);
?>