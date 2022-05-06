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
      <div class="container ">
<form  method="POST">
<div class="row m-75 div-to-align ">
<input type="hidden" name="id"  value="<?php echo $data['id']?>">
<div class="col-lg-5 col-md-9">
  <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0 mt-2 " placeholder="FirstName" name="firstName" required>
    </div>
    <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0"placeholder="LastName" name="lastname" required>
    </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder=" phone number1" name="phone1" required>
     </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder="phone number2" name="phone2" required>
     </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Adress" name="adress" required>
    </div>
    <div class="mb-3">
    <input type="email" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Personal Email" name="email1" required>
    </div>
      </div>
    <div class="col-lg-5 col-md-9">
    <div class="mb-3">
    <input type="email" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Professional Email" name="email2" required>
    </div>
     <div class="mb-3">
    <input type="file" class="form-control border-top-0 border-end-0 border-start-0" placeholder="photo" name="photo" required>
     </div>
    <div class="mb-3 ">
     <label class="form-label text-muted">Choose a gender:</label>
	
	<select class="form-select mb-2  mt-2 text-muted" aria-label="Disabled select example" name="select1" required>
    <option >Male</option>
    <option >Femal</option>
    </select>
    </div>
</div>
 <button type="submit" class="btn btn-warning mt-3 mb-3">Submit</button>
</form>
</div>
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
    $id=$_POST['id'];
    $firstname=sanitaze($_POST['firstName']);
    
    $lastname=sanitaze($_POST['lastname']);
    $number1=sanitaze($_POST['phone1']);
    $number2=sanitaze($_POST['phone2']);
    $adress=sanitaze($_POST['adress']);
    $mail1=sanitazeEmail($_POST['email1']);
    $mail2=sanitazeEmail($_POST['email2']);
    $select1=sanitaze($_POST['select1']);
    try{
     $bd=connect();
    $stmt = $bd->prepare(" update  user  set firstname=:firstname , lastname=:lastname,num1=:num1,num2=:num2,adress=:adress,mail1=:mail1,mail2=:mail2,select1=:select1 where id=$id");
    $stmt->execute(array('firstname'=>$firstname,'lastname'=>$lastname,'adress'=>$adress,'num1'=> $number1,'num2'=>$number2,'mail1'=>$mail1,'mail2'=>$mail2,'select1'=> $select1));
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

 
