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
<h4  class="m-5" style="color:red;text-align: center">Les informations de ce Niveau</h4>

<?php
    if(isset($_GET['idMatiere'])){
        try{
            $id=$_GET['idMatiere'];
    $bd=connect();
    $stat=$bd->prepare("select * from Matiere, Module,Niveau,Filiere where Matiere.idMatiere=Module.idModule and Niveau.idNiveau=Module.idNiveau and Niveau.idFiliere=Filiere.idFiliere and idMatiere=$id");
    $stat->execute();
    echo '  <table class="table table-striped  m-5" style="width:90%">';
    echo '<th class="text-primary">Id_Module</th><th class="text-primary">Id_Niveau</th><th class="text-primary">Titre_Module</th><th class="text-primary">code_module</th><th class="text-primary">Titre_Niveau</th></tr>';
    while($data=$stat->fetch()){
        echo '<tr><td>'
        .$data['idModule'].'</td><td>'.$data['idNiveau'].'</td><td>' .$data['titre_module'].'</td><td>' .$data['titre_niveau'].'</td><td>' .$data['titreFiliere'].'</td></tr>';
    }
    echo  '</table>';
    $stat->closeCursor();	
}
catch(PDOException $e){
    echo $e;
    echo'<p class="text-dange"r>opération a échoué</p>';
}
    }
?>
    </body>
</html>
