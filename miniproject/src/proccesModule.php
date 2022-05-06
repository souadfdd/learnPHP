<?php require_once('../includes/functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<?php
$tittle=sanitaze($_POST['Ti']);  
$password=sanitaze($_POST['password']);
$niv=sanitaze($_POST['niv']);
     try{
        $bd=connect();
            $stmt = $bd->prepare('INSERT into Module (titre_module,code_module,idNiveau) values (:N,:A,:NI)');
            $stmt->execute(array('N'=>$tittle,'A'=>$password,'NI'=>$niv));
            header("location:info_Module.php?remarks=success");
     
    }
    catch(PDOException $e){
        echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
       
    }
    ?>
 </body>
</html>
