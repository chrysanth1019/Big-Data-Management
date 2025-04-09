<?php
// Set the file name and file path
$fileName = 'japanese-search-app.zip';
$filePath = realpath(__DIR__ . '/../'); // Parent directory of public folder

// Create a new ZipArchive instance
$zip = new ZipArchive();

// Create a temporary file for the zip
$tmpFile = tempnam(sys_get_temp_dir(), 'zip');

// Open the zip file
if ($zip->open($tmpFile, ZipArchive::CREATE) === TRUE) {
    // Function to add files and folders to zip recursively
    function addFilesToZip($dir, $zip, $rootPath = '') {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they will be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = ($rootPath === '') ? substr($filePath, strlen($dir) + 1) : 
                                                     $rootPath . '/' . substr($filePath, strlen($dir) + 1);
                
                // Skip the zip file itself and Replit configuration files
                $skipFiles = array('.replit', 'replit.nix', basename(__FILE__));
                if (in_array(basename($filePath), $skipFiles)) {
                    continue;
                }
                
                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    // Add app folder
    if (is_dir($filePath . '/app')) {
        addFilesToZip($filePath . '/app', $zip, 'app');
    }
    
    // Add public folder (excluding the download script itself)
    if (is_dir($filePath . '/public')) {
        addFilesToZip($filePath . '/public', $zip, 'public');
    }
    
    // Add resources folder
    if (is_dir($filePath . '/resources')) {
        addFilesToZip($filePath . '/resources', $zip, 'resources');
    }
    
    // Add routes folder
    if (is_dir($filePath . '/routes')) {
        addFilesToZip($filePath . '/routes', $zip, 'routes');
    }
    
    // Close the zip file
    $zip->close();
    
    // Set headers for download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . filesize($tmpFile));
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Read the file and output to the browser
    readfile($tmpFile);
    
    // Delete the temporary file
    unlink($tmpFile);
    exit;
} else {
    echo 'Failed to create zip file.';
}
?>