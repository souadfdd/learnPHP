 <?php 
 require_once('../includes/functions.php');
 include_once '../includes/header.php';
 require_once('../includes/Navbar.php');
 ?>
 <?php
 if(isset($_GET['idModule'])){
     $id=$_GET['idModule'];
 try{
     $bd=connect();
     $stmt = $bd->prepare("select * from  Module where idModule=:idModule");
    $stmt->execute(array('idModule'=>$id));
     if($data=$stmt->fetch()){
       ?>
    <h1  class="m-5" style="color:green;text-align:center;font-family: 'Noto Serif', serif;">Module</h1>
 <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form  action="proccesModule.php" method="POST" class="border border-2 rounded p-5 border-primary mt-2 ">
     <input type="hidden" name="idModule"  value="<?php echo$data['idModule']?>">
    <div class="form-group m-3">
        <label class="mb-1">titre</label>
        <input type="text" class="form-control"  placeholder="Titre" name="Ti" value="<?php echo $data['titre_module']?>">
    </div>
    <div class="form-group m-3">
      <label class="mb-1">Niveau</label>
    <select class="form-select" name="niv" >
     <option  value="" selected disabled >!-----choisir un Module-----!</option>
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
        <input type="password" class="form-control"  placeholder="Le mot de passe" name="password" value="<?php echo $data['code_module']?>">
    </div>
    <div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
</form>
</div>
</div>
</div>
// <?php 
    }
    else{

        echo'<p class="text-danger">le module doesn\'t existe</p>';
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
  $id=$_POST['idModule'];
$tittle=sanitaze($_POST['Ti']);
$password=sanitaze($_POST['password']);
$niv=sanitaze($_POST['niv']);
try{
    $bd=connect();
    $stmt = $bd->prepare("update Module set  titre_module=:titre,code_module=:code,idNiveau=:niv where idModule=$id");
    $stmt->execute(array('titre'=>$tittle,'code'=>$password,'niv'=>$niv));
    header("location:info_niveau.php?remarks=success");
}
catch(PDOException $e){
    echo $e;
    echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
}
}
?>
</body>
</html>
    
