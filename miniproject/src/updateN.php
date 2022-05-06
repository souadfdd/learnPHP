<?php 
require_once('../includes/functions.php');
include_once '../includes/header.php';
include_once '../includes/Navbar.php';
?>
<?php
if(isset($_GET['idNiveau'])){
$id=$_GET['idNiveau'];
try{
    $bd=connect();
    $stmt = $bd->prepare(" select * from  Niveau where idNiveau=:idNiveau");
    $stmt->execute(array('idNiveau'=>$id));
    if($data=$stmt->fetch()){
        ?>
     
    <h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;"> Modifier Niveau</h1>
     <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
     <form  action="proccesN.php" method="POST" class="border border-2 rounded p-5 border-primary mt-2 ">
      <input type="hidden" name="idNiveau" value="<?php echo $data['idNiveau']?>">
   <div class="form-group m-3">
        <label  class="mb-1">Titre</label>
        <input type="text" class="form-control"  placeholder="Titre" name="Ni" value="<?php echo $data['titre_niveau']?>">
    </div>
    <div class="form-group m-3">
        <label  class="mb-1">Alias</label>
        <input type="text" class="form-control"  placeholder="Alias" name="Al" value="<?php echo $data['alias']?>">
    </div>
    <div class="form-group m-3">
      <label  class="mb-1">Filière</label>
    <select class="form-select" name="fil" value="<?php echo $data['idFiliere']?>">
    <option  value="" selected disabled >!-----choisir un Filière-----!</option>
    <?php
    $FilList = getFillier();
    foreach($FilList as $it){
        echo printcheckbox($it['idFiliere'], $it['titreFiliere']);
    }
?>
</select>
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
if(isset($_POST['idNiveau'])){
$id=$_POST['idNiveau'];
$Ni=sanitaze($_POST['Ni']);
$Al=sanitaze($_POST['Al']);
$FIL=sanitaze($_POST['fil']);
try{
    $bd=connect();
    $stmt = $bd->prepare("update set Niveau titre_niveau=:Ni, alias=:Al, idFiliere=:Fil where idNiveau=$id");
    $stmt->execute(array('Ni'=>$Ni,'Al'=>$Al,'Fil'=>$FIL));
    header("location:info_niveau.php?remarks=success");
    
}
catch(PDOException $e){
    echo $e;
    echo'<p class="text-danger m-5 fs-3">opération a échoué</p>';
    
}
}
?>
<?php
include_once '../includes/footer.php'
?>
