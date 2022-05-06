<?php 
require_once('../includes/functions.php');
include_once '../includes/header.php';
include_once '../includes/Navbar.php';
?>

   <h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;">Consulter</h1>
  <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form action= "<?php echo $_SERVER['PHP_SELF']?>"  method="POST" class="border border-2 rounded p-5 border-primary mt-2 ">
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
 <div>
        <button type="submit" class="btn btn-outline-primary m-3">Consulter</button>
        </div>
        </form>
        </div>
        </div>
        </div>
  <?php 
  if(isset($_POST['niv'])){
       try{
          $id=$_POST['niv'];
           $bd=connect();
          $stat=$bd->prepare("select * from Module,Niveau where Niveau.idNiveau=Module.idNiveau and Niveau.idNiveau=$id");
          $stat->execute();
          echo'<h5  class="m-5" style="color:red;text-align: center">Les informations de ce Niveau</h5>';
           echo '  <table class="table table-striped  m-5" style="width:90%">';
           echo '<th class="text-primary">Id_Module</th><th class="text-primary">Id_Niveau</th><th class="text-primary">Code_Module</th><th class="text-primary">code_module</th></tr>';
           while($data=$stat->fetch()){
               echo '<tr><td>'
         .$data['idModule'].'</td><td>'.$data['idNiveau'].'</td><td>' .$data['titre_module'].'</td><td>' .$data['code_module'].'</td></tr>';
           }
          echo  '</table>';
           $stat->closeCursor();
      }
       catch(PDOException $e){
           echo $e;
           echo'<p class="text-dange"r>opération a échoué</p>';
       }
  }
   ?>
    </body>
</html>

