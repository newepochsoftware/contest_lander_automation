<?php 
/**
 * Copy a file, or recursively copy a folder and its contents
 * 
 * @author      Aidan Lister <aidan@php.net>, Tom Madrid <tom@newepochsoftware.com>
 * @version     1.0.2
 * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
 * 
 * @param       string   $source      Source path
 * @param       string   $dest        Destination path
 * @param       bool     $mkdir       Defaults to false, throws error if destination isn't found. TRUE creates destination directory.
 * @param       int      $permissions New folder creation permissions
 * 
 * @return      bool     Returns true on success, false on failure
 * 
 */
function xcopy($source, $dest, $mkdir = false, $permissions = 0755)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        // Non-destructively throws error if destination is not found/doesn't exist.
        if(!$mkdir){
          return "Error, destination directory not found. Use 'xcopy([source], [dest], TRUE)' to make the destination directory." ;
        } else {
          mkdir($dest, $permissions);
        }
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        xcopy("$source/$entry", "$dest/$entry", $permissions);
    }

    // Clean up
    $dir->close();
    return true;
}