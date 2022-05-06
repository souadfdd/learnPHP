<?php  require_once('functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<h1  class="mt-4" style="color:#a87808;text-align: center">New Group</h1>
<form  method="post" enctype="multipart/form-data">
    <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0   mx-5 mb-1 mt-5 w-75 " placeholder="Group name" name="nom" required>
    </div>
    <div class="mb-3">
    <input type="file" class="form-control border-top-0 border-end-0 border-start-0 mt-1 mx-5 w-75"  name="uploadfile" required>
    <label class=" mx-5 text-danger">Picture of the new group</label>
     </div>
     <div><?php

$userList = getuser();
foreach($userList as $it){
    echo printcheckbox($it['id'], $it['firstname'].' '.$it['lastname']);
}
?>	
</div>
    <button type="submit" class="btn btn-warning mx-5 mt-1 w-25"">Submit</button>
    </form>
    <?php 
    if(isset($_POST['nom'])){
        $nom=$_POST['nom'];
        $groupe= $_POST['group'];
//         $filename = $_FILES["uploadfile"]["name"];
//         $tempname = $_FILES["uploadfile"]["tmp_name"];
//         $folder = "image/".$filename;
//         if (move_uploaded_file($tempname, $folder))  {
//            echo"Image uploaded successfully";
//         }else{
//              echo "Failed to upload image";
        $folder = "image/";
        $file = basename( $_FILES['uploadfile']['name']);
        $full_path = $folder.$file;
        move_uploaded_file($_FILES['uploadfile']['tmp_name'], $full_path) ;
        }
        try{
            $bd=connect();
            $stmt = $bd->prepare("insert into groupe(nom,photo) values (:nom,:photo)");
            $stmt->execute(array('nom'=>$nom, 'photo'=> $file));
            
            
            
            
            $idgroup = $bd->lastInsertId();
            foreach ($groupe as $it) {
                $stmtc = $bd->prepare('insert into group_user (idp,idg) values(:idp,:idg) ');
                        $stmtc->execute(array(
                            'idg' => $idgroup,
                            'idp' => $it,
                        ));
            }
    }
    catch(PDOException $e){
        echo$e;
        echo '<p class="text-danger">Fail operation</p>';
 
    }
    
//     try{
//         $bd=connect();
//         $idgroup = $bd->lastInsertId();
//         $stmtc = $bd->prepare('insert into group_user (idp,idg) values(:idp,:idg) ');
//         $stmtc->execute(array(
//             'idg' => $idgroup,
//             'idp' => $it['id'],
//         ));
//     }
//     catch(PDOException $e){
//         echo$e;
//         echo '<p class="text-danger">Fail operation</p>';
        
//     }
    ?>
    <?php
    include_once 'includes/footer.php';
    
    ?>

   