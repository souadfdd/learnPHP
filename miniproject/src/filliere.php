<?php header('Content-Type: text/html; charset=utf-8')?>
<!DOCTYPE html>
<html>
<head>
<title></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital@1&display=swap" rel="stylesheet">
</head>
<body >
<?php require_once('../includes/Navbar.php');?>
<h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;">Filière</h1>
      <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form  action="proccesF.php" method="POST" class="border border-2 rounded p-5 border-primary ">
    <div class="form-group m-3">
        <label  class="mb-1">Titre</label>
        <input type="text" class="form-control p-2 "  placeholder="Titre" name="Titre">
    </div>
    <div class="form-group m-3">
        <label  class="mb-1">Année Accréditation</label>
        <input type="text" class="form-control"  placeholder="Année Accréditation" name="AnneeA">
    </div>
     <div class="form-group m-3">
        <label  class="mb-1">Annee Fin Accréditation</label>
        <input type="text" class="form-control"  placeholder="Annee Fin Accréditation" name="fina">
    </div>
    <div class="form-group m-3">
        <label for="inputPassword">Le mot de passe</label>
        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="code">
    </div>
    <div class="form-group m-3">
        <label class="form-check-label mb-1"><input type="checkbox" > Se rappeler moi</label>
    </div>
    <button type="submit" class="btn btn-outline-primary m-3">Envoyer</button>
</form>
</div>
</div>
</div>
</body>
</html>
<?php 
if(isset($_POST['submit'])){
     header("location:Infofilliere.php?remarks=success");
}
?>


   
