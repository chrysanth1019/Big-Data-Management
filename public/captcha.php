<?php
// Start session
session_start();

// Check if GD library is available
if (!function_exists('imagecreatetruecolor')) {
    // Display a simple text captcha if GD is not available
    header('Content-Type: text/plain');
    $allowed_chars = '23456789ABCDEFGHJKLMNPRSTUVWXYZ';
    $captcha = '';
    for($i = 0; $i < 6; $i++) {
        $captcha .= $allowed_chars[rand(0, strlen($allowed_chars) - 1)];
    }
    $_SESSION['captcha'] = $captcha;
    echo $captcha;
    exit;
}

// Set the content type to image
header('Content-Type: image/png');

// Create the image
$width = 180;
$height = 50;
$image = imagecreatetruecolor($width, $height);

// Define colors
$bg = imagecolorallocate($image, 252, 248, 245); // Soft ivory background
$border = imagecolorallocate($image, 208, 90, 110); // Japanese style primary color
$text = imagecolorallocate($image, 73, 58, 60); // Text color
$grid = imagecolorallocate($image, 220, 215, 215); // Grid color

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Add border
imagerectangle($image, 0, 0, $width - 1, $height - 1, $border);

// Add grid pattern (simple Japanese grid design)
for($i = 0; $i < $width; $i += 10) {
    imageline($image, $i, 0, $i, $height, $grid);
}
for($i = 0; $i < $height; $i += 10) {
    imageline($image, 0, $i, $width, $i, $grid);
}

// Generate the captcha code - alphanumeric but exclude ambiguous characters
$allowed_chars = 'ABCDEFGHJKLMNPRSTUVWXYZ23456789';
$captcha = '';
for($i = 0; $i < 6; $i++) {
    $captcha .= $allowed_chars[rand(0, strlen($allowed_chars) - 1)];
}

// Store the captcha code in the session for verification
$_SESSION['captcha'] = $captcha;

// Add text to the image
$font = 5; // Built-in font
$x = 30;
$y = 15;

// Add characters with some variation
foreach(str_split($captcha) as $char) {
    // Alternate colors for better visibility
    $char_color = (rand(0, 1) == 0) ? $text : $border;
    
    // Add the character with slight y-position variation
    imagestring($image, $font, $x, $y + rand(-3, 3), $char, $char_color);
    $x += 20;
}

// Add some random noise dots
for($i = 0; $i < 50; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $border);
}

// Output the image
imagepng($image);

// Free up memory
imagedestroy($image);
?>