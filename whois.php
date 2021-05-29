<?php
/*
 * https://www.wolnadomena.pl/whois.php?domain=softreck.com
 * http://localhost:8080/whois.php?domain=softreck.com
 */

// Load composer framework
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require(__DIR__ . '/vendor/autoload.php');
}

use phpWhois\Whois;

require("apifunc.php");

header('Content-Type: application/json');

try {
    $domain = $_GET['domain'];
//    $domain = 'softreck.com';

    if (empty($domain)) {
        throw new Exception("domain is empty");
    }

    $domain = strtolower($domain);

    apifunc([
        'https://php.defjson.com/def_json.php'
    ], function () {

        global $domain;

        $whois = new Whois();
        $result = $whois->lookup($domain, false);

        echo def_json("", [
            "whois" => $result['regrinfo'],
            "domain" => $domain
        ]);
    });

} catch (Exception $e) {
    // Set HTTP response status code to: 500 - Internal Server Error
    echo def_json("", [
            "message" => $e->getMessage(),
            "domain" => $domain
        ]
    );
}