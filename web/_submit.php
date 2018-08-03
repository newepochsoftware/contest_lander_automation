<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    $profileName = $_SESSION["dynamix.profile.xid"];
    $ip = filter_input(INPUT_SERVER, "REMOTE_ADDR");
    $post = json_encode($_POST);
    error_log("Contest Lander [$profileName] [$ip] [$post]");

    require '_creds.php';
    require_once 'nes/Colugo/API.php';

    $user = new \Colugo\API\User($api_email, $glowfishkey);
    $api = new \Colugo\API\API($user);

    $queryString = filter_input(INPUT_POST, "query_string");
    $qsMap = [
        "Campaign"          => "campaign",
        "Ad Group"          => "adgroupid",
        "Feed Item Id"      => "feeditemid",
        "Target Id"         => "targetid",
        "Loc Physical Ms"   => "loc_physical_ms",
        "Loc Interest Ms"   => "loc_interest_ms",
        "Match Type"        => "matchtype",
        "Network"           => "network",
        "Device"            => "device",
        "Device Model"      => "devicemodel",
        "If Search"         => "ifsearch",
        "If Content"        => "ifcontent",
        "Creative"          => "creative",
        "Keyword"           => "keyword",
        "Placement"         => "placement",
        "Ad Position"       => "adposition"
    ];
    $qs = [];
    parse_str($queryString, $qs);

    $firstName  = trim(filter_input(INPUT_POST, "fname"));
    $lastName   = trim(filter_input(INPUT_POST, "lname"));
    $email_addr = trim(filter_input(INPUT_POST, "email"));
    $phone      = preg_replace("/\D/", "", trim(filter_input(INPUT_POST, "phone")));
    $zip        = trim(filter_input(INPUT_POST, "zip"));
    $optin      = trim(filter_input(INPUT_POST, "agecheck"));
    $lvToken    = filter_input(INPUT_POST, "leadverified_token");
    $_SESSION["leadverified_token"] = $lvToken;

    if ($firstName && $lastName && $email_addr) {
        // must include first, last and email
        $lead = new \Colugo\API\Lead();
        $lead->setLeadSource("p1440lander");
        $lead->setLeadIpAddress($ip);
        $fields = [
            "Profile"       => $profileName,
            "First Name"    => $firstName,
            "Last Name"     => $lastName,
            "Mobile Phone"  => $phone,
            "Email"         => $email_addr,
            "Zip"           => $zip,
            "Query String"  => $queryString,
            "HTTP Referer"  => filter_input(INPUT_POST, "http_referer"),
            "HTTP User Agent" => filter_input(INPUT_SERVER, "http_user_agent"),
            "LeadVerified Token" => $lvToken
        ];
        foreach ($qsMap as $fieldName => $qName) {
            if (isset($qs[$qName])) {
                $fields[$fieldName] = $qs[$qName];
            }
        }
        $lead->setFields($fields);
        $api->post($lead);
        // store the lead id into the session
        $_SESSION["lead_id"] = $lead->getId();
    }
}

echo json_encode(["status" => "success"]);


