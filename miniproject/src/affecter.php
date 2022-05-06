<?php 
require_once('../includes/functions.php');
include_once '../includes/header.php';
?>

   <h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;">Affecter</h1>
  <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form action= "<?php echo $_SERVER['PHP_SELF']?>"  method="POST" class="border border-2 rounded p-5 border-primary mt-2 ">
     <div class="form-group m-3">
      <label class="mb-1">Filière</label>
    <select class="form-select" name="fil">
    <option  value="" selected disabled >!-----choisir un Filière-----!</option>
    <?php
    $FILList = getFillier();
    foreach($FILList as $it){
        echo printcheckbox($it['idFiliere'], $it['titreFiliere']);
    }
?>
</select>
</div>
     <div class="form-group m-3">
      <label class="mb-1">Coordinateur</label>
    <select class="form-select" name="coll">
    <option  value="" selected disabled >!-----choisir un Coordinateur-----!</option>
    <?php
    $corList = getCoordinateur();
    foreach($corList as $it){
        echo printcheckbox($it['idCoordinateur'],$it['nom']);
    }
?>
</select>
</div>
 <div>
        <button type="submit" class="btn btn-outline-primary m-3">Affecter</button>
        </div>
        </form>
        </div>
        </div>
        </div>
  <?php 
  if(isset($_POST['col']) && isset($_POST['fil'])){
       try{
          $idf=isset($_POST['fil']);
          $id=$_POST['col'];
          $bd=connect();
          $stat=$bd->prepare("Update Coordinateur set idFiliere=:t where idCoordinateur=$id");
          $stat->execute(array("t"=>$idf));
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


