<?php session_status();?>
<?php require_once('functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title>contact</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<style>
   .container{
   margin-top:10%;
   }
  </style>
</head>
<body>
 <?php
    include_once 'includes/navbar.php';
    
    ?>
<div class="container ">
<form action="process.php" method="POST">
<div class="row m-75 div-to-align ">
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
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder=" phone number2" name="phone2" required>
     </div>
     <div class="mb-3">
    <input type="text" class="form-control border-top-0 border-end-0 border-start-0" placeholder="Adress" name="adress" required>
    </div>
    <div class="mb-3">
    <input type="email" class="form-control border-top-0 border-end-0 border-start-0" placeholder=" Personal Email" name="email1" required>
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
 
</body>
</html>