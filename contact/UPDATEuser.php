<?php 
require_once('functions.php');
include_once 'includes/header.php';
?>
<?php

$id=$_GET['id'];
try{
    $bd=connect();
    $stmt = $bd->prepare(" select * from  user where id=:id");
    $stmt->execute(array('id'=>$id));
    echo'<p class="text-success">Successed operation</p>';
    if($data=$stmt->fetch()){
      ?>
        <div class="row m-75 div-to-align">
        <form  method="POST">
        <input type="hidden" name="id"  value="<?php echo $data['id']?>">
      <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0 mt-2 " placeholder="FirstName" name="firstName" value="<?php if(!empty($_POST['firstName'])) echo $data['firstName'];?>">
    </div>
    <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0"placeholder="lastName" name="lastname" value="<?php echo $data['lastname']?>">
    </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder="number of phone1" name="phone1" value="<?php echo $data['phone1']?>">
     </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder="number of phone1" name="phone2" value="<?php echo $data['phone2']?>">
     </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Adress" name="adress" value="<?php echo $data['adress']?>">
    </div>
    <div class="mb-3">
    <input type="email" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Email Personal" name="email1" value="<?php echo $data['email1']?>">
    </div>
    <div class="mb-3">
    <input type="email" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Email profetional" name="email2" value="<?php echo $data['email2']?>">
    </div>
    <div class="mb-3 ">
     <label class="form-label text-muted">Choose a gender:</label>
	
	<select class="form-select mb-2  mt-2 text-muted" aria-label="Disabled select example" name="select1" value="<?php echo $data['select1']?>">
    <option selected>Male</option>
    <option value="1">Femal</option>
    </select>
    <input type="checkbox" class="form-check-input text-muted" id="exampleCheck1">
    <label class="form-check-label text-muted" for="exampleCheck1">Check me out</label><br>
    <button type="submit" class="btn btn-warning mt-3 mb-3">Update</button>
    </div>
    </form>
     </div>
    <?php 
    }
    else{

        echo'<p class="text-danger">Your account doesn\'t existe</p>';
    }
}
catch(PDOException $e){
    echo $e;
    echo'<p class="text-danger">Faild operation</p>';
    
}
?>
<?php 
if(!empty($_POST)){
    $firstname=sanitaze($_POST['firstName']);
    
    $lastname=sanitaze($_POST['lastname']);
    $number1=sanitazeint($_POST['phone1']);
    $number2=sanitazeint($_POST['phone2']);
    $adress=sanitaze($_POST['adress']);
    $mail1=sanitazeEmail($_POST['email1']);
    $mail2=sanitazeEmail($_POST['email2']);
    $select1=sanitaze($_POST['select1']);
    try{
    $stmt = $bd->prepare(" update  user  set firstname=:ft,lastname=:lt,adress=ad,num1=:n,num2=m,mail1=:ma,mail2=:na,select1=:st where id=:id");
    $stmt->execute(array('ft'=>$firstname,'lt'=>$lastname,'ad'=>$adress,'n'=> $number1,'m'=>$number2,'ma'=>$mail1,'na'=>$mail2,'st'=> $select1));
    }
    catch(PDOException $e){
        echo "*****************************";
        echo $e;
        
        echo'<p class="text-danger">Faild operation</p>';
        
    }
}



?>
<?php
include_once 'includes/footer.php'
?>

