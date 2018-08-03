<?php
#error_reporting(E_ERROR | E_PARSE);

# https://packagist.org/packages/sunra/php-simple-html-dom-parser
# http://nimishprabhu.com/top-10-best-usage-examples-php-simple-html-dom-parser.html

require '_xcopy.php';
require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

function convertHTMLtoPHPTemplate($file, $dir){
  /**
   * Check for valid directory
   */
  if(!is_dir($dir)){
    return "err: no directory found. (".$dir.") \r\n";
    exit;
  }

  /**
   * Check for valid file, read contents of file
   */
  if(file_exists($dir."/".$file)){
    $html = file_get_contents($dir."/".$file);
  } else {
    return "err: no file found. (".$dir."/".$file.") \r\n";
    exit;
  }

  /**
   * Search file contents for elements
   * with "data-xid" attribute
   */
  $dom = HtmlDomParser::str_get_html($html);
  $xids = $dom->find('[data-xid]');

  foreach ($xids as $xid) {
    $value = $xid->getAttribute('data-xid'); /** Get the value of the data-xid attribute */
    $xid->innertext = ''; /** Dump the innerHTML of said elements */
    $xid->innertext = '<?= $profile->xid("'.$value.'") ?>'; /** Replace with php tagged xid element and value */
  }

  $footer = $dom->getElementByID('footer');
  $footer->outertext = $footer->outertext . "<?php echo \"<script>var profileURL = '\".\$profileName.\"';</script>\"; ?>\r\n";

  if(class_exists('tidy')){
    $dom = tidy_parse_string($dom);
  }

  /**
   * Write output to .php file
   */
  $script_file = explode(".", $file)[0].".php";
  $fp = fopen("../".$script_file, 'w+');

  /**
   * prepend code to template files
   */
  $phpcode = "<?php\r\n";
  $phpcode.= "require_once dirname(__FILE__).'/nes/Dynamix/API.php';\r\n";

  /** Debug option, if needed */
  $phpcode.= "if(isset(\$_GET['debug'])){\r\n";
  $phpcode.= "ini_set('display_errors', 1);\r\n";
  $phpcode.= "ini_set('display_startup_errors', 1);\r\n";
  $phpcode.= "error_reporting(E_ALL);\r\n}\r\n\r\n";
  
  $phpcode.= "\$template_name = '".explode(".", $file)[0]."';\r\n"; /** Uses the template name as mapping back to templates array in the _creds.php file */

  $phpcode.= "require dirname(__FILE__).'/_creds.php';\r\n";
  $phpcode.= "require dirname(__FILE__).'/_dynamix.php';\r\n";
  $phpcode.= "?>\r\n";

  $fw = fwrite($fp, $phpcode.$dom);
  fclose($fp);

  return $file." Conversion complete.\r\n";
}

/** Set templates directory */
$directory = 'web';

/** Filter all but .html files */
$scanned_directory = array_values(array_filter(scandir($directory), function($v){
  return strpos($v, '.html');
}));

/** Convert html templates to php templates */
foreach($scanned_directory as $files){
  /** Added echo and "br" for readability from a browser */
  echo convertHTMLtoPHPTemplate($files, $directory)."<br>";
}

$homedir    = dirname(__FILE__);
$webdir     = $homedir."/web";
$parentdir  = dirname(__FILE__, 2);

if (xcopy($webdir, $parentdir)){
  echo "Conversion and webroot directory preparation complete.";
}

