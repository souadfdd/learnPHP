<?php 
require_once('../includes/header.php');
require_once('../includes/functions.php');
require_once('../includes/Navbar.php');
?>
<h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;">Importation</h1>
 <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
      <div class="p-3 border bg-light"><a href="importer.php" class="link-danger text-decoration-none">Importer Filière</a></div>
    </div>
    <div class="col-6">
      <div class="p-3 border bg-light"><a href="importniveau.php" class="link-primary text-decoration-none">Importer Niveau</a></div>
    </div>
    <div class="col-6">
      <div class="p-3 border bg-light"><a href="importerModule.php" class="link-warning text-decoration-none">Importer Module</a></div>
    </div>
    <div class="col-6">
      <div class="p-3 border bg-light"><a href="importerMatiere.php" class="link-success text-decoration-none">Importer Matiere</a></div>
    </div>
  </div>
</div>

 <?php 
 require_once('../includes/footer.php')
 ?>

