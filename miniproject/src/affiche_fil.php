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
<h4 class="m-5" style="color:red; text-align: center">les informations de ce Filière</h4>

<?php
 if(isset($_GET['idNiveau'])){
try{
    $id=$_GET['idNiveau'];
    $bd=connect();
    $stat=$bd->prepare("select * from Filiere,Niveau where Niveau.idFiliere=Filiere.idFiliere and idNiveau=$id");
    $stat->execute();
    echo '  <table class="table table-striped  m-5" style="width:90%">';
    echo '<th class="text-primary">ID_Filière</th><th class="text-primary">Titre_Filière</th><th class="text-primary">Année Accréditation</th><th class="text-primary">Annee Fin Accréditation</th><th class="text-primary">Code_Filière</th></tr>';
    while($data=$stat->fetch()){
        echo '<tr><td>'
        .$data['idFiliere'].'</td><td>' .$data['titreFiliere'].'</td><td>' .$data['codeFiliere'].'</td><td>' .$data['anneeaccreditation'].'</td><td>'.$data['anneeFinaccreditation'].'</td></tr>';
    }
    echo  '</table>';
    $stat->closeCursor();
}
catch(PDOException $e){
    echo'<p class="text-dange"r>opération a échoué</p>';
}
}
?>
    </body>
</html>