<?php
require_once('../includes/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital@1&display=swap" rel="stylesheet">
</head>
<body  style="font-family: 'Noto Serif', serif;">
<?php require_once('../includes/Navbar.php');?>
<h4  class="m-5" style="color:red; text-align: center"> Tableau des Module</h4>
<?php 
try{
    $bd=connect();
    $stat=$bd->prepare("select * from Module");
    $stat->execute();
      echo '  <table  class="table table-striped  m-5" style="width:90%">';
      echo '<th class="text-primary">Id_Module </th><th class="text-primary">Id_Niveau</th><th class="text-primary">Titre_Module</th><th class="text-primary">Code_Module</th><th class="text-primary">Action</th></tr>';
    while($data=$stat->fetch()){
//         $linkd='<a href="module.php?idModule ='.$data['idModule'].'">Creer</a>';
        $linkup='<a href="info_Module.php?idModule='.$data['idModule'].'" class="link-success text-decoration-none">Suprimer</a>';
         $linkc='<a href="updateM.php?idModule='.$data['idModule'].'" class="link-success text-decoration-none">Modifier</a>';
          $linkp='<a href="affiche_module.php?idModule='.$data['idModule'].'" class="link-success text-decoration-none">Info_Niveau</a>';
        echo '<tr><td>' 
          .$data['idModule'].'</td><td>' .$data['idNiveau'].'</td><td>' .$data['titre_module'].'</td><td>' .$data['code_module'].'</td><td>'.$linkp.'<br>'.$linkup.'<br>'.$linkc.'</tr>';
    }
      echo  '</table>';
    $stat->closeCursor();
}
catch(PDOException $e){
    echo'<p class="text-danger">opération a échoué</p>';
}

       ?>   
<?php 
if(isset($_GET['idModule'])){
$id=$_GET['idModule'];
try{
    $bd=connect();
    $stmt = $bd->prepare("delete from Module where idModule=:id");
    $stmt->execute(array('id'=>$id));
    echo'<p class="text-success">opération a échoué</p>';
}
catch(PDOException $e){
    echo'<p class="text-danger">opération a échoué</p>';
}
}
?>
   </body>
</html>

