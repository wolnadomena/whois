<?php
/*
 * https://whois.wolnadomena.pl/whois.php?domain=softreck.com
 * http://localhost:8080/whois.php?domain=softreck.com
 */
//error_reporting(E_ERROR | E_PARSE);

// Load composer framework
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require(__DIR__ . '/vendor/autoload.php');
}

use phpWhois\Whois;

require("apifunc.php");

$domain = '';
$whois = [];
$message = '';
$status = false;

try {

    if (!isset($_GET['domain'])) {
        throw new Exception("domain param not exist");
    }

    $domain = $_GET['domain'];

    if (empty($domain)) {
        throw new Exception("domain is empty");
    }

    $domain = strtolower($domain);

    $whois = new Whois();
    $result = $whois->lookup($domain, false);
    $whois = $result['regrinfo'];
    $status = true;

} catch (Exception $e) {
    // Set HTTP response status code to: 500 - Internal Server Error
    $message = $e->getMessage();
}



header('Content-Type: application/json');

apifunc([
    'https://php.defjson.com/def_json.php'
], function () {

    global $domain, $whois, $message, $status;

    echo def_json("", [
        "whois" => $whois,
        "message" => $message,
        "domain" => $domain,
        "status" => $status
    ]);
});