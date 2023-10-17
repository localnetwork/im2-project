<?php

function insertMedia($profile_picture, $db) {

    $getLastMedia = "call sp_getLastMedia()";
    $getLastMedia = $db->prepare($getLastMedia); 
    $getLastMedia->execute(); 

    $getLastMedia = $getLastMedia->fetchAll(PDO::FETCH_ASSOC);


    $sql = "call sp_insertMedia(:filename, :uri,:filemime)";

    
    $stmt = $db->prepare($sql);
    $filename = $_SERVER['REQUEST_TIME'] . '-' . $profile_picture['name']; 
    $fileFormat = pathinfo($filename, PATHINFO_EXTENSION);
    $path = "/storage/images/{$filename}";
    $stmt->bindParam(':filename', $filename);
    $stmt->bindParam(':filemime', $fileFormat);
    $stmt->bindParam(':uri', $path); 
   
    $media_id = $getLastMedia[0]['mid'];
   
    $uri = $_SERVER['DOCUMENT_ROOT'] . "/storage/images/{$filename}";
   
    $uploadOk = 1; 
   
    if(isset($_POST)) {
        $check = getimagesize($_FILES['profile_picture']["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    } 
    
    // Check if file already exists
    if (file_exists($uri)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    // if ($profile_picture["size"] > 500000) {
    //     echo "Sorry, your file is too large.";
    //     $uploadOk = 0;
    // }
    // Allow certain file formats
    if($fileFormat != "jpg" && $fileFormat != "png" && $fileFormat != "jpeg" && $fileFormat != "gif" ) {
        $uploadOk = 0;
    }
   
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($profile_picture["tmp_name"], $uri)) {
        } else {
    }
    }
   
    $stmt->execute();
    return $media_id;  
}




?>