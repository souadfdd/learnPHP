<?php
$messages['required_field'] = array(
    'FR' => 'Le champ {1} est obligatoire',
);

$messages['empty_choice'] = array(
    'FR' => 'Le champ {1} doit avoir au moins un choix',
);

$messages['samall_value'] = array(
    'FR' => 'Le champ {1} doit être supérieur à {2}',
    
);

$messages['invalide_value'] = array(
    
    'FR' => 'La valeur saisie dans le champ {1} est invalide',
  



function getValidationMessage($errorName, $associ)
{
    global $messages;
    // On sélectionne le message
    $msg = $messages[$errorName][getLanguage()];
    
    // On remplace tous paramètres par leurs valeurs
    foreach ($associ as $key => $val) {
        
        $msg = str_replace('{' . $key . '}', $val, $msg);
    }
    
    return $msg;
}
?>