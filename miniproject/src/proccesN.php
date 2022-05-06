<?php require_once('../includes/functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<?php
$Ni=sanitaze($_POST['Ni']);  
$Al=sanitaze($_POST['Al']);
$FIL=sanitaze($_POST['fil']);
     try{
        $bd=connect();
            $stmt = $bd->prepare('INSERT into Niveau (titre_niveau,alias,idFiliere) values (:Ni,:Al,:Fil)');
            $stmt->execute(array('Ni'=>$Ni,'Al'=>$Al,'Fil'=>$FIL));
            header("location:info_niveau.php?remarks=success");
     
    }
    catch(PDOException $e){
        echo $e;
        echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
       
    }
    ?>
 </body>
</html>