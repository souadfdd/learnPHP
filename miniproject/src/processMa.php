<?php require_once('../includes/functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<?php
$nom=sanitaze($_POST['nom']);  
$pasword=sanitaze($_POST['password']);
$mat=sanitaze($_POST['mat']);
     try{
        $bd=connect();
            $stmt = $bd->prepare('INSERT into Matiere (nom,code_matiere,idModule) values (:nom,:password,:mat)');
            $stmt->execute(array('nom'=>$nom,'password'=>$pasword,'mat'=>$mat));
            header("location:info_matiere.php?remarks=success");
    }
    catch(PDOException $e){
        echo $e;
        echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
       
    }
    ?>
 </body>
</html>
