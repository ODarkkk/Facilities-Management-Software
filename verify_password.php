<?php

function securePassword($password) {
    // Check if password has at least 12 characters
    if (strlen($password) < 12) {
        return false;
    }
    
    // Check if password contains at least 1 special character
    if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
        return false;
    }
    
    // Check if password is not sequential
    for ($i = 0; $i < strlen($password) - 1; $i++) {
        $char1 = ord($password[$i]);
        $char2 = ord($password[$i + 1]);
        
        // If characters are sequential, return false
        if ($char2 - $char1 == 1) {
            return false;
        }
    }
    
    // If passed all checks, return true
    return true;
}

?>