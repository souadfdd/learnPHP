
<?php
require_once('../includes/functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital@1&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once('../includes/Navbar.php');?>
<h1  class="m-5" style="color:green;text-align:center">Module</h1>
 <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form  action="proccesModule.php" method="POST" class="border border-2 rounded p-5 border-primary mt-2 ">
    <div class="form-group m-3">
        <label class="mb-1">Titre</label>
        <input type="text" class="form-control"  placeholder="Titre" name="Ti">
    </div>
    <div class="form-group m-3">
      <label class="mb-1">Niveau</label>
    <select class="form-select" name="niv">
    <option  value="" selected disabled >!-----choisir un Niveau-----!</option>
    <?php
    $niveauList = getNiveau();
    foreach($niveauList as $it){
        echo printcheckbox($it['idNiveau'], $it['titre_niveau']);
    }
?>
</select>
</div>
  <div class="form-group m-3">
        <label class="mb-1">Mot de passe</label>
        <input type="password" class="form-control"  placeholder="Le mot de passe" name="password">
    </div>
    <div>
        <button type="submit" class="btn btn-outline-primary m-3">Envoyer</button>
        </div>
</form>
</div>
</div>
</div>
</body>
</html>