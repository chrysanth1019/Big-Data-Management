<?php

/**
 * Verifies the captcha code entered by the user against the one stored in session
 * 
 * @param string $userInput The captcha code entered by the user
 * @return bool True if captcha code is valid, false otherwise
 */
function verifyCaptcha($userInput) {
    // Check if captcha session variable exists
    if (!isset($_SESSION['captcha'])) {
        return false;
    }
    
    // Case insensitive comparison
    if (strtolower($userInput) === strtolower($_SESSION['captcha'])) {
        // Clear the captcha from session once verified
        unset($_SESSION['captcha']);
        return true;
    }
    
    return false;
}