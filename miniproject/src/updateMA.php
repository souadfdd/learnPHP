<?php 
require_once('../includes/functions.php');
include_once '../includes/header.php';
 require_once('../includes/Navbar.php');

?>
<?php
if(isset($_GET['idMatiere'])){
$id=$_GET['idMatiere'];

try{
    $bd=connect();
    $stmt = $bd->prepare(" select * from  Matiere where idMatiere=:idMatiere");
    $stmt->execute(array('idMatiere'=>$id));
    if($data=$stmt->fetch()){
        ?>
        <h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;"> Modifier Matière</h1>
<div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form  method="POST" class="border border-2 rounded p-5 border-primary mt-2 ">
       <input type="hidden" name="idMatiere"  value="<?php echo $data['idMatiere']?>">
       <div class="form-group m-3">
        <label class="mb-1">Nom</label>
        <input type="text" class="form-control"  placeholder="Nom" name="nom" value="<?php echo $data['nom']?>">
    </div>
    <div class="form-group m-3">
      <label  class="mb-1">Module</label>
    <select class="form-select" name="mat" value="<?php echo $data['idModule']?>">
    <option  value="" selected disabled >!-----choisir un Module-----!</option>
    <?php
    $moduleList = getModule();
    foreach($moduleList as $it){
        echo printcheckbox($it['idModule'], $it['titre_module']);
    }
?>
</select>
</div>
  <div class="form-group m-3">
        <label  class="mb-1">Mot de passe</label>
        <input type="text" class="form-control"  placeholder="Le mot de passe" name="password" value="<?php echo $data['code_matiere']?>">
    </div>
    <div>
        <button type="submit" class="btn btn-outline-primary m-3">Modifier</button>
        </div>
        </form>
</div>
</div>
</div>
}<?php 
    }
    else{

        echo'<p class="text-danger">La matiere  n\'existe pas</p>';
    }
}
catch(PDOException $e){
     echo $e;
    echo'<p class="text-danger">opération a échoué</p>';
    
}
}
?>
<?php 
if(!empty($_POST)){
  $id=$_POST['idMatiere'];
$nom=sanitaze($_POST['nom']);  
$pasword=sanitaze($_POST['password']);
$mat=sanitaze($_POST['mat']);
     try{
         $bd=connect();
         $stmt = $bd->prepare("update  Matiere set  nom=:t,code_matiere=:code,idModule=:A where idMatiere=$id");
         $stmt->execute(array('t'=>$nom,'code'=>$pasword,'A'=>$mat));
         header("location:info_matiere.php?remarks=success");
     }
     catch(PDOException $e){
         echo $e;
         echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
     }
}
?>
     }