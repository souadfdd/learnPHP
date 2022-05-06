<?php
require_once('functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<?php 
try{
    $bd=connect();
    $stat=$bd->prepare("select * from user");
    $stat->execute();
      echo '  <table class="table table-dark table-striped">';
      echo '<th class="text-warning">Firstname</th><th class="text-warning">Lastname</th><th class="text-warning">Adress</th><th class="text-warning"> professional Email</th><th class="text-warning">Personal Email</th><th class="text-warning">phone number1</th><th class="text-warning">phone number2</th><th class="text-warning">Gender</th><th class="text-warning">Action</th></tr>';
    while($data=$stat->fetch()){
         $linkd='<a href="deleteuser.php?id='.$data['id'].'">Delete</a>';
         $linkup='<a href="essaiUPDATE.php?id='.$data['id'].'">Update</a>';
        echo '<tr><td>' 
          .$data['firstname'].'</td><td>' .$data['lastname'].'</td><td>' .$data['adress'].'</td><td>'.$data['mail1'].'</td><td>'.$data['mail2'].'</td><td>'.$data['num1'].'</td><td>'.$data['num2'].'</td><td>'  .$data['select1'].'</td><td>' .$linkd.'<br>'.$linkup.'</tr>';
    }
      echo  '</table>';
    $stat->closeCursor();
}
catch(PDOException $e){
    echo'<p class="text-dange"r>Faild operation</p>';
}
//           echo '<button type="button" class="btn btn-warning "><a href="recherche.php" class="text-decoration-none text-dark"">Recherche user by name</a></button>';
//           echo '<button type="button" class="btn btn-warning ms-5 text-decoration-none"><a href="rechercheID.php" class="text-decoration-none text-dark">Recherche user by number phone</a></button>';
//           echo '<button type="button" class="btn btn-warning ms-5"><a href="recherchegroup.php" class="text-decoration-none text-dark"">Recherche Group  by name</a></button>';
//           echo '<button type="button" class="btn btn-warning ms-5"><a href="deletegroup.php" class="text-decoration-none text-dark"">Delete Group</a></button>';
       ?>   
    </body>
</html>