<?php
/**
 * Zip Compress files for Dynamix
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class ZipBuilder {

  private $zip;
  private $rootdir;
  
  public function set_root($dir){
    $this->rootdir = $dir;
  }

  public function create_zip($output_dir, $zipname) {  
    $outputzip = new ZipArchive;
    if($outputzip->open($output_dir.'/'.$zipname.'.zip', ZipArchive::CREATE) === true){
      $this->zip = $outputzip;
    } else {
      return false;
    }
  }

  public function close_zip(){
    if($this->zip->close()){
      echo "SUCCESS.\r\n";
    }
  }

  public function add_files($file, $newfilename) {
    if(!$this->rootdir) {
      echo "Root directory not set!";
      exit;
    }

    if($this->zip){
      $this->zip->addFile($this->rootdir.'/'.$file, $newfilename);
    } else {
      throw new Exception("File could not be added.");
    }
  }

  public function add_subs($dir) {
    
    if(!$this->rootdir) {
      echo "Root directory not set!";
      exit;
    }

    $fullpath_dir = $this->rootdir.'/'.$dir;
    $handle = opendir($fullpath_dir);

    echo "\r\nReading contents of: ".$fullpath_dir."\r\n";
    
    while (false !== ($entry = readdir($handle))) {
      $fullpath_entry = $fullpath_dir."/".$entry;
      if ($entry != "." && $entry != ".." && $entry != '.DS_Store'){
        if(!is_dir($fullpath_entry)){
          $this->zip->addFile($fullpath_entry, $dir .'/'. $entry);
          echo ' + '.$fullpath_entry." added. \r\n";
        } else {
          echo "\r\n".$fullpath_entry." is a sub directory.";
          
          $this->add_subs($dir.'/'.$entry);
        }
      }
    }
  }
}


$homedir   = dirname(__FILE__);
$webdir    = $homedir."/web";
$parentdir = dirname(__FILE__, 2);

$zips = array(
  'lander'  =>  'index.html', 
  'policy'  =>  'policy.html',
  'thanks'  =>  'thank-you.html'
);

foreach($zips as $k => $v){

  $required_dirs  = array('css', 'img', 'js');

  $buildZip = new ZipBuilder;
  $buildZip->create_zip($parentdir, $k);
  $buildZip->set_root($webdir);

  foreach($required_dirs as $sub){
    $buildZip->add_subs($sub);
  }
  $buildZip->add_files($v, 'index.html');

  $buildZip->close_zip();
}
