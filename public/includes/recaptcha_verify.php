<?php
/**
 * Google reCAPTCHA verification function
 * 
 * @param string $recaptchaResponse The g-recaptcha-response from the form
 * @return bool True if verification passes, false otherwise
 */
function verifyRecaptcha($recaptchaResponse) {
    // If there's no response, verification fails
    if (empty($recaptchaResponse)) {
        return false;
    }
    
    // Get the secret key from environment variables
    $secretKey = getenv('RECAPTCHA_SECRET_KEY');
    
    // Verify the reCAPTCHA response with Google
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    ];
    
    // Use cURL to make the request to Google's verification API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Decode the JSON response
    $responseData = json_decode($response, true);
    
    // Return true if the verification was successful
    return isset($responseData['success']) && $responseData['success'] === true;
}