<?php
function connect()
{
    $pdo = new PDO('mysql:host=localhost;dbname=contact;charset=utf8', 'root', '');
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    return $pdo;
}
function sanitaze($var)
{
//     $r = isset($var) ? htmlspecialchars(trim($var)) : "";
     $r=$var;
     if(isset($var)){
       $r=  trim($var);
       $r=  htmlspecialchars(trim($var));
       $r= stripslashes($r);
     }
   
    
    return $r;
}
function sanitazeEmail($var)
{
    $r=$var;
    if(isset($var)){
        $r=  trim($var);
        $r=filter_var($var,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $r=filter_var($var,FILTER_SANITIZE_EMAIL);
    }
    return $r;
}
function sanitazeint($var)
{
    $r=$var;
    if(isset($r)){
        $r=  trim($r);
        $r=filter_var($r,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $r=filter_var($r,FILTER_SANITIZE_NUMBER_INT);
    }
    return $r;
}
// function sanitazestring($var)
// {
//     $r=$var;
//     if(isset($r)){
//         $r=  trim($r);
//         $r=filter_var($r,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//         $r=filter_var($r,FILTER_SANITIZE_STRING);
//     }
//     return $r;
// }
function getgroup()
{
    $G = array();
    
    try {
        
        $bd = connect();
        $stmt = $bd->prepare('select  * from groupe ');
        $stmt->execute();
        while ($data = $stmt->fetch()) {
            $G[] = $data;
        }
    } catch (Exception $ex) {
        echo "error";
    }
    
    return $G;
}
function printcheckbox($key, $lab)
{
    $check = '<div class="form-check">
    <input  name="group[]"   class="form-check-input mx-5" type="checkbox" value="' . $key . '" required>
    <label class="form-check-label"> ' . $lab . ' </label>
			</div>';
    echo $check;
}
 function getuser()
{
    $G = array();
    
    try {
        
        $bd = connect();
        $stmt = $bd->prepare('select  * from user ');
        $stmt->execute();
        while ($data = $stmt->fetch()) {
            $G[] = $data;
        }
    } catch (Exception $ex) {
        echo "error";
    }
    
    return $G;
}
function uploadFile($target_dir, $fileToUpload, $extensions, &$fileName)
{
    $uploadOk = true;
    
    $upperExtensions = [];
    foreach ($extensions as $i) {
        $upperExtensions[] = strtoupper($i);
    }
    
    // On normalise le nom du fichier
    $fileNameRand = randomizeFileName(basename($_FILES[$fileToUpload]["name"]));
    $fileName = $fileNameRand;
    
    // $target_dir le dossier qui va contenir les fichier
    $target_file = $target_dir . $fileNameRand;
    
    // Obtenir l'extension du fichiers
    $imageFileType = strtoupper(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Vérifier que cette extension est acceptable
    if (! in_array($imageFileType, $upperExtensions)) {
        $uploadOk = false;
    }   
    // Vérifier la taille du fichier
    if ($_FILES[$fileToUpload]["size"] > 4096) {
        
        $uploadOk = false;
    }
    
    // Si y a pas de problèmes
    if ($uploadOk) {
        
        // Déplacer le fichier vers son emplacement sur le serveur
        $upload = move_uploaded_file($_FILES[$fileToUpload]["tmp_name"], $target_file);
        
        // On retourne le status de l'upload
        return $upload;
    }
    
    return false;
}


