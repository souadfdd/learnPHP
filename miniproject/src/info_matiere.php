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
<body style="font-family: 'Noto Serif', serif;">
<?php require_once('../includes/Navbar.php');?>
<h4  class="m-5" style="color:red;text-align: center">Tableau des Matieres</h4>
<?php 
try{
    $bd=connect();
    $stat=$bd->prepare("select * from Matiere");
    $stat->execute();
      echo '  <table class="table table-striped  m-5" style="width:90%">';
      echo '<th class="text-primary">Id_Matiere </th><th class="text-primary">Id_Module</th><th class="text-primary">Nom_Niveau</th><th class="text-primary">Code_matiere</th><th class="text-primary">Action</th></tr>';
    while($data=$stat->fetch()){
//         $linkd='<a href="matiere.php?idMatiere ='.$data['idMatiere'].'">Creer</a>';
        $linkup='<a href="info_matiere.php?idMatiere='.$data['idMatiere'].'" class="link-success text-decoration-none">Suprimer</a>';
         $linkc='<a href="updateMA.php?idMatiere='.$data['idMatiere'].'" class="link-success text-decoration-none">Modifier</a>';
          $linkp='<a href="affiche_matiere.php?idMatiere='.$data['idMatiere'].'" class="link-success text-decoration-none">Info_Matiere</a>';
        echo '<tr><td>' 
          .$data['idMatiere'].'</td><td>' .$data['idModule'].'</td><td>' .$data['nom'].'</td><td>' .$data['code_matiere'].'</td><td>'.$linkp.'<br>'.$linkup.'<br>'.$linkc.'</tr>';
    }
      echo  '</table>';
    $stat->closeCursor();
}
catch(PDOException $e){
    echo'<p class="text-danger">opération a échoué</p>';
}

       ?>   
<?php 
if(isset($_GET['idMatiere'])){
$id=$_GET['idMatiere'];
try{
    $bd=connect();
    $stmt = $bd->prepare("delete from Matiere where idMatiere=:id");
    $stmt->execute(array('id'=>$id));
    echo'<p class="text-success">Opération a bien été effectuée</p>';
}
catch(PDOException $e){
    echo'<p class="text-danger">opération a échoué</p>';
}
}
?>
   </body>
</html>


