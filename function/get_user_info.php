<?php
    require("../connection/db.php");
    $UserID = $_POST['UserID'];
    $query = "SELECT * FROM `users` WHERE ID = $UserID";
    $resultArray = array();
    if ($result = $mysqli->query($query)) {
        if($result->num_rows > 0){
            $row = $result->fetch_array();
            $DateOfBirth = $row['Birthdate'];
            $birthDate = explode("-", $DateOfBirth);
            $UserAge = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1): (date("Y") - $birthDate[0]));
            
            $_row['Firstname'] = $row['Firstname'];
            $_row['Lastname'] = $row['Lastname'];
            $_row['EmailAddress'] = $row['EmailAddress'];
            $_row['ContactNo'] = $row['ContactNo'];
            $_row['Address'] = $row['Address'];
            $_row['Gender'] = $row['Gender'];
            $_row['Birthdate'] = $row['Birthdate'];
            $_row['RegistrationStatus'] = $row['RegistrationStatus'];
            $_row['UserAge'] = $UserAge;
            $_row['Documents'] = GetDocuments($row['ID']);
            array_push($resultArray,$_row);
        }
    }
    function GetDocuments($id){
        $dirpath_thumbnail = '../images/docs';
        $dirpath_thumbnail .= "/*";
        $files = array();
        $files = glob($dirpath_thumbnail);
        $data = array();
        foreach($files as $item){
            $basename = basename($item);
            $sortBy = explode("_", $basename);
            if( $sortBy[0] == $id ) {
                array_push($data,$basename);
            }
        }
        return $data;
    }
    echo json_encode($resultArray);
?>