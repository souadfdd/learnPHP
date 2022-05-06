<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<h1  class="mt-4" style="color:#a87808;text-align: center">Delate user</h1>
<form action= "<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <div class="mb-3">
    <input type="text" class="form-control m-5 w-75 " placeholder=" Group Name" name="ID" required>
    </div>
    <button type="submit" class="btn btn-warning mx-5 mt-3 mb-2 w-25">Submit</button>
    </form>
    <?php
    if(isset($_POST['ID'])){
        
        $G=$_POST['ID'];
        require_once('functions.php');
        try{
            $bd=connect();
            $stmt = $bd->prepare("delete from groupe where nom='$G'");
            $stmt->execute(array('nom'=>$G)); 
            echo'<p class="text-success mx-5 fs-3">Successed operation</p>';
        }
        catch(PDOException $e){
            echo '<p class="text-danger mx-5 fs-3">faild operation</p>';
        }
}
?>
<?php require_once('functions.php');
include_once 'includes/footer.php';
?>