<?php 
  session_start();
?>
<?php require_once('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<?php

    
$firstname=sanitaze($_POST['firstName']);  
$lastname=sanitaze($_POST['lastname']);
    $number1=sanitazeint($_POST['phone1']);
    $number2=sanitazeint($_POST['phone2']);
    $adress=sanitaze($_POST['adress']);
    $mail1=sanitazeEmail($_POST['email1']);
    $mail2=sanitazeEmail($_POST['email2']);
    $select1=sanitaze($_POST['select1']);

    echo'<h5 class="text-dark">welcome '.$firstname.'</h5>';
    try{
       $bd=connect(); 
       $stmt = $bd->prepare('INSERT into user (firstname,lastname,adress,num1,num2,mail1,mail2,select1) values (:firstname,:lastname,:adress,:num1,:num2,:mail1,:mail2,:select1)');
       $stmt->execute(array('firstname'=>$firstname,'lastname'=>$lastname,'adress'=>$adress,'num1'=>$number1,'num2'=>$number2,'mail1'=>$mail1,'mail2'=>$mail2,'select1'=>$select1));
       
       
       
       
//        $idPersonne = $bd->lastInsertId();
       
//        foreach ($groupe as $it) {
           
//            $stmt = $bd->prepare('insert into group_user(idp, idg) values(:idp, :idg)');
//            $stmt->execute(array(
//                'idp' => $idPersonne,
//                'idg' => $it
//            ));
//        }
       
    }
    catch(PDOException $e){
        echo'<p class="text-danger">Faild operation</p>';
    }
    ?>
    </body>
</html>
 