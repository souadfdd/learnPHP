<?php 
require_once('../includes/functions.php');
include_once '../includes/header.php';
 require_once('../includes/Navbar.php');
?>
<?php
if(isset($_GET['idFiliere'])){
$id=$_GET['idFiliere'];
try{
    $bd=connect();
    $stmt = $bd->prepare(" select * from  Filiere where idFiliere=:idFiliere");
    $stmt->execute(array('idFiliere'=>$id));
    if($data=$stmt->fetch()){
      ?>
<h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;"> Modifier Filière</h1>
      <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
    <form method="POST" class="border border-2 rounded p-5 border-primary ">
     <input type="hidden" name="idFiliere"  value="<?php echo $data['idFiliere']?>">
      <div class="form-group m-3">
        <label  class="mb-1">Titre</label>
        <input type="text" class="form-control p-2 "  placeholder="Titre" name="Titre" value="<?php echo $data['titreFiliere']?>">
    </div>
    <div class="form-group m-3">
        <label  class="mb-1">Année Accréditation</label>
        <input type="text" class="form-control"  placeholder="Année Accréditation" name="AnneeA" value="<?php echo $data['anneeaccreditation']?>">
    </div>
     <div class="form-group m-3">
        <label  class="mb-1">Annee Fin Accréditation</label>
        <input type="text" class="form-control"  placeholder="Annee Fin Accréditation" name="fina" value="<?php echo $data['anneeFinaccreditation']?>">
    </div>
    <div class="form-group m-3">
        <label for="inputPassword">Le mot de passe</label>
        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="code" value="<?php echo $data['codeFiliere']?>">
    </div>
    
    <button type="submit" class="btn btn-outline-primary m-3">Modifier</button>
</form>
</div>
</div>
</div>
    
<?php 
    }
    else{

        echo'<p class="text-danger">Le Filière n\'existe pas</p>';
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
    $id=$_POST['idFiliere'];
    $titre=sanitaze($_POST['Titre']);
    $AnneeA=sanitaze($_POST['AnneeA']);
    $fina=sanitaze($_POST['fina']);
    $code=sanitaze($_POST['code']);
    try{
        $bd=connect();
        $stmt = $bd->prepare("update  Filiere set  titreFiliere=:t,codeFiliere=:code,anneeaccreditation=:A,anneeFinaccreditation=:f where idFiliere=$id");
        $stmt->execute(array('t'=>$titre,'code'=>$code,'A'=>$AnneeA,'f'=>$fina));
        header("location:Infofilliere.php?remarks=success");
    }
    catch(PDOException $e){
        echo $e;
        echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
    }
}
    ?>
</body>
</html>