 <?php 
 require_once('../includes/header.php');
 require_once('../includes/functions.php');
 require_once('../includes/Navbar.php');
 ?>
 <h1  class="m-5" style="color:green;text-align:center ;font-family: 'Noto Serif', serif;">Importer Matiere</h1>
 <div class="container " style="color:#784131;font-family: 'Noto Serif', serif;">
     <div class="row align-items-center justify-content-center align-items-center">
     <div class="col-6">
 <form enctype="multipart/form-data" method="post" role="form" class="border border-2 rounded p-5 border-primary ">
    <div class="form-group mt-3">
        <label for="exampleInputFile" class="mb-1">Importer un fichier</label>
        <input type="file" name="file" id="file" size="150">
        <p class="help-block mr-1" style="color:red">Seulement fichier Excel/CSV  a importé.</p>
    </div>
    <button type="submit" class="btn btn-outline-primary m-3" name="Import" value="Import">Importer</button>
</form>
 </div>
 </div>
 </div>
 <?php 
 if(isset($_POST["Import"]))
 {
     try{
     $bd=connect(); 
     echo $filename=$_FILES["file"]["tmp_name"];
     if($_FILES["file"]["size"] > 0)
     {
         $file = fopen($filename, "r");
         while (($emapData = fgetcsv($file, 10000, ";")) !== FALSE)
         {
             //print_r($emapData);
             //exit(); 
             $sql="INSERT into  INSERT into Matiere (nom,code_matiere,idModule) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]')";
             $bd->exec($sql);
             header("location: info_matiere.php?remarks=success");
         }
         fclose($file);
         echo ' Le fichier CSV a été importé avec succès';
     }
     else
         echo 'Fichier non valide : veuillez importer  un fichier CSV';
 }
 catch(Exception $e){
     echo '<p style="color:orange">l\'identifiant d\'un  module n\'existe pas ou plus </p>';
     
 }
 }
 ?>
 <?php 
 require_once('../includes/footer.php')
 ?>