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
try {
    // Se connecter

    $bd = connect();
        $stmtCom = $bd->prepare('select * from groupe as c, group_user as cp ,user as u where cp.idg=c.id and cp.idp=u.id');
        $stmtCom->execute();
        echo '  <table class="table table-dark table-striped">';
        echo '<th class="text-warning">Firstname</th><th class="text-warning">Lastname</th><th class="text-warning">phone number1</th><th class="text-warning">phone number2</th><th class="text-warning">Groupe</th><th class="text-warning">Picture</th></tr>';
        while($data=$stmtCom->fetch()){
            echo '<tr><td>'
            .$data['firstname'].'</td><td>' .$data['lastname'].'</td><td>'.$data['num1'].'</td><td>'.$data['num2'].'</td><td>'. $data['nom'].  '</td><td><img widh="50" height="50" src="contact/image/'. $data['photo'] . '"/>'.'</td></tr>';
        }
        echo  '</table>';
        echo  '<button type="button" class="btn btn-warning  mt-3 w-25"><a href="deletegroup.php" class="text-decoration-none text-dark"">Delete Group</a></button>';
}
       
catch (Exception $ex) {
    echo $ex;
    echo '<p class="text-danger">Une erreur est survenue</p>';
}

?>
<?php
include_once 'includes/footer.php';

?>

