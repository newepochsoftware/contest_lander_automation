<?php

/**
 * Dynamix API Connector
 * 
 */

$user = new \Dynamix\API\User($api_email, $dynamixkey);

if ($api = new \Dynamix\API\API($user)){
  $template = new \Dynamix\API\Template();
  $template->setName($templates[$template_name]);
  
  if($template){
    $profile = $api->loadProfile($template);
    $profileName = strtolower($profile->getName());
  } else {
    echo "Error: Template not loaded";
  }
} else {
  echo "Error: invalid email or key.";
}
