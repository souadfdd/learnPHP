
<?php require_once('../includes/functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>


<?php

    
$titre=sanitaze($_POST['Titre']);  
$AnneeA=sanitaze($_POST['AnneeA']);
    $fina=sanitaze($_POST['fina']);
    $code=sanitaze($_POST['code']);
    try{
       $bd=connect(); 
       $stmt = $bd->prepare('INSERT into Filiere (titreFiliere,codeFiliere,anneeaccreditation,anneeFinaccreditation) values (:titre,:AnneeA,:fina,:code)');
       $stmt->execute(array('titre'=>$titre,'AnneeA'=>$AnneeA,'fina'=>$fina,'code'=>$code));
           header("location:Infofilliere.php?remarks=success");
       
    }
    catch(PDOException $e){
        echo $e;
        echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
    }
    ?>
    </body>
</html>
 
