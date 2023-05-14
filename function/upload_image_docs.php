<?php
$UserID = $_POST['UserID'];
for($i=0; $i<count($_FILES['file']['name']); $i++){
    $ext = explode('.', basename( $_FILES['file']['name'][$i]));
    $filename = $UserID.'_'.md5(uniqid()).'.webp';
    $newFilePath = "../images/docs/".$filename;
    if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $newFilePath)) {
        echo "The file has been uploaded successfully <br />";
    } else{
        echo "There was an error uploading the file, please try again! <br />";
    }
}
?>