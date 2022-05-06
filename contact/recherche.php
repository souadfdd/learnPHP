

<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<h1  class="mt-4" style="color:#a87808;text-align: center">Search user by Name</h1>
<form action= "<?php echo $_SERVER['PHP_SELF']?>" method="post">
<div class="mb-3">
 <input type="text" class="form-control   m-5 w-75 " placeholder="FirstName" name="firstname" required>
 </div>
 <button type="submit" class="btn btn-warning mx-5  mb-2 w-25">Search</button>
 </form>
<?php 
if(isset($_POST['firstname'])){
    
    $firstname=strtolower($_POST['firstname']);
//     $num=$_POST['num'];
    require_once('functions.php');
    try{
        $bd=connect();
        $stmt = $bd->prepare("select * from user where firstname='$firstname'");
        $stmt->execute();
        echo '  <table class="table table-dark table-striped">';
        echo '<th class="text-warning">Firstname</th><th class="text-warning">Lastname</th><th class="text-warning">Adress</th><th class="text-warning"> professional Email</th><th class="text-warning">Personal Email</th><th class="text-warning">phone number1</th><th class="text-warning">phone number2</th><th class="text-warning">Gender</th></tr>';
        while($data=$stmt->fetch()){
            echo '<tr><td>'
            .$data['firstname'].'</td><td>' .$data['lastname'].'</td><td>' .$data['adress'].'</td><td>'.$data['mail1'].'</td><td>'.$data['mail2'].'</td><td>'.$data['num1'].'</td><td>'.$data['num2'].'</td><td>'  .$data['select1'].'</td></tr>';
        }
        echo  '</table>';
        $stmt->closeCursor();
        }
    catch(PDOException $e){
        echo '<p class="text-danger fs-3 mt-5">the user doesn\'t exist</p>';
        }
}
?>
<?php require_once('functions.php')?>