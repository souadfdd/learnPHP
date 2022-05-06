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
$id=$_GET['id'];
try{
    $bd=connect();
    $stmt = $bd->prepare("delete from  user where id=:id");
    $stmt->execute(array('id'=>$id));
    echo'<p class="text-success">Successed operation</p>';
}
catch(PDOException $e){
    echo'<p class="text-danger">Faild operation</p>';
}
?>
    </body>
</html>