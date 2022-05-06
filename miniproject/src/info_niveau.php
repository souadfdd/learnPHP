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
<h3  class="m-5" style="color:red;text-align:center">Tableau des Niveaux</h3>
<?php 
try{
    $bd=connect();
    $stat=$bd->prepare("select * from Niveau");
    $stat->execute();
      echo '  <table class="table table-striped  m-5" style="width:90%">';
      echo '<th class="text-primary">Id_Niveau</th><th class="text-primary">Id_Filiere</th><th class="text-primary">Titre_Niveau</th><th class="text-primary">Alias</th><th class="text-primary">Action</th></tr>';
    while($data=$stat->fetch()){
//         $linkd='<a href="niveau.php?idNiveau='.$data['idNiveau'].'">Créer</a>';
         $linkup='<a href="info_niveau.php?idNiveau='.$data['idNiveau'].'" class="link-success text-decoration-none">Suprimer</a>';
         $linkc='<a href="updateN.php?idNiveau='.$data['idNiveau'].'" class="link-success text-decoration-none">Modifier</a>';
          $linkp='<a href="affiche_fil.php?idNiveau='.$data['idNiveau'].'" class="link-success text-decoration-none">Info_Filière</a>';
        echo '<tr><td>' 
          .$data['idNiveau'].'</td><td>' .$data['idFiliere'].'</td><td>' .$data['titre_niveau'].'</td><td>' .$data['alias'].'</td><td>'.$linkp.'<br>'.$linkup.'<br>'.$linkc.'</tr>';
    }
      echo  '</table>';
    $stat->closeCursor();
}
catch(PDOException $e){
    echo'<p class="text-dange"r>opération a échoué</p>';
}
       ?>   
    </body>
</html>
<?php 
if(isset($_GET['idNiveau'])){
$id=$_GET['idNiveau'];
try{
    $bd=connect();
    $stmt = $bd->prepare("delete from Niveau where idNiveau=:id");
    $stmt->execute(array('id'=>$id));
    echo'<p class="text-success">Opération a bien été effectuée</p>';
}
catch(PDOException $e){
    echo $e;
    echo'<p class="text-danger">opération a échoué</p>';
}
}
?>

